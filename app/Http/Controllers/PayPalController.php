<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\Payment;

class PayPalController extends Controller
{

    public function payment(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $totalUSD = $request->input('final_total_usd');
        $customer_id = $request->input('customer_id');
        $shipping_method = $request->input('shipping_method');
        $order_note = $request->input('order_note', '');
        $address = $request->input('address');
        DB::beginTransaction();
        try {
            $shipping_date = now()->clone();
            switch ($shipping_method) {
                case 'SHIP00':
                    $shipping_date->addDays(2);
                    break;
                case 'SHIP01':
                    $shipping_date->addDay();
                    break;
                case 'SHIP02':
                    $shipping_date->addDays(4);
                    break;
            }
            $order = Order::create([
                'customer_id' => $customer_id,
                'shipping_id' => $shipping_method,
                'order_note' => $order_note,
                'address' => $address,
                'shipping_date' => $shipping_date,
                'order_date' => now(),
                'order_status' => 'Pending',
                'order_id' => $this->generateOrderId(),
            ]);
            foreach (session('cart', []) as $productId => $item) {
                $product = Product::find($productId);
                if ($product) {
                    $product->decrement('product_amount', $item['quantity']);
                }
                OrderDetail::create([
                    'order_id' => $order->order_id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
            Payment::create([
                'order_id' => $order->order_id,
                'payment_id' => $this->generatePaymentId(),
                'payment_method' => 'PayPal',
                'payment_status' => 'Pending',
                'payment_gateway' => 'PayPal',
            ]);
            DB::commit();
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('paypal.payment.success', ['order_id' => $order->order_id]),
                    "cancel_url" => route('paypal.payment.cancel'),
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => $totalUSD,
                        ]
                    ]
                ]
            ]);
            if (isset($response['id']) && $response['id'] != null) {
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        return redirect()->away($links['href']);
                    }
                }
            }
            return redirect()
                ->route('checkout')
                ->with('error', 'Lỗi tạo đơn hàng PayPal.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error during payment process', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()
                ->route('checkout')
                ->with('error', 'Đã xảy ra lỗi khi xử lý đơn hàng.');
        }
    }

    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        // Lấy `order_id` từ query string
        $orderId = $request->query('order_id');
        $response = $provider->capturePaymentOrder($request->query('token'));

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            // Cập nhật trạng thái thanh toán
            $paymentUpdated = Payment::where('order_id', $orderId)
                ->update(['payment_status' => 'Completed']);

            // Xóa session giỏ hàng
            session()->forget('cart');
            session()->forget('shipping_method');
            session()->forget('shipping_address');
            session()->forget('shipping_cost');

            return redirect()
                ->route('checkout.success')
                ->with('success', 'Thanh toán PayPal thành công và đơn hàng đã được xử lý.');
        } else {
            return redirect()
                ->route('checkout.failure')
                ->with('error', $response['message'] ?? 'Lỗi thanh toán.');
        }
    }
    public function paymentCancel()
    {
        return redirect()
            ->route('checkout')
            ->with('error', 'Bạn đã hủy thanh toán.');
    }

    private function generateOrderId()
    {
        $maxOrderId = Order::max('order_id');
        return $maxOrderId
            ? 'ORD' . str_pad(intval(substr($maxOrderId, 3)) + 1, 2, '0', STR_PAD_LEFT)
            : 'ORD01';
    }

    private function generatePaymentId()
    {
        $maxPaymentId = Payment::max('payment_id');
        return $maxPaymentId
            ? 'PAY' . str_pad(intval(substr($maxPaymentId, 3)) + 1, 2, '0', STR_PAD_LEFT)
            : 'PAY01';
    }
}

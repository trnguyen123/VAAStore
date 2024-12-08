<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;

class PayPalController extends Controller
{
    public function index()
    {
        return view('pages.paypal');
    }

    public function payment(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        // Lấy tổng tiền USD từ request
        $totalUSD = $request->input('final_total_usd');

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.payment.success'),
                "cancel_url" => route('paypal.payment/cancel'),
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
            return redirect()
                ->route('checkout')
                ->with('error', 'Lỗi thanh toán.');
        } else {
            return redirect()
                ->route('checkout')
                ->with('error', $response['message'] ?? 'Lỗi thanh toán.');
        }
    }

    public function paymentCancel()
    {
        return redirect()
            ->route('checkout')
            ->with('error', 'Bạn đã hủy thanh toán.');
    }

    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            DB::beginTransaction();
            try {
                Log::info('PayPal payment successful', ['response' => $response]);                
                // Tính ngày giao hàng
                $shipping_date = now()->clone();
                switch ($request->input('shipping_method')) {
                    case 'SHIP00': // Nhanh
                        $shipping_date->addDays(2);
                        break;
                    case 'SHIP01': // Hỏa tốc
                        $shipping_date->addDay();
                        break;
                    case 'SHIP02': // Tiết kiệm
                        $shipping_date->addDays(4);
                        break;
                }

                // Xác định khách hàng
                $customer_id = Auth::check() ? Auth::id() : null;

                // Lưu thông tin đơn hàng
                $order = Order::create([
                    'customer_id' => $customer_id,
                    'shipping_id' => $request->input('shipping_method'),
                    'order_note' => $request->input('order_note', ''),
                    'address' => $request->input('address'),
                    'shipping_date' => $shipping_date,
                    'order_date' => now(),
                    'order_status' => 'Pending',
                    'order_id' => $this->generateOrderId(),
                ]);

                Log::info('Order created', ['order' => $order]);

                // Lưu chi tiết đơn hàng
                foreach (session('cart', []) as $productId => $item) {
                    OrderDetail::create([
                        'order_id' => $order->order_id,
                        'product_id' => $productId,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);
                }

                Log::info('Order details added');

                // Lưu thông tin thanh toán
                Payment::create([
                    'order_id' => $order->order_id,
                    'payment_id' => $this->generatePaymentId(),
                    'payment_method' => 'PayPal',
                    'payment_status' => 'Completed',
                    'payment_gateway' => 'PayPal',
                ]);

                Log::info('Payment saved', ['order_id' => $order->order_id]);

                // Tính tổng chi phí bao gồm phí vận chuyển
                $totalCost = collect(session('cart', []))->sum(function ($item) {
                    return $item['quantity'] * $item['price'];
                });

                $shippingCost = session('shipping_cost', 0);
                $totalCost += $shippingCost;

                $order->update(['total_cost' => $totalCost]);

                Log::info('Order total updated', ['total_cost' => $totalCost]);

                // Xác nhận giao dịch
                DB::commit();

                // Xóa session giỏ hàng
                session()->forget('cart');
                session()->forget('shipping_method');
                session()->forget('shipping_address');
                session()->forget('shipping_cost');

                Log::info('Transaction committed, cart cleared');

                return redirect()
                    ->route('checkout.success')
                    ->with('success', 'Thanh toán PayPal thành công và đơn hàng đã được xử lý.');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error processing PayPal order', ['error' => $e->getMessage()]);

                return redirect()
                    ->route('checkout.failure')
                    ->with('error', 'Đã xảy ra lỗi khi xử lý đơn hàng.');
            }
        } else {
            return redirect()
                ->route('checkout.failure')
                ->with('error', $response['message'] ?? 'Lỗi thanh toán.');
        }
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

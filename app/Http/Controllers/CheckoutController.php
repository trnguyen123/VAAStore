<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Category;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
{
    // Lấy danh mục (categories) và voucher đang hoạt động
    $categories = Category::all();
    $vouchers = Voucher::where('status', 'yes')->get();
    // Xử lý thêm sản phẩm từ `product_id` nếu được gửi qua request
    if ($request->has('product_id')) {
        $productId = $request->input('product_id');
        $product = \App\Models\Product::find($productId);
        if ($product) {
            // Lấy giỏ hàng từ session hoặc khởi tạo mảng rỗng
            $cart = session()->get('cart', []);
            // Nếu sản phẩm đã tồn tại trong giỏ hàng, tăng số lượng
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity']++;
            } else {
                // Nếu sản phẩm chưa tồn tại, thêm mới vào giỏ hàng
                $cart[$productId] = [
                    'name' => $product->product_name,
                    'price' => $product->product_price,
                    'image' => asset('public/' . $product->product_img), // Đảm bảo sử dụng thư mục `storage` nếu liên kết
                    'quantity' => 1
                ];
            }
            // Cập nhật giỏ hàng vào session
            session()->put('cart', $cart);
        } else {
            // Chuyển hướng nếu không tìm thấy sản phẩm
            return redirect()->route('allProduct')->with('error', 'Sản phẩm không tồn tại.');
        }
    }
    // Lấy giỏ hàng từ session
    $cartItems = session('cart', []);
    // Tính tổng tiền
    $total = collect($cartItems)->sum(function ($item) {
        return $item['price'] * $item['quantity'];
    });
    // Kiểm tra mã giảm giá
    $discountValue = 0;
    if ($request->has('voucher') && $request->voucher) {
        $voucher = Voucher::where('code', $request->voucher)->first();
        if ($voucher && $voucher->status == 'yes') {
            $discountValue = $voucher->discount_value;
        }
    }
    // Tính tổng tiền sau khi giảm giá
    $discountedTotal = $total - ($total * ($discountValue / 100));
    // Trả về view checkout với dữ liệu cần thiết
    return view('pages.checkout', compact('cartItems', 'categories', 'total', 'vouchers', 'discountedTotal'));
}


    public function processCheckout(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'shipping_method' => 'required|string',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
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
            // Tạo đơn hàng
            $order = Order::create([
                'customer_id' => $request->input('customer_id', null),
                'shipping_id' => $request->input('shipping_method'),
                'order_note' => $request->input('order_note', ''),
                'address' => $request->input('address'),
                'shipping_date' => $shipping_date,
                'order_date' => now(),
                'order_status' => 'Pending',
                'order_id' => $this->generateOrderId(),
            ]);
            // Thêm chi tiết đơn hàng và giảm số lượng sản phẩm trong kho
            foreach (session('cart', []) as $productId => $item) {
                // Cập nhật số lượng sản phẩm trong bảng products
                $product = Product::find($productId);
                if ($product) {
                    $product->decrement('product_amount', $item['quantity']);
                }

                // Thêm chi tiết đơn hàng
                OrderDetail::create([
                    'order_id' => $order->order_id,
                    'product_id' => $productId, 
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
            // Tạo payment
            $payment = Payment::create([
                'order_id' => $order->order_id,
                'payment_id' => $this->generatePaymentId(), 
                'payment_method' => $request->input('payment_method'),
                'payment_status' => 'Pending',
                'payment_gateway' => $request->input('payment_method'),
            ]);
            // Tính tổng chi phí bao gồm phí vận chuyển
            $totalCost = collect(session('cart', []))->sum(function ($item) {
                return $item['quantity'] * $item['price'];
            });
            // Lấy phí vận chuyển từ request 
            $shippingCost = $request->input('shipping_cost', 0); 
            $totalCost += $shippingCost; // Cộng thêm phí vận chuyển vào tổng chi phí
            $order->update(['total_cost' => $totalCost]);
            // Xác nhận giao dịch
            DB::commit();
            // Xóa session giỏ hàng
            session()->forget('cart');
            return redirect()->route('checkout.success');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.failure')->with('error', $e->getMessage());
        }
    }

    
    private function generateOrderId(){
        $maxOrderId = Order::max('order_id');
        return $maxOrderId 
            ? 'ORD' . str_pad(intval(substr($maxOrderId, 3)) + 1, 2, '0', STR_PAD_LEFT) 
            : 'ORD01';
    }
    private function generatePaymentId(){
        // Lấy ID thanh toán lớn nhất hiện tại trong bảng 'payments'
        $maxPaymentId = Payment::max('payment_id');

        // Tạo Payment ID mới
        return $maxPaymentId 
            ? 'PAY' . str_pad(intval(substr($maxPaymentId, 3)) + 1, 2, '0', STR_PAD_LEFT) 
            : 'PAY01'; 
    }

} 
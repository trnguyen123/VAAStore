<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        // Kiểm tra xem sản phẩm có tồn tại không
        $product = Product::find($request->input('product_id'));
        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Sản phẩm không tồn tại.']);
        }

        // Lấy giỏ hàng từ session
        $cartItems = session('cart', []);

        // Thêm sản phẩm vào giỏ hàng
        if (isset($cartItems[$request->input('product_id')])) {
            $cartItems[$request->input('product_id')]['quantity']++;
        } else {
            $cartItems[$request->input('product_id')] = [
                'name' => $product->product_name,
                'price' => $product->product_price,
                'image' => asset('public/' . $product->product_img),
                'quantity' => 1
            ];
        }
        // Lưu giỏ hàng vào session
        session(['cart' => $cartItems]);

        // Trả về phản hồi
        return response()->json([
            'status' => 'success',
            'cart_count' => count($cartItems),
            'cart_items' => array_map(function($item, $id) {
                $item['product_id'] = $id;
                return $item;
            }, array_values($cartItems), array_keys($cartItems))
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $cartItems = session('cart', []);
        if (isset($cartItems[$request->input('product_id')])) {
            unset($cartItems[$request->input('product_id')]);
        }
        session(['cart' => $cartItems]);

        return response()->json([
            'status' => 'success',
            'cart_count' => count($cartItems),
            'cart_items' => array_map(function($item, $id) {
                $item['product_id'] = $id;
                return $item;
            }, array_values($cartItems), array_keys($cartItems))
        ]);
    }

    public function updateCartQuantity(Request $request)
    {
        $cartItems = session('cart', []);
        if (isset($cartItems[$request->input('product_id')])) {
            $cartItems[$request->input('product_id')]['quantity'] = $request->input('quantity');
        }
        session(['cart' => $cartItems]);

        return response()->json([
            'status' => 'success',
            'cart_count' => count($cartItems),
            'cart_items' => array_map(function($item, $id) {
                $item['product_id'] = $id;
                return $item;
            }, array_values($cartItems), array_keys($cartItems))
        ]);
    }
}

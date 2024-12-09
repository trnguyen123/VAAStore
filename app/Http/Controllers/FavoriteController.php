<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    // Thêm sản phẩm vào danh sách yêu thích
    public function addFavorite(Request $request)
    {
        $customerId = $request->input('customer_id');
        $productId = $request->input('product_id');

        // Lưu sản phẩm vào bảng favorites
        Favorite::create([
            'customer_id' => $customerId,
            'product_id' => $productId,
        ]);

        return response()->json(['message' => 'Product added to favorites'], 201);
    }

    // Lấy danh sách yêu thích của người dùng
    public function getFavorites($customerId)
    {
        $favorites = Favorite::where('customer_id', $customerId)->with('product')->get();
        return response()->json($favorites, 200);
    }

    // Xóa sản phẩm khỏi danh sách yêu thích
    public function removeFavorite(Request $request)
    {
        $customerId = $request->input('customer_id');
        $productId = $request->input('product_id');

        Favorite::where('customer_id', $customerId)
                ->where('product_id', $productId)
                ->delete();

        return response()->json(['message' => 'Product removed from favorites'], 200);
    }
}

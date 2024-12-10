<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use Illuminate\Support\Facades\Log;

class FavoriteController extends Controller
{
    // Thêm sản phẩm vào danh sách yêu thích
    public function addFavorite(Request $request)
    {
        Log::info('Add Favorite Request Received', $request->all());

        $customerId = $request->input('customer_id');
        $productId = $request->input('product_id');

        // Lưu sản phẩm vào bảng favorites
        try {
            Favorite::create([
                'customer_id' => $customerId,
                'product_id' => $productId,
            ]);
            Log::info('Product added to favorites', ['customer_id' => $customerId, 'product_id' => $productId]);
            return response()->json(['message' => 'Product added to favorites'], 201);
        } catch (\Exception $e) {
            Log::error('Error adding product to favorites', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to add product to favorites'], 500);
        }
    }

    public function showFavoritePage()
    {
        Log::info('Favorites page requested');
        return view('pages.favorites');
    }

    public function getFavorites(Request $request)
    {
        Log::info('Get Favorites Request Received', $request->all());

        $customer_id = $request->input('customer_id');

        if (!$customer_id) {
            Log::warning('Customer ID missing in getFavorites');
            return response()->json(['success' => false, 'message' => 'Customer ID is missing'], 400);
        }

        try {
            $favorites = Favorite::where('customer_id', $customer_id)
                ->with('product') // Eager loading sản phẩm liên quan
                ->get();

            if ($favorites->isEmpty()) {
                Log::info('No favorites found', ['customer_id' => $customer_id]);
                return response()->json(['success' => false, 'message' => 'No favorites found'], 404);
            }

            Log::info('Favorites retrieved successfully', ['customer_id' => $customer_id, 'favorites_count' => $favorites->count()]);
            return response()->json([
                'success' => true,
                'favorites' => $favorites->map(function ($favorite) {
                    return [
                        'favorite_id' => $favorite->favorite_id,
                        'product' => [
                            'product_id' => $favorite->product->product_id,
                            'name' => $favorite->product->product_name,
                            'price' => $favorite->product->product_price,
                            'image' => $favorite->product->product_img,
                        ],
                    ];
                }),
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error retrieving favorites', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to retrieve favorites'], 500);
        }
    }

    // Xóa sản phẩm khỏi danh sách yêu thích
    public function removeFavorite(Request $request)
    {
        Log::info('Remove Favorite Request Received', $request->all());

        $customerId = $request->input('customer_id');
        $productId = $request->input('product_id');

        try {
            $deleted = Favorite::where('customer_id', $customerId)
                ->where('product_id', $productId)
                ->delete();

            if ($deleted) {
                Log::info('Product removed from favorites', ['customer_id' => $customerId, 'product_id' => $productId]);
                return response()->json(['message' => 'Product removed from favorites'], 200);
            } else {
                Log::warning('No matching favorite found to remove', ['customer_id' => $customerId, 'product_id' => $productId]);
                return response()->json(['message' => 'No favorite found to remove'], 404);
            }
        } catch (\Exception $e) {
            Log::error('Error removing favorite', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to remove favorite'], 500);
        }
    }
}

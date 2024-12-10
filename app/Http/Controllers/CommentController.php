<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;

class CommentController extends Controller
{
    public function getComments($product_id)
    {
        $comments = Comment::where('product_id', $product_id)
            ->with(['customer' => function ($query) {
                $query->select('customer_id', 'full_name'); // Sử dụng customer_id thay vì id
            }])
            ->orderBy('comment_id', 'desc') // Sắp xếp theo comment_date từ mới tới cũ
            ->get(['customer_id', 'comment_rating', 'comment_content', ]); // Chỉ lấy các cột cần thiết từ comments

        return response()->json(['comments' => $comments]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'customer_id' => 'required|exists:customers,customer_id',
            'comment_rating' => 'required|integer|min:1|max:5',
            'comment_content' => 'required|string|max:1000',
        ]);

        $comment = Comment::create($validated);
        return response()->json(['success' => true, 'comment' => $comment]);
    }
}
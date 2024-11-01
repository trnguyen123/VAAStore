<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function getCategories()
    {
        // Lấy những danh mục có category_status = 'YES'
        $categories = Category::where('category_status', 'YES')->get();
        return response()->json($categories);
    }
}

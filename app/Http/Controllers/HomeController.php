<?php

namespace App\Http\Controllers;

use App\Models\Category;

class HomeController extends Controller{
    public function index() {
        $categories = Category::where('category_status', 'YES')->get();
        $categories = Category::with('products')->get();
        return view('pages.home', compact('categories')); // Trả về home với danh sách categories có status = YES
    }
}
<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $categories = Category::all(); 
        return view('pages.home', compact('categories')); // Trả về view home với danh sách categories
    }
}


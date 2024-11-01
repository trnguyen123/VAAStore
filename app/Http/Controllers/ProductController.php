<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller{
    
    public function showAddProductForm(){
        return view('admin.add_product'); // Hoặc đường dẫn view của bạn
    }

    public function add_product(Request $request) {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'product_id' => 'required|string|max:255',
            'category_id' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'product_date' => 'required|date',
            'product_description' => 'required|string',
            'product_amount' => 'required|integer',
            'product_price' => 'required|integer',
            'image' => 'nullable|image|max:2048', // Kiểm tra ảnh nếu có
        ]);

        // Xử lý ảnh (nếu có)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = 'images/' . $image->getClientOriginalName(); // Lưu tên gốc
            $image->storeAs('images', $image->getClientOriginalName(), 'public'); // Lưu file với tên gốc
        }

        // Tạo sản phẩm mới
        Product::create([
            'product_id' => $request->input('product_id'),
            'category_id' => $request->input('category_id'),
            'product_name' => $request->input('product_name'),
            'product_date' => $request->input('product_date'),
            'product_description' => $request->input('product_description'),
            'product_amount' => $request->input('product_amount'),
            'product_price' => $request->input('product_price'),
            'product_img' => $imagePath,
        ]);

        // Chuyển hướng về trang all_product
        return redirect()->route('admin.all_product')->with('success', 'Sản phẩm đã được thêm thành công!');
    }

    public function all_product(){
        // Lấy tất cả sản phẩm từ cơ sở dữ liệu
        $products = Product::all();

        // Trả về view cùng với danh sách sản phẩm
        return view('admin.all_product', compact('products'));
    }
    public function edit($id)
    {
        $product = Product::where('product_id', $id)->firstOrFail(); 
        return view('admin.edit_product', compact('product')); 
    }

    public function update(Request $request, $product_id)
{
    $product = Product::where('product_id', $product_id)->firstOrFail();

    $product->product_name = $request->input('product_name');
    $product->category_id = $request->input('category_id');
    $product->product_date = $request->input('product_date');
    $product->product_description = $request->input('product_description');
    $product->product_amount = $request->input('product_amount');
    $product->product_price = $request->input('product_price');

    if ($request->hasFile('product_img')) {
        $imagePath = $request->file('product_img')->store('products', 'public');
        $product->product_img = $imagePath;
    }

    $product->save(); 

    return redirect()->route('admin.all_product')->with('success', 'Cập nhật sản phẩm thành công!');
}

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.all_product')->with('success', 'Product deleted successfully.');
    }

    public function showProductWithCategory($category_id)
    {
        // products để lấy tất cả sản phẩm có có cat_id trùng
        $products = Product::where('category_id', $category_id)->get();
        //  categories để lấy tất cả danh mục đổ ra menu
        $categories = Category::all(); 
        // category để lấy danh mục hiện tại 
        $category = Category::find($category_id);

        // Trả về với danh sách sản phẩm
        return view('pages.product', compact('products','categories'));
    }
}

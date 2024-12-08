<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller{
    
    public function index(){
        return view('pages.product-detail');
    }
    public function showAddProductForm(){
        return view('admin.add_product'); 
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
            'image' => 'nullable|image|max:2048', 
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
        $products = Product::all();
        $products = Product::paginate(10);
        return view('admin.all_product', compact('products'));
    }

    public function edit($id){
        $product = Product::where('product_id', $id)->firstOrFail(); 
        return view('admin.edit_product', compact('product')); 
    }

    public function update(Request $request, $product_id){
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

    public function destroy($id){
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.all_product')->with('success', 'Xóa sản phẩm thành công');
    }

    public function showProductWithCategory($category_id){
        // products để lấy tất cả sản phẩm có có cat_id trùng
        $products = Product::where('category_id', $category_id)->get();
        //  categories để lấy tất cả danh mục đổ ra menu
        $categories = Category::all(); 
        // category để lấy danh mục hiện tại 
        $category = Category::find($category_id);

        // Trả về với danh sách sản phẩm
        return view('pages.product', compact('products','categories'));
    }
    //cần xem lại
    public function toggleFavorite(Request $request)
    {
        // Đảm bảo request có `product_id`
        if (!$request->has('product_id')) {
            return response()->json(['error' => 'Product ID is missing'], 400);
        }

        $product = Product::findOrFail($request->product_id);
        $product->is_favorited = !$product->is_favorited; // Đổi trạng thái yêu thích
        $product->save();

        return response()->json(['is_favorited' => $product->is_favorited]);
    }

    public function showProductDetail($product_id) {
    // Kiểm tra xem có tồn tại sản phẩm với product_id hay không
    $product = Product::where('product_id', $product_id)->firstOrFail();

    // Lấy tất cả danh mục sản phẩm
    $categories = Category::all();

    $relatedProducts = Product::where('category_id', $product->category_id)
                               ->where('product_id', '!=', $product_id)
                               ->get();

    // Trả về view với dữ liệu sản phẩm và danh mục
    return view('pages.product_detail', compact('product', 'categories', 'relatedProducts'));
    }

    public function allProduct(){
        $products = Product::all();
        $categories = Category::all(); 
        return view('pages.product', compact('products','categories'));
    }
    public function search(Request $request)
    {
        $categories = Category::all();
    $query = $request->input('query');
    $products = Product::where('product_name', 'LIKE', "%{$query}%")->paginate(8);

    return view('pages.search_results', compact('products','categories', 'query'));
    }
}

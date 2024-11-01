<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Để mã hóa
use Illuminate\Support\Facades\Validator; // Để xác thực

class HomeController extends Controller
{
    public function index() {
        $categories = Category::where('category_status', 'YES')->get();
        return view('pages.home', compact('categories')); // Trả về home với danh sách categories có status =YES
    }

    public function showLoginForm(){
        return view('pages.login');
    }

    public function login(Request $request){
        // Xác thực thông tin đầu vào
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|min:3',
        ]);

        // Thực hiện đăng nhập
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            // Đúng thì qua trang home
            return redirect()->intended('/home'); 
        }

        // Sai thì quay lại trang đăng nhập với thông báo lỗi
        return back()->withErrors([
            'username' ,'password'=> 'Thông tin đăng nhập không chính xác.',
        ]);
    }

    public function showSignupForm(){
        return view ('pages.signup');
    }

    public function signup(Request $request) {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:customers',
            'email' => 'required|string|email|max:100|unique:customers',
            'password' => 'required|string|min:3|confirmed', // 'confirmed' yêu cầu có trường 'password_confirmation' trong form đăng kí
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        // Thêm dữ liệu vào customers
        $customer = new Customer();
        $customer->username = $request->username;
        $customer->email = $request->email;
        $customer->password = Hash::make($request->password); 
        $customer->save();

        return redirect()->route('login')->with('success', 'Đăng ký thành công!'); // Quay về trang đăng nhập
    }
}

<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator; 
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use App\Models\Customer; 

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout'); // Chỉ cho phép khách đăng nhập
        $this->middleware('auth')->only('logout'); // Chỉ cho phép người đã đăng nhập thực hiện logout
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('pages.login'); // Trả về view đăng nhập, hãy chắc chắn rằng view này tồn tại
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request) {
    $credentials = $request->only('username', 'password');

    if (Auth::attempt($credentials)) {
        if (Auth::check()) {
            session(['full_name' => Auth::user()->full_name]);
            return redirect()->intended('/home');
        }
    }

    return back()->withErrors([
        'email' => 'Thông tin đăng nhập không chính xác.',
    ]);
}


    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout() {
        Auth::logout();
        session()->invalidate(); // Làm mất hiệu lực session hiện tại
        session()->regenerateToken(); // Đảm bảo token không bị tái sử dụng
        return redirect()->intended('/home');}


    /**
     * Show the application's registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showSignupForm()
    {
        return view('pages.signup'); // Trả về view đăng ký, hãy chắc chắn rằng view này tồn tại
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function signup(Request $request) {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255|',
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
        $customer->full_name = $request->full_name;
        $customer->username = $request->username;
        $customer->email = $request->email;
        $customer->password = Hash::make($request->password); 
        $customer->save();

        return redirect()->route('login');
    }
}

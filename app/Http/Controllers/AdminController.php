<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.admin_dashboard');
    }
    public function login(Request $request){
    $credentials = $request->only('Username', 'Password');

    if (Auth::guard('admins')->attempt(['username' => $credentials['Username'], 'password' => $credentials['Password']])) {
        return redirect()->intended('/admin');
    } else {
        return redirect()->back()->withErrors(['login' => 'Sai tài khoản hoặc mật khẩu!']);
    }
}
    public function showLoginForm(){
    return view('admin.admin_login'); 
    }
    
}

<?php

namespace App\Http\Controllers;
use App\Models\Customer; 
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ProfileController extends Controller{
    public function showProfile(){
        $categories = Category::all(); 
        Log::info('Session user: ', [Auth::user()]);
        // Check if the user is authenticated
        if (Auth::check()) {
        $customer = Auth::user();
        return view('pages.show-profile', compact('customer','categories'));
    } else {
        return redirect()->route('login');
    }
}

    public function editProfile() {
        $customer = Auth::user();
        
        if (!$customer) {
            Log::info('Người dùng chưa đăng nhập.');
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập trước!');
        }

        Log::info('Người dùng đã đăng nhập:', ['customer' => $customer]);
        return view('pages.edit-profile', compact('customer'));
}



    public function updateProfile(Request $request){
        $customer = Auth::user(); 
        
        if (!$customer || !($customer instanceof Customer)) {
        return redirect()->back()->with('error', 'Người dùng không tồn tại!');
    }

        $request->validate([
            'full_name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:100',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:10',
        ]);

        $customer->full_name = $request->full_name;
        $customer->email = $request->email;
        $customer->phone_number = $request->phone_number;
        $customer->address = $request->address;
        $customer->date_of_birth = $request->date_of_birth;
        $customer->gender = $request->gender;

        $customer->save();

        return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Customer; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ProfileController extends Controller{
    public function showProfile($id) {
    // Gọi hàm getProfileById để lấy dữ liệu
    $customer = Customer::find($id);

    // Kiểm tra nếu không tìm thấy customer
    if (!$customer) {
        return redirect()->back()->with('error', 'Người dùng không tồn tại!');
    }

    // Trả về view show_profile.blade.php và truyền dữ liệu customer
    return view('pages.show_profile', compact('customer'));
}

    public function getProfileById($id){
        // Truy vấn customer bằng ID
        $customer = Customer::find($id);

        // Kiểm tra xem có tìm thấy customer không
        if ($customer) {
            // Trả về thông tin customer, chỉ lấy các trường cần thiết
            return response()->json([
                'success' => true,
                'customer' => [
                    'customer_id' => $customer->customer_id,
                    'full_name' => $customer->full_name,
                    'email' => $customer->email,
                    'phone_number' => $customer->phone_number,
                    'address' => $customer->address,
                    'gender' => $customer->gender,
                    'date_of_birth' => $customer->date_of_birth,
                ]
            ]);
        } else {
            // Trả về thông báo lỗi nếu không tìm thấy customer
            return response()->json([
                'success' => false,
                'message' => 'Người dùng không tồn tại.'
            ], 404); // Lỗi 404 nếu không tìm thấy
        }
    }

    public function editProfile() {
        $customer = Auth::user();

        if (!$customer) {
            Log::info('Người dùng chưa đăng nhập.');
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập trước!');
        }

        Log::info('Người dùng đã đăng nhập:', ['customer' => $customer]);
        return view('pages.edit_profile', compact('customer'));
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

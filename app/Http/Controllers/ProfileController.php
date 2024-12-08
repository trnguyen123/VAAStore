<?php

namespace App\Http\Controllers;

use App\Models\Customer; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        // Sử dụng middleware auth để bảo vệ các phương thức
        $this->middleware('auth')->except(['getProfileById']);
    }

    public function showProfile($id)
    {
        $currentUser = Auth::user(); // Lấy thông tin người dùng hiện tại

        // Kiểm tra nếu chưa đăng nhập hoặc không có quyền truy cập hồ sơ này
        if (!$currentUser || $currentUser->customer_id != $id) {
            return redirect('/vaastore/login')->with('error', 'Bạn không có quyền truy cập hồ sơ này!');
        }

        // Lấy thông tin khách hàng từ cơ sở dữ liệu
        $customer = Customer::find($id);

        // Kiểm tra nếu không tìm thấy khách hàng
        if (!$customer) {
            return redirect()->back()->with('error', 'Người dùng không tồn tại!');
        }

        // Trả về view show_profile.blade.php với dữ liệu customer
        return view('pages.show_profile', compact('customer'));
    }

    public function getProfileById($id)
    {
        $currentUser = Auth::user(); // Lấy người dùng hiện tại

        // Kiểm tra nếu không có quyền truy cập
        if (!$currentUser || $currentUser->customer_id != $id) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền xem thông tin này.'
            ], 403); // Trả về mã lỗi 403 (Forbidden)
        }

        // Lấy thông tin khách hàng từ cơ sở dữ liệu
        $customer = Customer::find($id);

        // Nếu tìm thấy khách hàng, trả về dữ liệu dạng JSON
        if ($customer) {
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
        }

        // Nếu không tìm thấy khách hàng, trả về lỗi
        return response()->json([
            'success' => false,
            'message' => 'Người dùng không tồn tại.'
        ], 404);
    }

    public function editProfile()
    {
        $customer = Auth::user(); // Lấy thông tin người dùng hiện tại

        // Kiểm tra nếu người dùng chưa đăng nhập
        if (!$customer) {
            Log::info('Người dùng chưa đăng nhập.');
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập trước!');
        }

        Log::info('Người dùng đã đăng nhập:', ['customer' => $customer]);
        return view('pages.edit_profile', compact('customer'));
    }

    public function updateProfile(Request $request)
    {
        $customer = Auth::user(); // Lấy thông tin người dùng hiện tại

        // Kiểm tra nếu người dùng không tồn tại
        if (!$customer || !($customer instanceof Customer)) {
            return redirect()->back()->with('error', 'Người dùng không tồn tại!');
        }

        // Validate dữ liệu đầu vào
        $request->validate([
            'full_name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:100',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:10',
        ]);

        // Cập nhật thông tin người dùng
        $customer->full_name = $request->full_name;
        $customer->email = $request->email;
        $customer->phone_number = $request->phone_number;
        $customer->address = $request->address;
        $customer->date_of_birth = $request->date_of_birth;
        $customer->gender = $request->gender;

        // Lưu thay đổi vào cơ sở dữ liệu
        $customer->save();

        return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    // Hiển thị danh sách khách hàng
    public function index()
    {
        $customers = Customer::paginate(10); // Phân trang 10 khách hàng mỗi lần
        return view('admin.all_customer', compact('customers'));
    }

    // Hiển thị form chỉnh sửa khách hàng
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.edit_customer', compact('customer'));
    }

    // Cập nhật thông tin khách hàng
    public function update(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:100',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        return redirect()->route('admin.all_customer')->with('success', 'Cập nhật thành công!');
    }

    // Xóa khách hàng
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.all_customer')->with('success', 'Xóa thành công!');
    }
}


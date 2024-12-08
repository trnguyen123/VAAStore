<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;

class OrderController extends Controller
{
    // Hiển thị danh sách đơn hàng
    public function index()
    {
        $orders = Order::with('customer')->get(); // Lấy danh sách đơn hàng và thông tin khách hàng
        return view('admin.all_orders', compact('orders'));
    }

    // Hiển thị chi tiết đơn hàng
    public function show($id)
    {
        $order = Order::with(['customer', 'orderDetails.product'])->findOrFail($id);
        return view('admin.show_orders', compact('order'));
    }

    // Hiển thị form chỉnh sửa đơn hàng
    public function edit($id)
    {
        $order = Order::with(['orderDetails'])->findOrFail($id);
        return view('admin.edit_orders', compact('order'));
    }

    // Cập nhật đơn hàng
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->order_status = $request->order_status;
        $order->order_note = $request->order_note;
        $order->save();

        return redirect()->route('admin.orders')->with('success', 'Cập nhật đơn hàng thành công!');
    }

    // Xóa đơn hàng
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders')->with('success', 'Đã xóa đơn hàng!');
    }
}

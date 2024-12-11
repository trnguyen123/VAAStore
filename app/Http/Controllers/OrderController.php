<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Hiển thị danh sách đơn hàng
    public function index(Request $request)
    {
        $orders = Order::orderBy('order_date', 'desc')->paginate(10);

        // Nếu có tham số "show", lấy chi tiết đơn hàng
        $selectedOrder = null;
        if ($request->has('show')) {
            $selectedOrder = Order::find($request->input('show'));
        }

        return view('admin.all_orders', compact('orders', 'selectedOrder'));
    }

    // Hiển thị chi tiết một đơn hàng
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.show_orders', compact('order'));
    }
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.edit_orders', compact('order'));
    }

    // app/Http/Controllers/Admin/OrderController.php

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->customer_id = $request->input('customer_id');
        $order->order_date = $request->input('order_date');
        $order->order_status = $request->input('order_status');
        $order->order_note = $request->input('order_note');
        $order->shipping_date = $request->input('shipping_date');
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được cập nhật.');
    }
    // Xóa một đơn hàng
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được xóa.');
    }
}

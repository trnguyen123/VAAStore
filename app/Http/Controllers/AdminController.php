<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class AdminController extends Controller{
    public function dashboard(Request $request) {
    // Lấy ngày từ input hoặc mặc định là tất cả ngày
    $selectedDate = $request->get('selected_date');

    $query = DB::table('order_details')
        ->join('orders', 'order_details.order_id', '=', 'orders.order_id')
        ->select(
            DB::raw('DATE(orders.order_date) as date'), 
            DB::raw('SUM(order_details.price * order_details.quantity) as revenue')
        )
        ->groupBy(DB::raw('DATE(orders.order_date)'))
        ->orderBy(DB::raw('DATE(orders.order_date)'), 'asc');

    // Lọc theo ngày nếu có chọn ngày
    if ($selectedDate) {
        $query->whereDate('orders.order_date', '=', $selectedDate);
    }
    $revenueData = $query->get();
    // Log dữ liệu để kiểm tra
    Log::info('Revenue Data: ', $revenueData->toArray());
    return view('admin.admin_dashboard', compact('revenueData', 'selectedDate'));
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Log;


use Illuminate\Support\Facades\DB;

class PaymentController extends Controller{
    public function vnpay_payment(Request $request){
        $total = $request->input('total_amount'); 
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "https://localhost/vnpay_php/vnpay_return.php";
        $vnp_TmnCode = "EM5C03BH";//Mã website tại VNPAY 
        $vnp_HashSecret = "JKELNXPA68XEDQWSPUPLWXWXE5VLLIO9"; //Chuỗi bí mật
        
        $vnp_TxnRef = "1007"; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo ="Thanh toán hóa đơn";
        $vnp_OrderType = "VAA Store";
        $vnp_Amount = $total * 100;
        $vnp_Locale = "VN";
        $vnp_BankCode = "NCB";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );
        
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        
        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
            // vui lòng tham khảo thêm tại code demo
        
        }

        // Hiển thị danh sách thanh toán
        public function index(Request $request)
        {
            // Lấy danh sách thanh toán
            $payments = Payment::orderBy('payment_date', 'desc')->paginate(10);
        
            // Nếu có tham số "show", lấy chi tiết thanh toán
            $selectedPayment = null;
            if ($request->has('show')) {
                $selectedPayment = Payment::find($request->input('show'));
            }
        
            return view('admin.payment', compact('payments', 'selectedPayment'));
        }

    public function show($id)
    {
        dd('Reached here!');
        Log::info('Start retrieving payment data', ['id' => $id]);
        $payment = Payment::join('orders', 'payments.order_id', '=', 'orders.order_id')
            ->join('customers', 'orders.customer_id', '=', 'customers.customer_id')
            ->select(
                'payments.*',
                'customers.full_name as customer_name',
                'orders.order_id as order_id'
            )
            ->where('payments.payment_id', $id)
            ->firstOrFail();

        // Tính tổng tiền từ bảng order_details
        $totalAmount = OrderDetail::where('order_id', $payment->order_id)
            ->sum(DB::raw('COALESCE(quantity, 0) * COALESCE(price, 0)')); // Sử dụng COALESCE để tránh lỗi giá trị null

            
        // Ghi log thông tin tổng tiền đã tính
        Log::info('Total Amount Calculated:', ['total_amount' => $totalAmount]);

        $payment->total_amount = $totalAmount;

        // Ghi log khi total_amount được gán
        Log::info('Payment Total Amount Assigned:', [
            'payment_id' => $payment->payment_id,
            'total_amount' => $payment->total_amount,
        ]);

        dd($payment, $totalAmount);

        return view('admin.payment', compact('payment'));
    }

    // Hiển thị form sửa
    public function edit($id)
    {
        $payment = Payment::find($id); // Tìm thanh toán theo ID
        return view('admin.edit_payment', compact('payment'));
    }

    // Xử lý cập nhật
    public function update(Request $request, $id)
    {
        $payment = Payment::find($id); // Tìm thanh toán theo ID
        $payment->update($request->all()); // Cập nhật với dữ liệu từ form

        return redirect()->route('admin.payments.index')->with('success', 'Thanh toán đã được cập nhật');
    }

    // Xóa một thanh toán
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        return redirect()->route('admin.payments.index')->with('success', 'Thanh toán đã được xóa.');
    }
}

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link href="{{ asset('public/css/checkout.css') }}" rel='stylesheet' type='text/css' />
</head>
<body>
<div id="app">
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ $message }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <header>  
        <div class="logo">
            <a href="{{ url('/home') }}">        
                <img src="{{ asset('public/images/logo.png') }}" alt="Logo" class="logo">
            </a>
        </div>
    </header>
    <div class="container">    
        @if (count($cartItems) > 0)
            <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <h3>Thông tin sản phẩm</h3>
                        <ul class="list-group mb-4">
                            @foreach ($cartItems as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>                                        
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" style="max-width: 100px; max-height: 100px;">
                                        <h5>{{ $item['name'] }}</h5>
                                        <p>Số lượng: {{ $item['quantity'] }}</p>
                                        <p>Giá: {{ number_format($item['price'], 0, ',', '.') }} VND</p>
                                    </div>                                
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="col-md-4">
                        <h3>Thông tin thanh toán</h3>
                        <div class="mb-3">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Họ và tên" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="address" id="address" class="form-control" placeholder="Địa chỉ" required>
                        </div>
                        <div class="mb-3">
                            <input type="tel" name="phone" id="phone" class="form-control" placeholder="Số điện thoại" required pattern="[0-9]{10}">
                        </div>
                        <div class="mb-3"> 
                            <input name="order_note" id="order_note" class="form-control" placeholder="Ghi chú đơn hàng"> 
                        </div>
                        <div class="mb-3">
                            <select name="shipping_method" id="shipping_method" class="form-control" required>
                                <option value="" disabled selected>Phương thức vận chuyển</option>
                                <option value="SHIP00" data-cost="30000">Nhanh (2 ngày - 30,000 VND)</option>
                                <option value="SHIP01" data-cost="60000">Hỏa tốc (1 ngày - 60,000 VND)</option>
                                <option value="SHIP02" data-cost="15000">Tiết kiệm (4-7 ngày - 15,000 VND)</option>
                            </select>
                        </div>
                        <input type="hidden" id="shipping_cost" name="shipping_cost" value="0">
                        <div class="mb-3">
                            <select name="payment_method" id="payment_method" class="form-control" required>
                                <option value="" disabled selected>Phương thức thanh toán</option>
                                <option value="COD" data-action="{{ route('checkout.process') }}">Thanh toán khi nhận hàng (COD)</option>
                                <option value="VNPay" data-action="{{ route('vnpay.payment') }}">Thanh toán qua VNPay</option>
                                <option value="PayPal" data-action="{{ route('paypal.payment') }}">Thanh toán qua PayPal</option>
                            </select>
                        </div>                                                
                    </div>
        
                    <div class="col-md-4">
                        <h3>Thanh toán</h3>
                        <p id="total-amount">Tổng tiền: {{ number_format($total, 0, ',', '.') }} VND</p>
                        <input type="hidden" id="final_total_usd" name="final_total_usd" value="">
                        <div class="mb-3"> 
                            <select name="voucher" id="voucher" class="form-control"> 
                                <option value="" disabled selected>Chọn mã giảm giá </option> 
                                @foreach ($vouchers as $voucher) 
                                    <option value="{{ $voucher->discount_value }}">{{ $voucher->code }} - Giảm {{ $voucher->discount_value }}% </option> 
                                @endforeach 
                            </select> 
                        </div>
                        <button type="submit" id="confirm-button" class="btn btn-success w-100">Xác nhận thanh toán</button>
                    </div>
                </div>
            </form>
        @else
            <p class="text-center">Giỏ hàng của bạn đang trống. <a href="{{ route('allProduct') }}">Tiếp tục mua sắm</a>.</p>
        @endif
    </div>
</body>
</html>
<script> 
    document.getElementById('voucher').addEventListener('change', calculateTotal);
    document.getElementById('shipping_method').addEventListener('change', calculateTotal);
    function calculateTotal() {
        const totalVND = {{ $total }};
        const voucherDiscount = parseFloat(document.getElementById('voucher').value) || 0;
        const shippingCost = parseFloat(document.querySelector('#shipping_method option:checked').dataset.cost) || 0;

        const discountedTotal = totalVND - (totalVND * (voucherDiscount / 100));
        const finalTotalVND = discountedTotal + shippingCost;
        const finalTotalUSD = finalTotalVND / 25000;

        document.getElementById('total-amount').innerText = 
            'Tổng tiền: ' + new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(finalTotalVND) +
            ' (' + new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(finalTotalUSD) + ')';

        document.getElementById('shipping_cost').value = shippingCost;
        document.getElementById('final_total_usd').value = finalTotalUSD.toFixed(2); // Lưu giá trị USD
    }

    const paymentMethodSelect = document.getElementById('payment_method');
    const checkoutForm = document.getElementById('checkout-form');

    paymentMethodSelect.addEventListener('change', () => {
        const selectedOption = paymentMethodSelect.options[paymentMethodSelect.selectedIndex];
        const actionUrl = selectedOption.getAttribute('data-action');
        if (actionUrl) {
            checkoutForm.setAttribute('action', actionUrl);
        }
    });

</script>

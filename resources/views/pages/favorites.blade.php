@extends('layouts.app') <!-- Sử dụng layout chính -->

@section('title', 'Danh sách yêu thích')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">Danh sách yêu thích</h2>

    @if($favorites->isEmpty())
        <p class="text-muted">Bạn chưa thêm sản phẩm nào vào danh sách yêu thích.</p>
    @else
        <div class="row">
            @foreach($favorites as $favorite)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('images/products/' . $favorite->product->image) }}" 
                             class="card-img-top" 
                             alt="{{ $favorite->product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $favorite->product->name }}</h5>
                            <p class="card-text text-muted">
                                Giá: {{ number_format($favorite->product->price, 0, ',', '.') }} VND
                            </p>
                            <button class="btn btn-danger btn-sm" 
                                    onclick="removeFavorite({{ $favorite->product->id }})">
                                <i class="fa fa-heart-broken"></i> Xóa khỏi yêu thích
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        loadFavorites();
    });

    function loadFavorites() {
        const customerId = localStorage.getItem('customer_id');

        if (!customerId) {
            alert('Bạn cần đăng nhập để xem danh sách yêu thích.');
            return;
        }

        fetch(`/api/favorites?customer_id=${customerId}`)
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('favorites-container');
                container.innerHTML = '';

                if (data.length === 0) {
                    container.innerHTML = '<p class="text-muted">Bạn chưa thêm sản phẩm nào vào danh sách yêu thích.</p>';
                    return;
                }

                data.forEach(favorite => {
                    container.innerHTML += `
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="/images/products/${favorite.product.image}" class="card-img-top" alt="${favorite.product.name}">
                                <div class="card-body">
                                    <h5 class="card-title">${favorite.product.name}</h5>
                                    <p class="card-text text-muted">Giá: ${favorite.product.price.toLocaleString()} VND</p>
                                    <button class="btn btn-danger btn-sm" onclick="removeFavorite(${favorite.product.id})">
                                        <i class="fa fa-heart-broken"></i> Xóa khỏi yêu thích
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                });
            })
            .catch(error => console.error('Error:', error));
    }

    function removeFavorite(productId) {
        const customerId = localStorage.getItem('customer_id');

        fetch('/api/favorites/remove', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                customer_id: customerId,
                product_id: productId,
            }),
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            loadFavorites(); // Reload danh sách
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection

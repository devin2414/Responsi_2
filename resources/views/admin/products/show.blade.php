@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <!-- Product Details Section -->
    <div class="row">
        <div class="col-md-6">
            <!-- Product Image (placeholder) -->
            <img src="{{ asset('images/1.2.png') }}" alt="{{ $product->name }}" class="img-fluid">
        </div>
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            <p>{{ $product->description }}</p>
            <h3>${{ number_format($product->price, 2) }}</h3>

            <!-- Add to Cart Button -->
            <a href="{{ route('cart.add', $product->id) }}" class="btn btn-success">
                <i class="fas fa-cart-plus"></i> Add to Cart
            </a>
        </div>
    </div>
</div>
@endsection

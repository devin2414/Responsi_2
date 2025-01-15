@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="my-4">Products</h1>
    <div class="card">
        <div class="card-title my-4 mx-2"> Data Product</div>
        <div class="card-body">
            <a href="{{ route('products.create') }}" class="btn btn-success mb-3">Add New Product</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Gambar</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ asset('storage/'. $product->image)}}" alt="" class="rounded" style="width: 50px; height: 50px;">
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <a href="{{ route('products.destroy', $product->id) }}" class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

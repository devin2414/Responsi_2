<!-- resources/views/admin/products/create.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="my-4">Add New Product</h1>
    <div class="card">
        <div class="mx-4 my-4 card-title">form input</div>
        <div class="card-body">
            <form action="{{route('products.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="name">Name</label>
                    <input type="text" name="name" required class="form-control">
                </div>
        
                <div class="mb-4">
                    <label for="price">Price</label>
                    <input type="number" name="price" required class="form-control">
                </div>
        
                <div class="mb-4">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
        
                <div class="mb-4">
                    <label for="stock">Stock</label>
                    <input type="number" name="stock" class="form-control">
                </div>
        
                <div class="mb-4">
                    <label for="image">Product Image</label>
                    <input type="file" name="image" accept="image/*" required class="form-control">
                </div>
        
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection

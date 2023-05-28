@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('products.update', $product->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Producto</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name', $product->name)}}">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Precio</label>
                            <input type="text" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Editar</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

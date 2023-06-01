@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('products.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Producto</label>
                            <input type="text" class="form-control" id="name" name="name">
                            @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Precio</label>
                            <input type="text" class="form-control" id="price" name="price">
                            @if ($errors->has('price'))
                            <span class="text-danger">{{ $errors->first('price') }}</span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @foreach ($products as $idx => $product)
            @if ($idx == 0 || $idx % 4 == 0)
                <div class="row mt-4">
            @endif
            <div class="col-md-3">
                <div class="card shadow">
                    <img src="{{ route('products.image', ['imageName' => $product->image_url]) }}" alt="Product Image"
                        class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title text-center">
                            <a href="{{ route('products.show', ['id' => $product['id']]) }}" class="text-dark">{{ $product->name }}</a>
                        </h5>
                        <p class="card-text text-center">
                            Price: ${{ $product->price }}
                        </p>
                        <div class="text-center">
                            <a href="{{ route('carts.add', ['id' => $product->id]) }}" class="btn btn-primary">Add to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
            @if ($idx > 0 && $idx % 4 == 3 || $idx == count($products) - 1)
                </div>
            @endif
        @endforeach
    </div>
@endsection

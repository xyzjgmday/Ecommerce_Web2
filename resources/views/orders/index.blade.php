@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <h2>
                List Order
            </h2>
            <div>
                <a href="{{ route ('admin.products.create') }}" class="btn btn-primary">Tambah Produk</a>
            </div>
            <br />
        </div>
    </div>
</div>
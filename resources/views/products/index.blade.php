@extends('layouts.app')

@section('content')
<div class="container">
    @include('helpers.flash-messages')
    <div class="row">
        <div class="col-6">
            <h1><i class="bi bi-card-list"></i> Lista produktów</h1>
        </div>
        <div class="col-6 d-flex flex-row-reverse">
            <a href="{{ route('products.create') }}">
                <button type="button" class="float-right btn btn-primary"><i class="bi bi-plus" style="font-size: 1.5rem;"></i></button>
            </a>
        </div>
    </div>
    <div class="row">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nazwa</th>
                    <th scope="col">Opis</th>
                    <th scope="col">Ilość</th>
                    <th scope="col">Cena</th>
                    <th scope="col">Kategoria</th>
                    <th scope="col">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <th scope="row">{{ $product->id }}</th>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->amount }}</td>
                        <td>{{ $product->price }}</td>
                        <td>@if($product->hasCaregory()) {{ $product->category->name }} @endif</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ route('products.show', $product->id) }}"><i class="bi bi-search"></i></a>
                            <a class="btn btn-success btn-sm" href="{{ route('products.edit', $product->id) }}"><i class="bi bi-pencil-square"></i></a>
                            <button class="btn btn-danger btn-sm delete" data-id="{{ $product->id }}"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $products->links() }}
</div>
@endsection
@section('javascript')
    const deleteUrl = "{{ url('products') }}/";
@endsection
@section('js-files')
    @vite(['resources/js/delete.js'])
@endsection

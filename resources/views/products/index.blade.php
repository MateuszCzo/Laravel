@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h1>Lista produktów</h1>
        </div>
        <div class="col-6 d-flex flex-row-reverse">
            <a href="{{ route('products.create') }}">
                <button type="button" class="float-right btn btn-primary">Dodaj</button>
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
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ route('products.show', $product->id) }}">P</a>
                            <a class="btn btn-success btn-sm" href="{{ route('products.edit', $product->id) }}">E</a>
                            <button class="btn btn-danger btn-sm delete" data-id="{{ $product->id }}">X</button>
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

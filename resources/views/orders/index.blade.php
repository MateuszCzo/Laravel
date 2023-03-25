@extends('layouts.app')

@section('content')
<div class="container">
    @include('helpers.flash-messages')
    <div class="row">
        <div class="col-6">
            <h1><i class="bi bi-card-list"></i> Orders</h1>
        </div>
    </div>
    <div class="row">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Ilosc</th>
                    <th scope="col">Cena</th>
                    <th scope="col">Status</th>
                    <th scope="col">Produkty</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td scope="row">{{ $order->id }}</th>
                        <td scope="row">{{ $order->quantity }}</th>
                        <td scope="row">{{ $order->price }}</th>
                        <td scope="row">{{ $order->payment->status }}</th>
                        <td scope="row">
                            <ul>
                                @foreach($order->products as $product)
                                    <li>{{ $product->name }} - {{ $product->description }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $orders->links() }}
</div>
@endsection
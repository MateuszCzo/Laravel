@extends('layouts.app')

@section('css-files')
    @vite(['resources/css/cart.css'])
@endsection

@section('content')
<div class="cart_section">
    @include('helpers.flash-messages')
     <div class="container-fluid">
         <div class="row">
             <div class="col-lg-10 offset-lg-1">
                 <div class="cart_container">
                     <div class="cart_title">Shopping Cart<small> ({{ $cart->getItems()->count() }} item in your cart) </small></div>
                     <div class="cart_items">
                         <ul class="cart_list">
                            @foreach($cart->getItems() as $item)
                             <li class="cart_item clearfix">
                                 <div class="cart_item_image">
                                 <img src="{{ $item->getImage() }}" class="img-fluid mx-auto d-block" alt="Zdjęcie produktu">
                                 </div>
                                 <div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
                                     <div class="cart_item_name cart_info_col">
                                         <div class="cart_item_title">Name</div>
                                         <div class="cart_item_text">{{ $item->getName() }}</div>
                                     </div>
                                     <div class="cart_item_name cart_info_col">
                                         <div class="cart_item_title">Price</div>
                                         <div class="cart_item_text">{{ $item->getPrice() }}</div>
                                     </div>
                                     <div class="cart_item_name cart_info_col">
                                         <div class="cart_item_title">Quantity</div>
                                         <div class="cart_item_text">{{ $item->getQuantity() }}</div>
                                     </div>
                                     <div class="cart_item_name cart_info_col">
                                         <div class="cart_item_title">Total</div>
                                         <div class="cart_item_text">{{ $item->getSum() }}</div>
                                     </div>
                                     <div class="cart_item_name cart_info_col">
                                         <button class="btn btn-danger btn-sm delete" data-id="{{ $item->getProductId() }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                     </div>
                                 </div>
                             </li>
                            @endforeach
                         </ul>
                     </div>
                     <div class="order_total">
                         <div class="order_total_content text-md-right">
                             <div class="order_total_title">Order Total:</div>
                             <div class="order_total_amount">{{ $cart->getSum() }}</div>
                         </div>
                     </div>
                     <div class="cart_buttons">
                        <button type="button" class="button cart_button_clear">Continue Shopping</button>
                        <button type="button" class="button cart_button_checkout">Pay</button>
                    </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
@endsection

@section('javascript')
    const deleteUrl = "{{ url('cart') }}/"
@endsection

@section('js-files')
    @vite(['resources/js/delete.js'])
@endsection

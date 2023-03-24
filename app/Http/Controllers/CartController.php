<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use App\Dtos\Cart\CartDto;
use App\Dtos\Cart\CartItemDto;
use Illuminate\Support\Arr;

class CartController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index():View
    {
        dd(Session::get('cart', new CartDto()));
        return view('home');
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param Product $product
     * @return JsonResponse
     */
    public function store(Product $product): JsonResponse
    {
        $cart = Session::get('cart', new CartDto());
        $items = $cart->getItems();
        if(Arr::exists($items, $product->id)) {
            $items[$product->id]->incrementQuantity();
        } else {
            $cartItemDto = $this->getCartItemDto($product);
            $items[$product->id] = $cartItemDto;
        }
        $cart->setItems($items);
        $cart->incrementTotalQuantity();
        $cart->incrementTotalSum($product->price);

        Session::put('cart', $cart);
        return response()->json([
            'status' => 'success'
        ]);
    }

    private function getCartItemDto(Product $product): CartItemDto {
        $cartItemDto = new CartItemDto();
        $cartItemDto->setProductId($product->id);
        $cartItemDto->setName($product->name);
        $cartItemDto->setPrice($product->price);
        $cartItemDto->setImagePath($product->image_path);
        $cartItemDto->setQuantity(1);
        return $cartItemDto;
    }
}

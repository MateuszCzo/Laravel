<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use App\ValueObjects\Cart;
use App\ValueObjects\CartItem;
use Illuminate\Support\Arr;
use Exception;

class CartController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index():View
    {
        return view('cart.index', [
            'cart' => Session::get('cart', new Cart()),
            'defaultImage' => config('shop.defaultImage'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param Product $product
     * @return JsonResponse
     */
    public function store(Product $product): JsonResponse
    {
        $cart = Session::get('cart', new Cart());
        Session::put('cart', $cart->addItem($product));
        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        try {
            $cart = Session::get('cart', new Cart());
            Session::put('cart', $cart->removeItem($product));
            Session::flash('status', 'Product deleted!');
            return response()->json([
                'status' => 'success',
            ]);
        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'wystapil blad przy usuwanie uzytkownika',
            ])->setStatusCode(500);
        }
    }
}

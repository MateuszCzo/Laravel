<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\ValueObjects\Cart;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return View
     */
    public function index(): View
    {
        return view('orders.index', [
            'orders' => Order::where('user_id', Auth::id())->paginate(10)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @return RedirectResponse
     */
    public function store(): RedirectResponse
    {
        $cart = Session::get('cart', new Cart());
        if(!$cart->hasItems()) return back();

        $order = new Order();
        $order->quantity = $cart->getQuantity();
        $order->price = $cart->getSum();
        $order->user_id = Auth::id();
        $order->save();

        $productIds = $cart->getItems()->map(function($item) {
            return ['product_id' => $item->getProductId()];
        });
        $order->products()->attach($productIds);

        Session::put('cart', new Cart());
        return redirect(route('orders.index'))->with('status', 'Zamowienie zrealizowane!');
    }
}

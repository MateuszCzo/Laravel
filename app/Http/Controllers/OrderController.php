<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\ValueObjects\Cart;
use App\Model\Payment;
use Devpark\Transfers24\Requests\Transfers24;
use RequestException;
use RequestExecutionException;
use App\Enums\PaymentStatus;

class OrderController extends Controller
{
    private Transfers24 $transfers24;

    public function __construct(Transfers24 $transfers24) {
        $this->transfers24 = $transfers24;
    }

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

        return $this->paymentTransaction($order);
        //return redirect(route('orders.index'))->with('status', 'Zamowienie zrealizowane!');
    }

    private function paymentTransaction(Order $order) {
        $payment = new Payment();
        $payment->order_id = $order->id;
        $this->transfers24->setEmail(Auth::user()->email)->setAmount($order->price);
        try {
            $response = $this->transfers24->init();
            if($response->isSuccess()) {
                $payment->status = PaymentStatus::IN_PROGRESS;
                $payment->session_id = $response->getSessionId();
                $payment->save();
                Session::put('cart', new Cart());
                return redirect($this->transfers24->execute($response->getToken()));
            } else {
                $payment->status = PaymentStatus::FAIL;
                $payment->error_code = $response->getErrorCode();
                $payment->error_description = json_encode($response->getErrorDescription());
                $payment->save();
                return back()->with('error', 'Ups... Cos poszlo nie tak!');
            }
        } catch(RequestException|RequestExecutionException $e) {
            return back()->with('error', 'Ups... Cos poszlo nie tak!');
        }
    }
}

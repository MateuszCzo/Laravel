<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Exception;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param Request
     * @return View|JsonResponse
     */
    public function index(Request $request): View|JsonResponse
    {
        $filters = $request->query('filter');
        $paginate = $request->query('paginate') ?? 5;
        $query = Product::query();
        if(!is_null($filters)) {
            if(array_key_exists('categories', $filters)) {
                $query = $query->whereIn('category_id', $filters['categories']);
            }
            if(!is_null($filters['price_min'])) {
                $query = $query->whereIn('price', '>=', $filters['price_min']);
            }
            if(!is_null($filters['price_max'])) {
                $query = $query->whereIn('price', '<=', $filters['price_max']);
            }

            return response()->json($query->paginate($paginate));
        }
        return view('welcome', [
            'products' => $query->paginate($paginate),
            'categories' => ProductCategory::orderBy('name', 'ASC')->get(),
            'defaultImage' => config('shop.defaultImage'),
            'isGuest' => Auth::guest(),
        ]);
    }
}

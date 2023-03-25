<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use App\Exceptions\UserNotDeletedException;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Address;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        return view('users.index', [
            'users' => User::paginate(3)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        return View('users.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param UpdateUserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $addressValidated = $request->validated()['address'];
        if($user->hasAddress()) {
            $address = $user->address;
            $address->fill($addressValidated);
        } else {
            $address = new Address($addressValidated);
        }
        $user->address()->save($address);
        return redirect(route('users.index'))->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        try {
            $user->delete($user);
            Session::flash('status', 'User deleted!');
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

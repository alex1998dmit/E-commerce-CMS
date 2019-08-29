<?php

namespace App\Http\Controllers\API\V1;

use Auth;
use Validator;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $http = new \GuzzleHttp\Client;
        try {
            $response = $http->post('http://passportapi/oauth/token', [
                // TODO внести параметры из ENV
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => 2,
                    'client_secret' => "WhYqHBDCWfGGecC4XcRc6yur09AJxxCvn3FiPJJT",
                    'username' => $request->username,
                    'password' => $request->password,
                ]
            ]);
            return $response->getBody();
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            if ($e->getCode() === 400) {
                return response()->json('Invalid Request. Please enter a username or a password.', $e->getCode());
            } else if ($e->getCode() === 401) {
                return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
            }
            return response()->json('Something went wrong on the server.', $e->getCode());
        }
    }

    public function register(Request $request)
    {
        // $validator = Validator::make($request->all(), [ // <---
        $validation =  Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validation->fails()) {
            // return $validation->errors();
            return response()->json([
                'messages' => $validation->errors()
            ], 401);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->role()->attach(Role::where('name', 'user')->first()->id);
        return $user;
    }


    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json('Logged out successfully', 200);
    }

    public function about()
    {
        $user = Auth::user();
        $user->order;
        return [
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at,
            'role' => $user->role,
            'orders_count' => $user->order->count(),
            'products_at_cart_count' => $user->shoppingCart->count(),
            'wishlist_count' => $user->wishList->count()
        ];
    }
}

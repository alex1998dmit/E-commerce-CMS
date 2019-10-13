<?php

namespace App\Http\Controllers\API\V1;

use Auth;
use Validator;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $https = new \GuzzleHttp\Client;
        try {
            $response = $https->post(env('MIX_APP_HOST_NAME') . '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => 2,
                    'client_secret' => env('MIX_SECRET_CODE'),
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
            'verification_token' => Str::random(32),
            'password' => Hash::make($request->password),
        ]);

        $user->sendEmailVerificationNotification();
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

        return [
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at,
            'role' => $user->role,
            'discount' => $user->discount,
            'orders_count' => $user->order->count(),
            'at_cart_count' => $user->shoppingCart->count(),
            'wishlist_count' => $user->wishList->count(),
            'email_verified_at' => $user->email_verified_at,
            'shoppingCartItems' => $user->shoppingCart,
            'wishListItems' => $user->wishList
        ];
    }
}

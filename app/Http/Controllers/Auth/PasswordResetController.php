<?php

namespace App\Http\Controllers\Auth;

use Validator;
use Carbon\Carbon;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\User;
use App\PasswordReset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class PasswordResetController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user)
            return response()->json([
                'message' => "Пользователь с текущими параметрами не найден"
            ], 404);
        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => str_random(60)
             ]
        );
        if ($user && $passwordReset)
            $user->notify(
                new PasswordResetRequest($passwordReset->token)
            );
        return response()->json([
            'message' => 'Сообщение уже отправлено'
        ]);
    }

    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)
            ->first();

        if (!$passwordReset)
            return response()->json([
                'message' => 'This password reset token is invalid because not found user token.'
            ], 404);
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
//            $passwordReset->delete();
            return response()->json([
                'message' => 'This password reset token is invalid because not you already click reset password.'
            ], 404);
        }
        return response()->json($passwordReset);
    }

    public function reset(Request $request)
    {
        $validation =  Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed|min:6',
            'token' => 'required|string'
        ]);
        if ($validation->fails()) {
            return response()->json([
                'type' => 'validate_error',
                'messages' => $validation->errors()
            ], 401);
        }

        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();
        if (!$passwordReset)
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user)
            return response()->json([
                'message' => "We can't find a user with that e-mail address."
            ], 404);
        $user->password = bcrypt($request->password);
        $user->save();
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccess($passwordReset));
        return response()->json($user);
    }
}

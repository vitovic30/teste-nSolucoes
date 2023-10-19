<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $data = $request->validated();
            $user = User::where('email', '=', $data['email']);

            if ($user->exists()) {
                $validUser = $user->first();

                if (Hash::check($data['password'], $validUser->password) &&
                        Auth::attempt($request->only(['email', 'password']))) {

                    Auth::login($validUser);
                    return response()->json([
                        'access_token' => $validUser->createToken('Personal Access Token')->plainTextToken,
                        'user' => $user->select('name', 'email')->first(),
                        'roles' => $validUser->roles()->get()->toArray()
                    ]);
                }
                else {
                    return response()->json(['message' => 'Não foi possível realizar o login.'], 401);
                }
            } else {
                return response()->json(['message' => 'Não foi possível realizar o login.'], 401);
            }
        } catch (\Throwable $th) {
            return response([
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\API\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        $user = User::whereHas('administrativeEmployee')
            ->where('email', $credentials['email'])
            ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return view('welcome');
        }

        auth()->login($user);

        return redirect()->intended('/telescope');
    }
}

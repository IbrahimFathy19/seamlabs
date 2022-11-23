<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'birth_date' => Carbon::parse($request->birth_date),
            'email_verified_at'  => Carbon::now(),
            'password' => Hash::make($request->password),
        ]);

        return $this->handleResponse([
            'user' => $user,
            '_token' => $user->createToken('API Token')->plainTextToken
        ], 201);
    }
}

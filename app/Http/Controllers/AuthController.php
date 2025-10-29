<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    Log::info(json_encode($request->all()));
    $validation_rules = [
      'email' => 'required|email',
      'password' => 'required|string|min:8',
    ];
    $validated = $request->validate($validation_rules);

    if (!Auth::attempt($validated)) {
      throw ValidationException::withMessages([
        'email' => ['The provided credentials are incorrect.'],
      ]);
    }

    // $request->session()->regenerate();
    // return response()->json(Auth::user());
    $user = Auth::user();

    return $user->createToken('auth_token')->plainTextToken;
  }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
	public function reset(Request $request)
	{
		$request->validate([
			'token' => 'required',
			'email' => 'required|email',
			'password' => 'required|min:8|confirmed',
		]);

		$status = Password::reset(
			$request->only('email', 'password', 'password_confirmation', 'token'),
			function ($user, $password) {
				$user->password = Hash::make($password);
				$user->save();
			}
		);

		if ($status == Password::PASSWORD_RESET) {
			return response()->json(['message' => 'Password reset successful.']);
		}

		throw ValidationException::withMessages([
			'email' => [__($status)],
		]);
	}
}


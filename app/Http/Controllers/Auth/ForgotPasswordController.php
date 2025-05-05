<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
	public function sendResetLink(Request $request)
	{
		$request->validate([
			'email' => 'required|email|exists:users,email',
		]);

		$status = Password::sendResetLink(
			$request->only('email')
		);

		return $status === Password::RESET_LINK_SENT
			? response()->json(['message' => 'Reset link sent.'])
			: response()->json(['message' => 'Unable to send reset link.'], 500);
	}
}

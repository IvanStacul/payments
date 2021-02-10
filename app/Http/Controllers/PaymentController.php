<?php

namespace App\Http\Controllers;

use App\Services\PayPalService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
	public function pay(Request $request)
	{
		$rules = [
			'value' => 'numeric|required|min:5',
			'currency' => 'required|exists:currencies,iso',
			'payment_platform' => 'required|exists:payment_platforms,id',
		];
		$request->validate($rules);

		// Llama al constructor de PayPalService e instancia un objeto de esa clase
		$paymentPlatform = resolve(PayPalService::class);

		return $paymentPlatform->handlePayment($request);
	}

	public function approval()
	{
		// Llama al constructor de PayPalService e instancia un objeto de esa clase
		$paymentPlatform = resolve(PayPalService::class);

		return $paymentPlatform->handleApproval();
	}

	public function cancelled()
	{
		//
	}
}

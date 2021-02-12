<?php

namespace App\Http\Controllers;

use App\Resolvers\PaymentPlatformResolver;
use App\Services\PayPalService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
	protected	$paymentPlatformResolver;

	public function __construct(PaymentPlatformResolver $paymentPlatformResolver)
	{
		$this->middleware('auth');
		$this->paymentPlatformResolver = $paymentPlatformResolver;
	}

	public function pay(Request $request)
	{
		$rules = [
			'value' => 'numeric|required|min:5',
			'currency' => 'required|exists:currencies,iso',
			'payment_platform' => 'required|exists:payment_platforms,id',
		];
		$request->validate($rules);

		// Llama al constructor de PayPalService e instancia un objeto de esa clase
		$paymentPlatform = $this->paymentPlatformResolver
			->resolveService(request('payment_platform'));

		session()->put('paymentPlatformId', request('payment_platform'));
		return $paymentPlatform->handlePayment($request);
	}

	public function approval()
	{
		if (session()->has('paymentPlatformId')) {
			$paymentPlatform = $this->paymentPlatformResolver
				->resolveService(session()->get('paymentPlatformId'));

			return $paymentPlatform->handleApproval();
		}

		return redirect()
			->route('home')
			->withErrors('We cannot retrieve your payment platform. Try again, plase.');
	}

	public function cancelled()
	{
		return redirect()
			->route('home')
			->withErrors('Tu pago fue cancelado');
	}
}

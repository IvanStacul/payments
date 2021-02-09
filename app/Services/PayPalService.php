<?php

namespace App\Services;

use App\Traits\ConsumesExternalServices;

class PayPalService
{
	use ConsumesExternalServices;

	protected $baseUrl;

	protected $clientId;

	protected $clientSecret;

	public function __construct()
	{
		$this->baseUrl = config('services.paypal.base_url');
		$this->clientId = config('services.paypal.client_id');
		$this->clientSecret = config('services.paypal.client_secret');
	}

	public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
	{
		//
	}

	public function decodeResponse($response)
	{
		//
	}
}

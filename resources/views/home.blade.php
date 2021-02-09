@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">{{ __('Dashboard') }}</div>

				<div class="card-body">
					<form action="{{ route('pay') }}" method="POST" id="paymentForm">
						@csrf
						<div class="row">
							<div class="col-auto">
								<div class="form-group">
									<label for="value">{{ __('How much you want pay?') }}</label>
									<input type="number" min="5" step="0.01" value="{{ mt_rand(500, 100000)/100 }}" class="form-control"
										name="value" id="value" aria-describedby="helpValue" required>
									<small id="helpValue" class="form-text text-muted">Debe ingresar un monto correcto.</small>
								</div>
							</div>
							<div class="col-auto">
								<div class="form-group">
									<label for="currency">{{ __('Currencies') }}</label>
									<select class="form-control" name="currency" id="currency" required>
										@foreach ($currencies as $currency)
										<option value="{{ $currency->iso }}">{{ strtoupper($currency->iso) }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>

						<div class="row mt-3">
							<div class="form-group" id="toggler">
								<div class="col">
									<p> {{ __('Select the desired payment platfrom:') }} </p>
								</div>
								<div class="btn-group btn-group-toggle" data-toggle="buttons">
									@foreach ($paymentPlatforms as $paymentPlatform)
									<label class="btn btn-outline-secondary rounded m-2 p-1" data-toggle="collapse" data-target="#{{ $paymentPlatform->name }}">
										<input type="radio" name="payment_platform" value="{{$paymentPlatform->id}}" required>
										<img src="{{ asset($paymentPlatform->image) }}" class="img-thumbnail">
									</label>
									@endforeach
								</div>
								@foreach ($paymentPlatforms as $paymentPlatform)
								<div id="{{ $paymentPlatform->name }}" class="collapse" data-parent="#toggler">
									@includeIf('components.' . strtolower($paymentPlatform->name))
								</div>
								@endforeach
							</div>
						</div>

						<div class="mt-3">
							<button type="submit" id="payButton" class="btn btn-primary">{{ __('Pay') }}</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

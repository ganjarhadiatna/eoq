@extends('layouts.app')

@section('content')
	<div class="card bg-secondary shadow">
		<div class="card-header bg-white border-0">
			<div class="row align-items-center">
				<h3 class="mb-0">{{ __('Edit Etalase') }}</h3>
			</div>
		</div>
		<div class="card-body">
			@foreach ($etalase as $etl)

				<form method="post" action="{{ route('etalase-put') }}" autocomplete="off">
					@csrf
					<!-- <h6 class="heading-small text-muted mb-4">{{ __('etalase') }}</h6> -->
					<div class="form-group{{ $errors->has('etalase') ? ' has-danger' : '' }}">

						<input type="hidden" name="idetalase" value="{{ $etl->idetalase }}" >

						<label class="form-control-label" for="input-etalase">{{ __('Etalase') }}</label>
						<input 
	                        type="text" 
	                        name="etalase" 
	                        id="input-etalase" 
	                        class="form-control form-control-alternative{{ $errors->has('etalase') ? ' is-invalid' : '' }}" 
	                        placeholder="{{ __('Masukan etalase') }}"  
	                        value="{{ $etl->etalase }}" 
	                        required 
	                        autofocus>
	                        @if ($errors->has('etalase'))
		                        <span class="invalid-feedback" role="alert">
		                        	<strong>{{ $errors->first('etalase') }}</strong>
		                        </span>
	                        @endif
	                    <div class="text-right">
	                	<button type="submit" class="btn btn-success mt-4">{{ __('Simpan') }}</button>
	                </div>
	                </div>
				</form>

			@endforeach
		</div>
	</div>
@endsection
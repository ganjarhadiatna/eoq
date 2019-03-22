@extends('layouts.app')

@section('content')
	<div class="card bg-secondary shadow">
		<div class="card-header bg-white border-0">
			<div class="row align-items-center">
				<h3 class="mb-0">{{ __('Tambah Supplier') }}</h3>
			</div>
		</div>
		<div class="card-body">
			<form method="post" action="{{ route('supplier-put') }}" autocomplete="off">
				@csrf

                @foreach ($supplier as $sp)

                    <input 
                        type="hidden" 
                        name="idsuppliers" 
                        value="{{ $sp->idsuppliers }}">
				
    				<div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
    					<label class="form-control-label" for="name">{{ __('Nama') }}</label>
    					<input 
                            type="text" 
                            name="name" 
                            id="name" 
                            class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                            placeholder="{{ __('Masukan nama') }}"
                            value="{{ $sp->name }}"  
                            required 
                            autofocus>
                            @if ($errors->has('name'))
    	                        <span class="invalid-feedback" role="alert">
    	                        	<strong>{{ $errors->first('name') }}</strong>
    	                        </span>
                            @endif
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
    					<label class="form-control-label" for="email">{{ __('Email') }}</label>
    					<input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" 
                            placeholder="{{ __('Masukan email') }}" 
                            value="{{ $sp->email }}"
                            required>
                            @if ($errors->has('email'))
    	                        <span class="invalid-feedback" role="alert">
    	                        	<strong>{{ $errors->first('email') }}</strong>
    	                        </span>
                            @endif
                    </div>

                    <div class="form-group{{ $errors->has('phone_number') ? ' has-danger' : '' }}">
    					<label class="form-control-label" for="phone_number">{{ __('Nomor Telpon') }}</label>
    					<input 
                            type="text" 
                            name="phone_number" 
                            id="phone_number" 
                            class="form-control form-control-alternative{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" 
                            placeholder="{{ __('Masukan nomor telpon') }}"
                            value="{{ $sp->phone_number }}"
                            required>
                            @if ($errors->has('phone_number'))
    	                        <span class="invalid-feedback" role="alert">
    	                        	<strong>{{ $errors->first('phone_number') }}</strong>
    	                        </span>
                            @endif
                    </div>

                    <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
    					<label class="form-control-label" for="address">{{ __('Alamat') }}</label>
    					<input 
                            type="address" 
                            name="address" 
                            id="address" 
                            class="form-control form-control-alternative{{ $errors->has('address') ? ' is-invalid' : '' }}" 
                            placeholder="{{ __('Masukan alamat') }}"
                            value="{{ $sp->address }}"
                            required>
                            @if ($errors->has('address'))
    	                        <span class="invalid-feedback" role="alert">
    	                        	<strong>{{ $errors->first('address') }}</strong>
    	                        </span>
                            @endif
                    </div>

                @endforeach

                <div class="form-group">
                	<div class="text-right">
	                	<button type="submit" class="btn btn-success mt-4">{{ __('Simpan') }}</button>
	                </div>
	            </div>

			</form>
		</div>
	</div>
@endsection
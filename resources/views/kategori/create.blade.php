@extends('layouts.app')

@section('content')
	<div class="card bg-secondary shadow">
		<div class="card-header bg-white border-0">
			<div class="row align-items-center">
				<h3 class="mb-0">{{ __('Tambah Kategori') }}</h3>
			</div>
		</div>
		<div class="card-body">
			<form method="post" action="{{ route('kategori-push') }}" autocomplete="off">
				@csrf
				<!-- <h6 class="heading-small text-muted mb-4">{{ __('Kategori') }}</h6> -->
				<div class="form-group{{ $errors->has('category') ? ' has-danger' : '' }}">
					<label class="form-control-label" for="input-category">{{ __('category') }}</label>
					<input 
                        type="text" 
                        name="category" 
                        id="input-category" 
                        class="form-control form-control-alternative{{ $errors->has('category') ? ' is-invalid' : '' }}" 
                        placeholder="{{ __('Masukan kategori') }}"  
                        required 
                        autofocus>
                        @if ($errors->has('category'))
	                        <span class="invalid-feedback" role="alert">
	                        	<strong>{{ $errors->first('category') }}</strong>
	                        </span>
                        @endif
                </div>

                <div class="form-group">
                	<div class="text-right">
	                	<button type="submit" class="btn btn-success mt-4">{{ __('Simpan') }}</button>
	                </div>
	            </div>
	            
			</form>
		</div>
	</div>
@endsection
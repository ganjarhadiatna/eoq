@extends('layouts.app')

@section('content')
	<div class="card bg-secondary shadow">
		<div class="card-header bg-white border-0">
			<div class="row align-items-center">
				<h3 class="mb-0">{{ __('Tambah Barang') }}</h3>
			</div>
		</div>
		<div class="card-body">
			<form method="post" action="{{ route('barang-push') }}" autocomplete="off">
				@csrf
				
				<div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
					<label class="form-control-label" for="title">{{ __('Nama Barang') }}</label>
					<input 
                        type="text" 
                        name="title" 
                        id="title" 
                        class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" 
                        placeholder="{{ __('Nama barang') }}"  
                        required 
                        autofocus>
                        @if ($errors->has('title'))
	                        <span class="invalid-feedback" role="alert">
	                        	<strong>{{ $errors->first('title') }}</strong>
	                        </span>
                        @endif
                    
                </div>

                <div class="form-group{{ $errors->has('stock') ? ' has-danger' : '' }}">
					<label class="form-control-label" for="stock">{{ __('Stok') }}</label>
					<input 
                        type="number" 
                        name="stock" 
                        id="stock" 
                        class="form-control form-control-alternative{{ $errors->has('stock') ? ' is-invalid' : '' }}" 
                        placeholder="{{ __('1 .. n') }}"  
                        required >
                        @if ($errors->has('stock'))
	                        <span class="invalid-feedback" role="alert">
	                        	<strong>{{ $errors->first('stock') }}</strong>
	                        </span>
                        @endif
                    
                </div>

                <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
					<label class="form-control-label" for="price">{{ __('Harga') }}</label>
					<input 
                        type="text" 
                        name="price" 
                        id="price" 
                        class="form-control form-control-alternative{{ $errors->has('price') ? ' is-invalid' : '' }}" 
                        placeholder="{{ __('500000') }}"  
                        required >
                        @if ($errors->has('price'))
	                        <span class="invalid-feedback" role="alert">
	                        	<strong>{{ $errors->first('price') }}</strong>
	                        </span>
                        @endif
                    
                </div>

                <div class="form-group{{ $errors->has('expire_date') ? ' has-danger' : '' }}">
					<label class="form-control-label" for="expire_date">{{ __('Tanggal kadaluarsa') }}</label>
					<input 
                        type="date" 
                        name="expire_date" 
                        id="expire_date" 
                        class="form-control form-control-alternative{{ $errors->has('expire_date') ? ' is-invalid' : '' }}" 
                        required >
                        @if ($errors->has('expire_date'))
	                        <span class="invalid-feedback" role="alert">
	                        	<strong>{{ $errors->first('expire_date') }}</strong>
	                        </span>
                        @endif
                    
                </div>

                <div class="form-group{{ $errors->has('idcategories') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="idcategories">{{ __('Kategori') }}</label>
                    <select 
                        name="idcategories" 
                        id="idcategories" 
                        class="form-control form-control-alternative{{ $errors->has('idcategories') ? ' is-invalid' : '' }}" 
                        required>
                        @foreach ($category as $ctr)
                            <option value="{{ $ctr->idcategories }}">{{ $ctr->category }}</option>
                        @endforeach
                    </select>
                        @if ($errors->has('idcategories'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('idcategories') }}</strong>
                            </span>
                        @endif
                    
                </div>

                <div class="form-group{{ $errors->has('idetalase') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="idetalase">{{ __('idEtalase') }}</label>
                    <select 
                        name="idetalase" 
                        id="idetalase" 
                        class="form-control form-control-alternative{{ $errors->has('idetalase') ? ' is-invalid' : '' }}" 
                        required>
                        @foreach ($etalase as $etl)
                            <option value="{{ $etl->idetalase }}">{{ $etl->etalase }}</option>
                        @endforeach
                    </select>
                        @if ($errors->has('idetalase'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('idetalase') }}</strong>
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
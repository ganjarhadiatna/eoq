@extends('layouts.app')

@section('content')
	<div class="card bg-secondary shadow">
		<div class="card-header bg-white border-0">
			<div class="row align-items-center">
				<h3 class="mb-0">{{ __('Edit Barang') }}</h3>
			</div>
		</div>
		<div class="card-body">

            @foreach ($items as $it)

    			<form method="post" action="{{ route('barang-put') }}" autocomplete="off">
    				@csrf

                    <input type="hidden" name="iditems" value="{{ $it->iditems }}">
    				
    				<div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
    					<label class="form-control-label" for="title">{{ __('Nama Barang *') }}</label>
    					<input 
                            type="text" 
                            name="title" 
                            id="title" 
                            class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" 
                            placeholder="{{ __('Nama barang') }}"  
                            value="{{ $it->title }}" 
                            required 
                            autofocus>
                            @if ($errors->has('title'))
    	                        <span class="invalid-feedback" role="alert">
    	                        	<strong>{{ $errors->first('title') }}</strong>
    	                        </span>
                            @endif
                        
                    </div>

                    <div class="form-group{{ $errors->has('stock') ? ' has-danger' : '' }}">
    					<label class="form-control-label" for="stock">{{ __('Stok *') }}</label>
    					<input 
                            type="number" 
                            name="stock" 
                            id="stock" 
                            class="form-control form-control-alternative{{ $errors->has('stock') ? ' is-invalid' : '' }}" 
                            placeholder="{{ __('1 .. 1000') }}"  
                            value="{{ $it->stock }}" 
                            min="0"
                            max="1000"
                            required >
                            @if ($errors->has('stock'))
    	                        <span class="invalid-feedback" role="alert">
    	                        	<strong>{{ $errors->first('stock') }}</strong>
    	                        </span>
                            @endif
                        
                    </div>

                    <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
    					<label class="form-control-label" for="price">{{ __('Harga *') }}</label>
    					<input 
                            type="number" 
                            name="price" 
                            id="price" 
                            class="form-control form-control-alternative{{ $errors->has('price') ? ' is-invalid' : '' }}" 
                            placeholder="{{ __('500000') }}"  
                            value="{{ $it->price }}" 
                            min="0"
                            required >
                            @if ($errors->has('price'))
    	                        <span class="invalid-feedback" role="alert">
    	                        	<strong>{{ $errors->first('price') }}</strong>
    	                        </span>
                            @endif
                        
                    </div>

                    <div class="form-group{{ $errors->has('discount') ? ' has-danger' : '' }}">
    					<label class="form-control-label" for="discount">{{ __('Diskon dalam persen (ex: 25)') }}</label>
    					<input 
                            type="number" 
                            name="discount" 
                            id="discount" 
                            class="form-control form-control-alternative{{ $errors->has('discount') ? ' is-invalid' : '' }}" 
                            placeholder="{{ __('0 - 100') }}"  
                            value="{{ ($it->discount * 100) }}" 
                            min="0"
                            max="100"
                            required >
                            @if ($errors->has('discount'))
    	                        <span class="invalid-feedback" role="alert">
    	                        	<strong>{{ $errors->first('discount') }}</strong>
    	                        </span>
                            @endif
                        
                    </div>

                    <div class="form-group{{ $errors->has('price_order') ? ' has-danger' : '' }}">
    					<label class="form-control-label" for="price">{{ __('Biaya pemesanan barang *') }}</label>
    					<input 
                            type="number" 
                            name="price_order" 
                            id="price-order" 
                            class="form-control form-control-alternative{{ $errors->has('price_order') ? ' is-invalid' : '' }}" 
                            placeholder="{{ __('500000') }}"  
                            value="{{ $it->price_order }}"
                            min="0" 
                            required >
                            @if ($errors->has('price_order'))
    	                        <span class="invalid-feedback" role="alert">
    	                        	<strong>{{ $errors->first('price') }}</strong>
    	                        </span>
                            @endif
                        
                    </div>

                    <div class="form-group{{ $errors->has('price_store') ? ' has-danger' : '' }}">
    					<label class="form-control-label" for="price">{{ __('Biaya penyimpanan barang *') }}</label>
    					<input 
                            type="number" 
                            name="price_store" 
                            id="price_store" 
                            class="form-control form-control-alternative{{ $errors->has('price_store') ? ' is-invalid' : '' }}" 
                            placeholder="{{ __('500000') }}"  
                            value="{{ $it->price_order }}" 
                            min="0"
                            required >
                            @if ($errors->has('price_store'))
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
                            value="{{ $it->expire_date }}" 
                            required >
                            @if ($errors->has('expire_date'))
    	                        <span class="invalid-feedback" role="alert">
    	                        	<strong>{{ $errors->first('expire_date') }}</strong>
    	                        </span>
                            @endif
                        
                    </div>

                    <div class="form-group{{ $errors->has('idcategories') ? ' has-danger' : '' }}">
                        <label class="form-control-label" for="idcategories">{{ __('Kategori *') }}</label>
                        <select 
                            name="idcategories" 
                            id="idcategories" 
                            class="form-control form-control-alternative{{ $errors->has('idcategories') ? ' is-invalid' : '' }}" 
                            required>
                            @foreach ($category as $ctr)
                                @if ($it->idcategories == $ctr->idcateogries)
                                    <option value="{{ $ctr->idcategories }}" selected="true">{{ $ctr->category }}</option>
                                @else
                                    <option value="{{ $ctr->idcategories }}">{{ $ctr->category }}</option>
                                @endif
                            @endforeach
                        </select>
                            @if ($errors->has('idcategories'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('idcategories') }}</strong>
                                </span>
                            @endif
                        
                    </div>

                    <div class="form-group{{ $errors->has('idetalase') ? ' has-danger' : '' }}">
                        <label class="form-control-label" for="idetalase">{{ __('Etalase *') }}</label>
                        <select 
                            name="idetalase" 
                            id="idetalase" 
                            class="form-control form-control-alternative{{ $errors->has('idetalase') ? ' is-invalid' : '' }}" 
                            required>
                            @foreach ($etalase as $etl)
                                @if ($it->idetalase == $etl->idetalase)
                                    <option value="{{ $etl->idetalase }}" selected="true">{{ $etl->etalase }}</option>
                                @else
                                    <option value="{{ $etl->idetalase }}">{{ $etl->etalase }}</option>
                                @endif
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

            @endforeach

		</div>
	</div>
@endsection
@extends('layouts.app')

@section('content')
	<div class="card bg-secondary shadow">
		<div class="card-header bg-white border-0">
			<div class="row align-items-center">
				<h3 class="mb-0">{{ __('Edit Pembelian') }}</h3>
			</div>
		</div>
		<div class="card-body">
			<form method="post" action="{{ route('pembelian-put') }}" autocomplete="off">
				@csrf

				@foreach ($buying as $by)

					<input type="hidden" name="idbuying" value="{{ $by->idbuying }}">

					<div class="form-group{{ $errors->has('iditems') ? ' has-danger' : '' }}">
	                    <label class="form-control-label" for="iditems">{{ __('Pilih Barang') }}</label>
	                    <select 
	                        name="iditems" 
	                        id="iditems" 
	                        class="form-control form-control-alternative{{ $errors->has('iditems') ? ' is-invalid' : '' }}" 
	                        required>
	                        @foreach ($items as $ctr)
	                        	@if ($by->iditems == $ctr->iditems)
	                            	<option value="{{ $ctr->iditems }}" selected>{{ $ctr->title }}</option>
	                            @else
	                            	<option value="{{ $ctr->iditems }}">{{ $ctr->title }}</option>
	                            @endif
	                        @endforeach
	                    </select>
	                        @if ($errors->has('iditems'))
	                            <span class="invalid-feedback" role="alert">
	                                <strong>{{ $errors->first('iditems') }}</strong>
	                            </span>
	                        @endif
	                    
	                </div>

	                <div class="form-group{{ $errors->has('idsuppliers') ? ' has-danger' : '' }}">
	                    <label class="form-control-label" for="idsuppliers">{{ __('Pilih Supplier') }}</label>
	                    <select 
	                        name="idsuppliers" 
	                        id="idsuppliers" 
	                        class="form-control form-control-alternative{{ $errors->has('idsuppliers') ? ' is-invalid' : '' }}" 
	                        required>
	                        @foreach ($suppliers as $sp)
	                        	@if ($by->idsuppliers == $sp->idsuppliers)
	                            	<option value="{{ $sp->idsuppliers }}" selected>{{ $sp->name }}</option>
	                            @else
	                            	<option value="{{ $sp->idsuppliers }}">{{ $sp->name }}</option>
	                            @endif
	                        @endforeach
	                    </select>
	                        @if ($errors->has('idsuppliers'))
	                            <span class="invalid-feedback" role="alert">
	                                <strong>{{ $errors->first('idsuppliers') }}</strong>
	                            </span>
	                        @endif
	                    
	                </div>

					<div class="form-group{{ $errors->has('count') ? ' has-danger' : '' }}">
						<label class="form-control-label" for="input-count">{{ __('Jumlah barang') }}</label>
						<input 
	                        type="number" 
	                        name="count" 
	                        id="input-count" 
	                        class="form-control form-control-alternative{{ $errors->has('count') ? ' is-invalid' : '' }}" 
	                        placeholder="{{ __('10') }}"  
	                        value="{{ $by->count }}" 
	                        required>
	                        @if ($errors->has('count'))
		                        <span class="invalid-feedback" role="alert">
		                        	<strong>{{ $errors->first('count') }}</strong>
		                        </span>
	                        @endif
	                </div>

	                <div class="form-group{{ $errors->has('price_item') ? ' has-danger' : '' }}">
						<label class="form-control-label" for="input-price_item">{{ __('Harga Barang') }}</label>
						<input 
	                        type="number" 
	                        name="price_item" 
	                        id="input-price_item" 
	                        class="form-control form-control-alternative{{ $errors->has('price_item') ? ' is-invalid' : '' }}" 
	                        placeholder="{{ __('10000') }}"  
	                        value="{{ $by->price_item }}"
	                        required>
	                        @if ($errors->has('price_item'))
		                        <span class="invalid-feedback" role="alert">
		                        	<strong>{{ $errors->first('price_item') }}</strong>
		                        </span>
	                        @endif
	                </div>

	                <div class="form-group{{ $errors->has('price_manage') ? ' has-danger' : '' }}">
						<label class="form-control-label" for="input-price_manage">{{ __('Biaya Gudang') }}</label>
						<input 
	                        type="number" 
	                        name="price_manage" 
	                        id="input-price_manage" 
	                        class="form-control form-control-alternative{{ $errors->has('price_manage') ? ' is-invalid' : '' }}" 
	                        placeholder="{{ __('100000') }}"  
	                        value="{{ $by->price_manage }}"
	                        required>
	                        @if ($errors->has('price_manage'))
		                        <span class="invalid-feedback" role="alert">
		                        	<strong>{{ $errors->first('price_manage') }}</strong>
		                        </span>
	                        @endif
	                </div>

	                <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
	                    <label class="form-control-label" for="status">{{ __('Status') }}</label>
	                    <select 
	                        name="status" 
	                        id="status" 
	                        class="form-control form-control-alternative{{ $errors->has('status') ? ' is-invalid' : '' }}" 
	                        required>
	                        @if ($by->status == 'wait')
		                        <option value="wait" selected>Menunggu</option>
		                        <option value="process">Dalam Proses</option>
		                        <option value="done">Selesai</option>
		                    @endif

		                    @if ($by->status == 'process')
		                        <option value="wait">Menunggu</option>
		                        <option value="process" selected>Dalam Proses</option>
		                        <option value="done">Selesai</option>
		                    @endif

		                    @if ($by->status == 'done')
		                        <option value="wait">Menunggu</option>
		                        <option value="process">Dalam Proses</option>
		                        <option value="done" selected>Selesai</option>
		                    @endif
	                    </select>
	                        @if ($errors->has('status'))
	                            <span class="invalid-feedback" role="alert">
	                                <strong>{{ $errors->first('status') }}</strong>
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
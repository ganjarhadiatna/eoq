@extends('layouts.app')

@section('content')
	<div class="card bg-secondary shadow">
		<div class="card-header bg-white border-0">
			<div class="row align-items-center">
				<h3 class="mb-0">{{ __('Tambah Penjualan') }}</h3>
			</div>
		</div>
		<div class="card-body">
			<form method="post" action="{{ route('penjualan-put') }}" autocomplete="off">
				@csrf
				@foreach ($transactions as $tr)

					<input type="hidden" name="idtransactions" value="{{ $tr->idtransactions }}">

					<div class="form-group{{ $errors->has('iditems') ? ' has-danger' : '' }}">
	                    <label class="form-control-label" for="iditems">{{ __('Pilih Barang') }}</label>
	                    <select 
	                        name="iditems" 
	                        id="iditems" 
	                        class="form-control form-control-alternative{{ $errors->has('iditems') ? ' is-invalid' : '' }}" 
	                        required>
	                        <option value="0">Pilih barang</option>
	                        @foreach ($items as $ctr)
	                        	@if ($tr->iditems == $ctr->iditems)
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

	                <div class="form-group{{ $errors->has('count') ? ' has-danger' : '' }}">
	                    <label class="form-control-label" for="input-count">{{ __('Jumlah barang') }}</label>
	                    <input 
	                        type="number" 
	                        name="count" 
	                        id="input-count" 
	                        class="form-control form-control-alternative{{ $errors->has('count') ? ' is-invalid' : '' }}" 
	                        placeholder="{{ __('10') }}"
	                        value="{{ $tr->count }}"
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
	                        value="{{ $tr->price_item }}"
	                        required>
	                        @if ($errors->has('price_item'))
	                            <span class="invalid-feedback" role="alert">
	                                <strong>{{ $errors->first('price_item') }}</strong>
	                            </span>
	                        @endif
	                </div>

	                <div class="form-group{{ $errors->has('price_total') ? ' has-danger' : '' }}">
	                    <label class="form-control-label" for="input-price_total">{{ __('Total Biaya') }}</label>
	                    <input 
	                        type="number" 
	                        name="price_total" 
	                        id="input-price_total" 
	                        class="form-control form-control-alternative{{ $errors->has('price_total') ? ' is-invalid' : '' }}" 
	                        placeholder="{{ __('10000') }}"
	                        value="{{ $tr->price_total }}"  
	                        >
	                        @if ($errors->has('price_total'))
	                            <span class="invalid-feedback" role="alert">
	                                <strong>{{ $errors->first('price_total') }}</strong>
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

    <script type="text/javascript">

        $(document).ready(function() {
            $('#iditems').on('click', function(event) {
                event.preventDefault();
                /* Act on the event */
                var iditems = $(this).val();
                var count = $('#input-count').val();
                var url = '{{ url("/barang/price_item/") }}' + '/' + iditems;

                if (iditems != 0) {
                    // get price items
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                    })
                    .done(function(data) {
                        var total = data.price * count;

                        // console.log(data.price);
                        $('#input-price_item').val(data.price);
                        $('#input-price_total').val(total);
                    })
                    .fail(function(data) {
                        console.log(data);
                    })
                    .always(function() {
                        console.log("complete");
                    });
                } else {
                    $('#input-price_item').val('0');
                    $('#input-price_total').val('0');
                }

                // console.log(url);
            });

            $('#input-count').keyup(function(event) {
            	var total = $('#input-price_item').val() * $('#input-count').val();
            	$('#input-price_total').val(total);
            });
        });
    </script>

@endsection
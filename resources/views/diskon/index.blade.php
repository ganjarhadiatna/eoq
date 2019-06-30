@extends('layouts.app')

@section('content')
	<div class="card shadow">

		<div class="card-header border-0">
            <div class="row align-barang-center mb-2">
                <div class="col-sm">
                    <h3 class="mb-0">Daftar Diskon Barang</h3>
                </div>
                <div class="col-3 form-inline text-right">
                    <form action="#" class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lg fa-search"></i>
                                </span>
                            </div>
                            <input class="form-control" placeholder="Cari diskon" type="text">
                        </div>
                    </form>
                </div>
                <div class="col-2 text-right">
                    <button 
                        type="button" 
                        class="btn btn-primary" 
                        onclick="openCreateForm()" >
                        <i class="fa fa-lg fa-plus"></i>
                        Tambah
                    </button>
                </div>
            </div>
        </div>

        <div class="table-responsive">
        	
        	<table class="table align-items-center table-flush">

        		<thead class="thead-light">
                    <tr>
                        <th scope="col" width="100">NO</th>
                        <th scope="col">Diskon</th>
                        <th scope="col">Min</th>
                        <th scope="col">Max</th>
                        <th scope="col">Tipe</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col" width="200">#</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($diskon as $etl)
                    	<tr>
                            <th>
                                {{ $i++ }}
                            </th>
                            <td>
                            	{{ ($etl->diskon * 100 ).'%' }}
                            </td>
                            <td>
                            	{{ $etl->min }}
                            </td>
                            <td>
                            	{{ $etl->max }}
                            </td>
                            <td>
                            	{{ $etl->tipe }}
                            </td>
                            <td>
                            	{{ $etl->created_at }}
                            </td>
                            <td>
                                <a 
                                    href="{{ route('diskon-remove') }}" 
                                    onclick="
                                        event.preventDefault();
                                        document.getElementById('hapus-diskon-{{ $etl->id }}').submit();">
                                    <button class="btn btn-danger">
                                        Hapus
                                    </button>
                                </a>

                                <form 
                                    id="hapus-diskon-{{ $etl->id }}" 
                                    action="{{ route('diskon-remove') }}" 
                                    method="POST" 
                                    style="display: none;">
                                    @csrf
                                    <input 
                                        type="hidden" 
                                        name="id" 
                                        value="{{ $etl->id }}">
                                    <input 
                                        type="hidden" 
                                        name="idbarang" 
                                        value="{{ $etl->idbarang }}">
                                </form>

                                <button 
                                    class="btn btn-success" 
                                    onclick="openEditForm({{ $etl->id }})" >
                                    Ubah
                                </button>

                            </td>
                        </tr>
                    @endforeach
                </tbody>

        	</table>

        </div>

        <div class="col col-8" style="padding-top: 15px">
            {{ $diskon->links() }}
        </div>
		
	</div>

	<!-- Modal -->
    <div 
        class="modal fade" 
        id="createModal" 
        tabindex="-1" 
        role="dialog" 
        aria-labelledby="createModalLabel" 
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
	        <div class="modal-content">
	        	
	        	<form 
	                method="post" 
	                action="{{ route('diskon-push') }}"
	                autocomplete="off" 
	                id="form-create">
	                @csrf

	                <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">
                            Tambah Diskon Baru
                        </h5>
                        <button 
                            type="button" 
                            class="close" 
                            onclick="openCreateForm()" 
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                    	<input 
                            type="hidden" 
                            name="idbarang" 
                            value="{{ $idbarang }}" 
                            id="input_idbarang">

                        <div class="form-group{{ $errors->has('diskon') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-diskon">{{ __('Diskon (dalam %)') }}</label>
                            <input 
                                type="text" 
                                name="diskon" 
                                id="input-diskon" 
                                class="form-control form-control-alternative{{ $errors->has('diskon') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('1-100') }}"  
                                required 
                                autofocus>

                            @if ($errors->has('diskon'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('diskon') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('tipe') ? ' has-danger' : '' }}">
                        	<label class="form-control-label" for="input_tipe">{{ __('Pilih Tipe Diskon *') }}</label>
                            <select 
                                name="tipe" 
                                id="input_tipe" 
                                class="form-control form-control-alternative{{ $errors->has('tipe') ? ' is-invalid' : '' }}" 
                                required>
                                <option value="unit">Unit</option>
                                <option value="incremental">Incremental</option>
                            </select>
                                @if ($errors->has('tipe'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tipe') }}</strong>
                                    </span>
                                @endif
                            
                    	</div>

                    	<div class="form-group{{ $errors->has('min') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-min">{{ __('Pembelian minimum') }}</label>
                            <input 
                                type="text" 
                                name="min" 
                                id="input-min" 
                                class="form-control form-control-alternative{{ $errors->has('min') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('1-100') }}">

                            @if ($errors->has('min'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('min') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('max') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-max">{{ __('Pembelian maximum') }}</label>
                            <input 
                                type="text" 
                                name="max" 
                                id="input-max" 
                                class="form-control form-control-alternative{{ $errors->has('max') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('1-100') }}">

                            @if ($errors->has('max'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('max') }}</strong>
                                </span>
                            @endif
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button 
                            type="button" 
                            class="btn btn-secondary" 
                            onclick="openCreateForm()">Tutup</button>
                        <button 
                            type="submit" 
                            class="btn btn-primary">Simpan barang</button>
                    </div>

	            </form>

	        </div>
	    </div>
    </div>

    <div 
        class="modal fade" 
        id="editModal" 
        tabindex="-1" 
        role="dialog" 
        aria-labelledby="editModalLabel" 
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">
	        <div class="modal-content">

	        	<form 
                    method="post" 
                    action="{{ route('diskon-put') }}"
                    autocomplete="off" 
                    id="form-create">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">
                            Ubah Diskon
                        </h5>
                        <button 
                            type="button" 
                            class="close" 
                            onclick="openEditForm()" 
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                    	<input 
                            type="hidden" 
                            name="id" 
                            id="ubah_id">

                        <input 
                            type="hidden" 
                            name="idbarang" 
                            id="ubah_idbarang">

                        <div class="form-group{{ $errors->has('diskon') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="ubah_diskon">{{ __('Diskon (dalam %)') }}</label>
                            <input 
                                type="text" 
                                name="diskon" 
                                id="ubah_diskon" 
                                class="form-control form-control-alternative{{ $errors->has('diskon') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('1-100') }}"
                                required 
                                autofocus>

                            @if ($errors->has('diskon'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('diskon') }}</strong>
                                </span>
                            @endif
                        </div>

                        <!--<div class="form-group{{ $errors->has('tipe') ? ' has-danger' : '' }}">
                        	<label class="form-control-label" for="ubah_tipe">{{ __('Pilih Kategori *') }}</label>
                            <select 
                                name="tipe" 
                                id="ubah_tipe" 
                                class="form-control form-control-alternative{{ $errors->has('tipe') ? ' is-invalid' : '' }}" 
                                required>
                                <option value="unit">Unit</option>
                                <option value="incremental">Incremental</option>
                            </select>
                                @if ($errors->has('tipe'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tipe') }}</strong>
                                    </span>
                                @endif
                            
                    	</div>-->

                    	<div class="form-group{{ $errors->has('min') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="ubah_min">{{ __('Pembelian minimum)') }}</label>
                            <input 
                                type="text" 
                                name="min" 
                                id="ubah_min" 
                                class="form-control form-control-alternative{{ $errors->has('min') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('1-100') }}">

                            @if ($errors->has('min'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('min') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('max') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="ubah_max">{{ __('Pembelian maximum') }}</label>
                            <input 
                                type="text" 
                                name="max" 
                                id="ubah_max" 
                                class="form-control form-control-alternative{{ $errors->has('max') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('1-100') }}">

                            @if ($errors->has('max'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('max') }}</strong>
                                </span>
                            @endif
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button 
                            type="button" 
                            class="btn btn-secondary"
                            onclick="openEditForm()">Tutup</button>
                        <button 
                            type="submit" 
                            class="btn btn-primary">Simpan perubahan</button>
                    </div>

                </form>
	        </div>
	    </div>
        
    </div>

	<script type="text/javascript">

		var clNow = "modal fade";
        var clOpen = "modal fade show";

		function openEditForm(id = 0) {
			var tr = $('#editModal').attr('class');
            var route = '{{ url("diskon/byid/") }}' + '/' + id;

            if (tr == clNow) {

                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(data) {
                    $('#editModal').attr('class', clOpen).show();
                    $('#ubah_id').val(data[0].id);
                    $('#ubah_idbarang').val(data[0].idbarang);
                    $('#ubah_diskon').val((data[0].diskon * 100));
                    $('#ubah_min').val(data[0].min);
                    $('#ubah_max').val(data[0].max);

                    console.log(data);
                })
                .fail(function(e) {
                    console.log("error " + e);
                })
                .always(function() {
                    console.log("complete");
                });
                

            } else {
                $('#editModal').attr('class', clNow).hide();
            }
		}
		
		function openCreateForm() {
            var tr = $('#createModal').attr('class');

            if (tr == clNow) {
                $('#createModal').attr('class', clOpen).show();
            } else {
                $('#createModal').attr('class', clNow).hide();
            }
        }

	</script>
@endsection
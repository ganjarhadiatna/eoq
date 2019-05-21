@extends('layouts.app')

@section('content')
	<div class="card bg-secondary shadow">

        <div class="card-header border-0">
            <div class="nav-wrapper">
                <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">
                            EOQ Sederhana
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">
                            Method 2
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false">
                            Method 3
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-4-tab" data-toggle="tab" href="#tabs-icons-text-4" role="tab" aria-controls="tabs-icons-text-4" aria-selected="false">
                            Method 4
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-5-tab" data-toggle="tab" href="#tabs-icons-text-5" role="tab" aria-controls="tabs-icons-text-5" aria-selected="false">
                            Method 5
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-6-tab" data-toggle="tab" href="#tabs-icons-text-6" role="tab" aria-controls="tabs-icons-text-6" aria-selected="false">
                            Method 6
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-7-tab" data-toggle="tab" href="#tabs-icons-text-7" role="tab" aria-controls="tabs-icons-text-7" aria-selected="false">
                            Method 7
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-8-tab" data-toggle="tab" href="#tabs-icons-text-8" role="tab" aria-controls="tabs-icons-text-8" aria-selected="false">
                            Method 8
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- <div class="card-header border-0">
            <div class="row align-items-center mb-2">
                <div class="col-sm">
                    <h3 class="mb-0">EOQ Sederhana</h3>
                </div>
                <div class="col-2 text-right">
                    
                </div>
            </div>
        </div> -->

        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                    <form 
	                    method="post" 
	                    action="{{ route('pesanan-push') }}"
	                    autocomplete="off" 
	                    id="form-generate-eoq">

	                    @csrf

                        <div>
                            <h3 class="mb-0">Informasi Parameter</h3>
                        </div>

                        <div class="row mb-2">

                            <div class="col-sm">

                                <div class="form-group{{ $errors->has('idbarang') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="idbarang">{{ __('Pilih barang') }}</label>
                                    <select 
                                        name="idbarang"
                                        id="idbarang" 
                                        class="form-control form-control-alternative{{ $errors->has('idbarang') ? ' is-invalid' : '' }}" 
                                        required>
                                        <option value="0"></option>
                                        @foreach ($barang as $br)
                                            <option value="{{ $br->id }}">{{ $br->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('idbarang'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('idbarang') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            </div>
                            <div class="col-sm">

                            	<div>
	                            	<label class="form-control-label" for="idbarang">{{ __('Mulai perhitungan?') }}</label>
	                            	<div>
	                            		<button 
		                                    type="button" 
		                                    class="btn btn-success" 
		                                    onclick="generate_eoq()">
		                                    Generate EOQ
		                                </button>
	                            	</div>
	                            </div>

                            </div>
                        </div>

                        <div>
                            <h3 class="mb-0">Hasil Keputusan</h3>
                        </div>

                        <div class="row mb-2">

                            <div class="col-sm">
                                <div class="form-group{{ $errors->has('jumlah_unit') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="jumlah_unit">{{ __('Jumlah unit') }}</label>
                                    <input 
                                        type="text" 
                                        name="jumlah_unit" 
                                        id="jumlah_unit" 
                                        class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                        required>
                                    @if ($errors->has('jumlah_unit'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('jumlah_unit') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('total_cost') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="total_cost">{{ __('Total cost persediaan') }}</label>
                                    <input 
                                        type="text" 
                                        name="total_cost" 
                                        id="total_cost" 
                                        class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                        required>
                                    @if ($errors->has('total_cost'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('total_cost') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            </div>
                            <div class="col-sm">
                                
                                <div class="form-group{{ $errors->has('frekuensi_pembelian') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="frekuensi_pembelian">{{ __('Frekuensi pembelian per-tahun') }}</label>
                                    <input 
                                        type="text" 
                                        name="frekuensi_pembelian" 
                                        id="frekuensi_pembelian" 
                                        class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                        required>
                                    @if ($errors->has('frekuensi_pembelian'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('frekuensi_pembelian') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('reorder_point') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="reorder_point">{{ __('Re-order point') }}</label>
                                    <input 
                                        type="text" 
                                        name="reorder_point" 
                                        id="reorder_point" 
                                        class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                        required>
                                    @if ($errors->has('reorder_point'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('reorder_point') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            </div>

                        </div>

                        <div class="row align-items-center mb-2">
                            <div class="col-sm">
                                <!-- <button 
                                    type="button" 
                                    class="btn btn-success" 
                                    onclick="generate_eoq()">
                                    Generate EOQ
                                </button> -->
                            </div>
                            <div class="col-4 text-right">
                                <button 
                                    type="submit" 
                                    class="btn btn-secondary" >
                                    Simpan Pesanan
                                </button>
                                <a href="{{ route('pembelian') }}">
	                                <button 
	                                    type="button" 
	                                    class="btn btn-primary">
	                                    Beli Barang
	                                </button>
	                            </a>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="tab-pane fade show active" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                </div>

                <div class="tab-pane fade show active" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                </div>

                <div class="tab-pane fade show active" id="tabs-icons-text-4" role="tabpanel" aria-labelledby="tabs-icons-text-4-tab">
                </div>


            </div>
        </div>
    </div>

    <br>

    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center mb-2">
                <div class="col-sm">
                    <h3 class="mb-0">Daftar Pesanan</h3>
                </div>
                <div class="col-3 form-inline text-right">
                    <form action="#" class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lg fa-search"></i>
                                </span>
                            </div>
                            <input class="form-control" placeholder="Cari pesanan" type="text">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <!-- Projects table -->
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="100">NO</th>
                        <!-- <th scope="col">IDbarang</th> -->
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Jumlah Unit</th>
                        <th scope="col">Total Cost</th>
                        <th scope="col">Frekuensi Pembelian</th>
                        <th scope="col">Reorder Point</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col" width="200">#</th>
                    </tr>
                </thead>
                <tbody>
                	<?php $i = 1; ?>
                    @foreach ($pemesanan as $ps)
	                	<tr>
	                		<th>
	                			{{ $i++ }}
	                		</th>
	                		<th>
	                			{{ $ps->idbarang }}
	                		</th>
	                		<th>
	                			{{ $ps->jumlah_unit }}
	                		</th>
	                		<th>
	                			{{ $ps->total_cost }}
	                		</th>
	                		<th>
	                			{{ $ps->frekuensi_pembelian }}
	                		</th>
	                		<th>
	                			{{ $ps->reorder_point }}
	                		</th>
	                		<th>
	                			{{ $ps->created_at }}
	                		</th>
	                		<th>
	                			<a 
                                    href="{{ route('pesanan-remove') }}" 
                                    onclick="
                                        event.preventDefault();
                                        document.getElementById('hapus-pesanan-{{ $ps->id }}').submit();">
                                    <button class="btn btn-danger">
                                        Hapus
                                    </button>
                                </a>

                                <form 
                                    id="hapus-pesanan-{{ $ps->id }}" 
                                    action="{{ route('pesanan-remove') }}" 
                                    method="POST" 
                                    style="display: none;">
                                    @csrf
                                    <input 
                                        type="hidden" 
                                        name="id" 
                                        value="{{ $ps->id }}">
                                </form>

                                <!-- <button 
                                    onclick="openEditForm({{ $ps->id }})" 
                                    class="btn btn-success">
                                    Ubah
                                </button> -->

                                <button class="btn btn-primary">
                                    Beli Barang
                                </button>


	                		</th>
	                	</tr>
	                @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <script type="text/javascript">

        
        var clNow = "modal fade";
        var clOpen = "modal fade show";

        function openEditForm(id = 0) {

            var tr = $('#editModal').attr('class');
            var route = '{{ url("supplier/byid/") }}' + '/' + id;

            if (tr == clNow) {

                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(data) {
                    $('#editModal').attr('class', clOpen).show();
                    $('#ubah_id').val(data[0].id);
                    $('#ubah_nama').val(data[0].nama);
                    $('#ubah_email').val(data[0].email);
                    $('#ubah_no_telpon').val(data[0].no_telpon);
                    $('#ubah_alamat').val(data[0].alamat);

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

    <script type="text/javascript">

        function generate_eoq() {
            var idbarang = $('#idbarang').val();
            // var idsupplier = $('#idsupplier').val();
            var route = '{{ url("/pesanan/eoq/") }}' + '/' + idbarang;

            if (idbarang == 0) {
            	alert('pilih barang terlebih dahulu.');
            } else {
	            $.ajax({
	                url: route,
	                type: 'GET',
	                processData: false,
	                contentType: false,
	                dataType: 'JSON',
	                // data: {
	                //     'idbarang': idbarang, 
	                //     'idsupplier': idsupplier
	                // },
	            })
	            .done(function(data) {
	                $('#jumlah_unit').val(data.jumlah_unit);
	                $('#total_cost').val(data.total_cost);
	                $('#frekuensi_pembelian').val(data.frekuensi_pembelian);
	                $('#reorder_point').val(data.reorder_point);
	            })
	            .fail(function(e) {
	                console.log("error " + e.responseJSON.message);
	            })
	            .always(function() {
	                console.log("complete");
	            });
	        }
            
        }
        
    </script>

@endsection
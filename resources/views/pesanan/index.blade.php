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
		        	<form>
		        		<div class="row mb-2">
			        		<div class="col-sm">

			        			<div class="form-group{{ $errors->has('supplier') ? ' has-danger' : '' }}">
		                            <label class="form-control-label" for="supplier">{{ __('Pilih barang') }}</label>
		                            <select 
		                            	name="supplier"
		                            	class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
		                            	required>
		                            	<option></option>
		                            	<option>list 1</option>
		                            	<option>list 1</option>
		                            	<option>list 1</option>
		                            	<option>list 1</option>
		                            </select>
		                            @if ($errors->has('supplier'))
		                            	<span class="invalid-feedback" role="alert">
		                            		<strong>{{ $errors->first('supplier') }}</strong>
		                            	</span>
		                            @endif
		                        </div>

		                        <div class="form-group{{ $errors->has('jumlah_permintaan') ? ' has-danger' : '' }}">
		                            <label class="form-control-label" for="jumlah_permintaan">{{ __('Jumlah permintaan customer') }}</label>
		                            <input 
		                                type="number" 
		                                name="jumlah_permintaan" 
		                                id="jumlah_permintaan" 
		                                class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
		                                required>
		                            @if ($errors->has('jumlah_permintaan'))
		                            	<span class="invalid-feedback" role="alert">
		                            		<strong>{{ $errors->first('jumlah_permintaan') }}</strong>
		                            	</span>
		                            @endif
		                        </div>

		                        <div class="form-group{{ $errors->has('diskon') ? ' has-danger' : '' }}">
		                            <label class="form-control-label" for="diskon">{{ __('Persentase harga barang') }}</label>
		                            <input 
		                                type="number" 
		                                name="diskon" 
		                                id="diskon" 
		                                class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
		                                required>
		                            @if ($errors->has('diskon'))
		                            	<span class="invalid-feedback" role="alert">
		                            		<strong>{{ $errors->first('diskon') }}</strong>
		                            	</span>
		                            @endif
		                        </div>

		                        <div class="form-group{{ $errors->has('biaya_penyimpanan') ? ' has-danger' : '' }}">
		                            <label class="form-control-label" for="biaya_penyimpanan">{{ __('Biaya penyimpanan') }}</label>
		                            <input 
		                                type="number" 
		                                name="biaya_penyimpanan" 
		                                id="biaya_penyimpanan" 
		                                class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
		                                required>
		                            @if ($errors->has('biaya_penyimpanan'))
		                            	<span class="invalid-feedback" role="alert">
		                            		<strong>{{ $errors->first('biaya_penyimpanan') }}</strong>
		                            	</span>
		                            @endif
		                        </div>

			        		</div>
			        		<div class="col-sm">
			        			
			        			<div class="form-group{{ $errors->has('supplier') ? ' has-danger' : '' }}">
		                            <label class="form-control-label" for="supplier">{{ __('Pilih supplier') }}</label>
		                            <select 
		                            	name="supplier"
		                            	class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
		                            	required>
		                            	<option></option>
		                            	<option>list 1</option>
		                            	<option>list 1</option>
		                            	<option>list 1</option>
		                            	<option>list 1</option>
		                            </select>
		                            @if ($errors->has('supplier'))
		                            	<span class="invalid-feedback" role="alert">
		                            		<strong>{{ $errors->first('supplier') }}</strong>
		                            	</span>
		                            @endif
		                        </div>

		                        <div class="form-group{{ $errors->has('biaya_pesanan') ? ' has-danger' : '' }}">
		                            <label class="form-control-label" for="biaya_pesanan">{{ __('Biaya pesanan') }}</label>
		                            <input 
		                                type="number" 
		                                name="biaya_pesanan" 
		                                id="biaya_pesanan" 
		                                class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
		                                required>
		                            @if ($errors->has('biaya_pesanan'))
		                            	<span class="invalid-feedback" role="alert">
		                            		<strong>{{ $errors->first('biaya_pesanan') }}</strong>
		                            	</span>
		                            @endif
		                        </div>

		                        <div class="form-group{{ $errors->has('lead_time') ? ' has-danger' : '' }}">
		                            <label class="form-control-label" for="lead_time">{{ __('Lead time supplier (per-minggu)') }}</label>
		                            <input 
		                                type="number" 
		                                name="lead_time" 
		                                id="lead_time" 
		                                class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
		                                required>
		                            @if ($errors->has('lead_time'))
		                            	<span class="invalid-feedback" role="alert">
		                            		<strong>{{ $errors->first('lead_time') }}</strong>
		                            	</span>
		                            @endif
		                        </div>

		                        <div class="form-group{{ $errors->has('waktu_operasional') ? ' has-danger' : '' }}">
		                            <label class="form-control-label" for="waktu_operasional">{{ __('Waktu operasional') }}</label>
		                            <input 
		                                type="number" 
		                                name="waktu_operasional" 
		                                id="waktu_operasional" 
		                                class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
		                                required>
		                            @if ($errors->has('waktu_operasional'))
		                            	<span class="invalid-feedback" role="alert">
		                            		<strong>{{ $errors->first('waktu_operasional') }}</strong>
		                            	</span>
		                            @endif
		                        </div>

			        		</div>
		        		</div>

		        		<div class="row align-items-center mb-2">
		                	<div class="col-sm">
		        				<button 
				        			type="button" 
				        			class="btn btn-success" 
				        			onclick="openCreateForm()">
				        			Generate
				        		</button>
				        	</div>
			        		<div class="col-4 text-right">
			        			<button 
				        			type="button" 
				        			class="btn btn-secondary" 
				        			onclick="openCreateForm()">
				        			Buat Pesanan
				        		</button>
				        		<button type="submit" class="btn btn-primary">
				        			Simpan Dulu
				        		</button>
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
                <!-- <div class="col-2 text-right">
                    <button 
                        onclick="openCreateForm()" 
                        class="btn btn-primary" >
                        <i class="fa fa-lg fa-plus"></i>
                        Tambah
                    </button>
                </div> -->
            </div>
        </div>

        <div class="table-responsive">
            <!-- Projects table -->
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="100">NO</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">Nomor Telpon</th>
                        <th scope="col">Alamat</th>
                        <th scope="col" width="200">#</th>
                    </tr>
                </thead>
                <tbody>
                	<tr>
                		<th></th>
                		<th></th>
                		<th></th>
                		<th></th>
                		<th></th>
                	</tr>
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

@endsection
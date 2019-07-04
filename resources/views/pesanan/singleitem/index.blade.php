@extends('layouts.app')

@section('content')
	<div class="card bg-secondary shadow">

        <div class="card-header border-0">
            <h3 class="mb-0">Singleitem Manajemen Stok</h3>
            <div class="nav-wrapper">
                <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                    <!-- <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-0-tab" data-toggle="tab" href="#tabs-icons-text-0" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">
                            Sembunyikan
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">
                            EOQ Sederhana
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">
                            Back Order
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false">
                            Special Order
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-4-tab" data-toggle="tab" href="#tabs-icons-text-4" role="tab" aria-controls="tabs-icons-text-4" aria-selected="false">
                            Known Price Increases
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

                <!-- EOQ -->
                <div 
                    class="tab-pane fade show" 
                    id="tabs-icons-text-1" 
                    role="tabpanel" 
                    aria-labelledby="tabs-icons-text-1-tab">
                    @include('pesanan.singleitem.eoq')
                </div>

                <!-- Back Order -->
                <div 
                    class="tab-pane fade show" 
                    id="tabs-icons-text-2" 
                    role="tabpanel" 
                    aria-labelledby="tabs-icons-text-2-tab">
                    @include('pesanan.singleitem.backorder')
                </div>

                <div 
                    class="tab-pane fade show" 
                    id="tabs-icons-text-3" 
                    role="tabpanel" 
                    aria-labelledby="tabs-icons-text-3-tab">
                    @include('pesanan.singleitem.hargaSpesial')
                </div>

                <div 
                    class="tab-pane fade show" 
                    id="tabs-icons-text-4" 
                    role="tabpanel" 
                    aria-labelledby="tabs-icons-text-4-tab">
                    @include('pesanan.singleitem.kenaikanHarga')
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
                        <th scope="col">Supplier</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Jumlah Unit</th>
                        <th scope="col">Total Cost / Besar Penghematan</th>
                        <th scope="col">Frekuensi Pembelian</th>
                        <th scope="col">Reorder Point</th>
                        <th scope="col" width="200">#</th>
                    </tr>
                </thead>
                <tbody>
                	<?php $i = 1; ?>
                    @foreach ($pemesanan as $ps)
	                	<tr>
	                		<td>
	                			{{ $i++ }}
	                		</td>
                            <td>
                                {{ $ps->nama_supplier }}
                            </td>
	                		<td>
	                			{{ $ps->nama_barang }}
	                		</td>
                            <td>
                                {{ $ps->harga_barang }}
                            </td>
	                		<td>
	                			<b class="text-green">
                                    {{ $ps->jumlah_unit }}
                                </b>
	                		</td>
	                		<td>
	                			{{ $ps->total_cost }}
	                		</td>
	                		<td>
	                			{{ $ps->frekuensi_pembelian }}
	                		</td>
	                		<td>
	                			{{ $ps->reorder_point }}
	                		</td>
	                		<td>
	                			<a 
                                    href="{{ route('pesanan-singleitem-remove') }}" 
                                    onclick="
                                        event.preventDefault();
                                        document.getElementById('hapus-pesanan-singleitem-{{ $ps->id }}').submit();">
                                    <button class="btn btn-danger">
                                        Hapus
                                    </button>
                                </a>

                                <form 
                                    id="hapus-pesanan-singleitem-{{ $ps->id }}" 
                                    action="{{ route('pesanan-singleitem-remove') }}" 
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

                                <a 
                                    href="{{ route('pesanan-singleitem-create') }}" 
                                    onclick="
                                        event.preventDefault();
                                        document.getElementById('buat-pesanan-{{ $ps->id }}').submit();">
                                    <button class="btn btn-primary">
                                        Beli Barang
                                    </button>
                                </a>

                                <form 
                                    id="buat-pesanan-{{ $ps->id }}" 
                                    action="{{ route('pesanan-singleitem-create') }}" 
                                    method="POST" 
                                    style="display: none;">
                                    @csrf
                                    <input 
                                        type="hidden" 
                                        name="id" 
                                        value="{{ $ps->id }}">
                                </form>


	                		</td>
	                	</tr>
	                @endforeach
                </tbody>
            </table>
        </div>

        <div class="col col-8" style="padding-top: 15px">
            {{ $pemesanan->links() }}
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
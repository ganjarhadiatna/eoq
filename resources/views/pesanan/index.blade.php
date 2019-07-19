<?php
 use App\Pemesanan;
?>

@extends('layouts.app')

@section('content')

    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center mb-2">
                <div class="col-sm">
                    <h3 class="mb-0">Daftar Pemesanan</h3>
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
                        <th scope="col">Total EOQ</th>
                        <th scope="col">Total Cost Keseluruhan</th>
                        <th scope="col">Kelola</th>
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
	                			<b class="text-green">
                                    {{ App\Pemesanan::GetTotalUnitMultiItemByIdsupplier($ps->idsupplier) }}
                                </b>
	                		</td>
                            <td>
                                <b class="text-red">
                                    Rp. {{ number_format(App\Pemesanan::GetTotalCostMultiItemByIdsupplier($ps->idsupplier)) }}
                                </b>
                            </td>
                            <td>
                                <a href="{{ route('pesanan-multiitem-daftar', $ps->idsupplier) }}">
                                    <button class="btn btn-white">
                                        {{ Pemesanan::GetCountUnitMultiItemByIdsupplier($ps->idsupplier).' Barang' }}
                                    </button>
                                </a>
                            </td>
	                		<td>
	                			<a 
                                    href="{{ route('pesanan-multiitem-remove') }}" 
                                    onclick="
                                        event.preventDefault();
                                        document.getElementById('hapus-pesanan-multiitem-{{ $ps->idsupplier }}').submit();">
                                    <button class="btn btn-danger">
                                        Hapus
                                    </button>
                                </a>

                                <form 
                                    id="hapus-pesanan-multiitem-{{ $ps->idsupplier }}" 
                                    action="{{ route('pesanan-multiitem-remove') }}" 
                                    method="POST" 
                                    style="display: none;">
                                    @csrf
                                    <input 
                                        type="hidden" 
                                        name="idsupplier" 
                                        value="{{ $ps->idsupplier }}">
                                </form>

                                <!-- <button 
                                    onclick="openEditForm({{ $ps->id }})" 
                                    class="btn btn-success">
                                    Ubah
                                </button> -->

                                <a 
                                    href="{{ route('pesanan-multiitem-create') }}" 
                                    onclick="
                                        event.preventDefault();
                                        document.getElementById('buat-pesanan-multiitem-{{ $ps->idsupplier }}').submit();">
                                    <button class="btn btn-primary">
                                        Pesan Semua
                                    </button>
                                </a>

                                <form 
                                    id="buat-pesanan-multiitem-{{ $ps->idsupplier }}" 
                                    action="{{ route('pesanan-multiitem-create') }}" 
                                    method="POST" 
                                    style="display: none;">
                                    @csrf
                                    <input 
                                        type="hidden" 
                                        name="idsupplier" 
                                        value="{{ $ps->idsupplier }}">
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

@endsection
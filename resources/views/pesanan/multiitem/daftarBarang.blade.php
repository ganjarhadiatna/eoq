@extends('layouts.app')

@section('content')
	<div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center mb-2">
                <div class="col-sm">
                    <h3 class="mb-0">Daftar Pesanan Barang Supplier</h3>
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
                        <th scope="col">Tipe EOQ</th>
                        <th scope="col">EOQ</th>
                        <th scope="col">Total Cost</th>
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
                                Rp. {{ number_format($ps->harga_barang) }}
                            </td>
                            <td>
                                {{ $ps->tipe }}
                            </td>
	                		<td>
	                			<b class="text-green">
                                    {{ $ps->jumlah_unit }}
                                </b>
	                		</td>
	                		<td>
	                			Rp. {{ number_format($ps->total_cost) }}
	                		</td>
	                		<td>
	                			{{ $ps->frekuensi_pembelian }}
	                		</td>
	                		<td>
                                @if($ps->reorder_point == 0)
                                    {{ '1' }}
                                @else
	                			    {{ $ps->reorder_point }}
                                @endif
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
                                        Pesan Sekarang
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
@endsection
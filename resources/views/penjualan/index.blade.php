@extends('layouts.app')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center mb-2">
                <div class="col-sm">
                    <h3 class="mb-0">Daftar Penjualan</h3>
                </div>
                <div class="col-3 form-inline text-right">
                    <form action="#" class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lg fa-search"></i>
                                </span>
                            </div>
                            <input class="form-control" placeholder="Cari penjualan" type="text">
                        </div>
                    </form>
                </div>
                <div class="col-2 text-right">
                    <a href="{{ route('penjualan-tambah') }}">
                        <button 
                            type="button" 
                            class="btn btn-primary" >
                            <i class="fa fa-lg fa-plus"></i>
                            Tambah
                        </button>
                    </a>
                </div>
            </div>
            
        </div>
        <div class="table-responsive">
            <!-- Projects table -->
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="100">NO</th>
                        <th scope="col">Jumlah Barang</th>
                        <th scope="col">Harga Barang</th>
                        <th scope="col">Total Biaya</th>
                        <th scope="col" width="200">#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($transactions as $tr)
                        <tr>
                            <th>
                                {{ $i++ }}
                            </th>
                            <td>
                                {{ $tr->count }}
                            </td>
                            <td>
                                {{ $tr->price_item }}
                            </td>
                            <td>
                                {{ $tr->price_total }}
                            </td>
                            <td>
                                <a 
                                    href="{{ route('penjualan-remove') }}" 
                                    onclick="
                                        event.preventDefault();
                                        document.getElementById('hapus-items-{{ $tr->idtransactions }}').submit();">
                                    <button class="btn btn-danger">
                                        Hapus
                                    </button>
                                </a>

                                <form 
                                    id="hapus-items-{{ $tr->idtransactions }}" 
                                    action="{{ route('penjualan-remove') }}" 
                                    method="POST" 
                                    style="display: none;">
                                    @csrf
                                    <input 
                                        type="hidden" 
                                        name="idtransactions" 
                                        value="{{ $tr->idtransactions }}">
                                </form>

                                <a href="{{ route('penjualan-edit', $tr->idtransactions) }}">
                                    <button 
                                        class="btn btn-success"
                                        data-toggle="modal" 
                                        data-target="#editModal">
                                        Ubah
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col col-8">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <!-- <div 
        class="modal fade" 
        id="createModal" 
        tabindex="-1" 
        role="dialog" 
        aria-labelledby="createModalLabel" 
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">
                        Buat penjualan Baru
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary">Simpan penjualan</button>
                </div>
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
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">
                        Ubah penjualan
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div> -->
@endsection

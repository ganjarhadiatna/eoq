@extends('layouts.app')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center mb-2">
                <div class="col-sm">
                    <h3 class="mb-0">Daftar Pembelian</h3>
                </div>
                <div class="col-3 form-inline text-right">
                    <form action="#" class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lg fa-search"></i>
                                </span>
                            </div>
                            <input class="form-control" placeholder="Cari pembelian" type="text">
                        </div>
                    </form>
                </div>
                <div class="col-2 text-right">
                    
                    <button 
                        type="button" 
                        class="btn btn-primary"
                        data-toggle="modal" 
                        data-target="#createModal">
                        <i class="fa fa-lg fa-plus"></i>
                        Tambah
                    </button>

                    <!-- <a href="{{ route('pembelian-tambah') }}">
                        <button 
                            type="button" 
                            class="btn btn-primary" >
                            <i class="fa fa-lg fa-plus"></i>
                            Tambah
                        </button>
                    </a> -->
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
                        <th scope="col">Biaya Gudang</th>
                        <th scope="col">Status</th>
                        <th scope="col" width="200">#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($pembelian as $by)
                        <tr>
                            <th>
                                {{ $i++ }}
                            </th>
                            <td>
                                {{ $by->jumlah_pembelian }}
                            </td>
                            <td>
                                {{ $by->harga_barang }}
                            </td>
                            <td>
                                {{ $by->biaya_gudang }}
                            </td>
                            <td>
                                {{ $by->status }}
                            </td>
                            <td>
                                <a 
                                    href="{{ route('pembelian-remove') }}" 
                                    onclick="
                                        event.preventDefault();
                                        document.getElementById('hapus-items-{{ $by->id }}').submit();">
                                    <button class="btn btn-danger">
                                        Hapus
                                    </button>
                                </a>

                                <form 
                                    id="hapus-items-{{ $by->id }}" 
                                    action="{{ route('pembelian-remove') }}" 
                                    method="POST" 
                                    style="display: none;">
                                    @csrf
                                    <input 
                                        type="hidden" 
                                        name="idpembelian" 
                                        value="{{ $by->id }}">
                                </form>

                                <button 
                                    data-toggle="modal" 
                                    data-target="#editModal"
                                    class="btn btn-success">
                                    Ubah
                                </button>

                                <!-- <a href="{{ route('pembelian-edit', $by->id) }}">
                                    <button 
                                        class="btn btn-success"
                                        data-toggle="modal" 
                                        data-target="#editModal">
                                        Ubah
                                    </button>
                                </a> -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col col-8">
                {{ $pembelian->links() }}
            </div>
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
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">
                        Buat Pembelian Baru
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
                    <button type="button" class="btn btn-primary">Simpan Pembelian</button>
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
                        Ubah Pembelian
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
    </div>
@endsection

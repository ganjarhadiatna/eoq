@extends('layouts.app')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center mb-2">
                <div class="col-sm">
                    <h3 class="mb-0">Daftar Barang</h3>
                </div>
                <div class="col-3 form-inline text-right">
                    <form action="#" class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lg fa-search"></i>
                                </span>
                            </div>
                            <input class="form-control" placeholder="Cari items" type="text">
                        </div>
                    </form>
                </div>
                <div class="col-2 text-right">
                    <!-- <button 
                        type="button" 
                        class="btn btn-primary" 
                        data-toggle="modal" 
                        data-target="#createModal">
                        <i class="fa fa-lg fa-plus"></i>
                        Tambah
                    </button> -->
                    <a href="{{ route('barang-tambah') }}">
                        <button type="button" class="btn btn-primary" >
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
                        <th scope="col">Brang</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Harga</th>
                        <th scope="col" width="100">Diskon</th>
                        <th scope="col">Biaya Pesanan</th>
                        <th scope="col">Biaya Penyimpanan</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col" width="200">#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($items as $etl)
                        <tr>
                            <th>
                                {{ $i++ }}
                            </th>
                            <td>
                                {{ $etl->title }}
                            </td>
                            <td>
                                {{ $etl->stock }}
                            </td>
                            <td>
                                Rp {{ number_format($etl->price) }}
                            </td>
                            <td>
                                {{ $etl->discount * 100 }}%
                            </td>
                            <td>
                                Rp {{ number_format($etl->price_order) }}
                            </td>
                            <td>
                                Rp {{ number_format($etl->price_store) }}
                            </td>
                            <td>
                                {{ $etl->created_at }}
                            </td>
                            <td>
                                <a 
                                    href="{{ route('barang-remove') }}" 
                                    onclick="
                                        event.preventDefault();
                                        document.getElementById('hapus-items-{{ $etl->iditems }}').submit();">
                                    <button class="btn btn-danger">
                                        Hapus
                                    </button>
                                </a>

                                <form 
                                    id="hapus-items-{{ $etl->iditems }}" 
                                    action="{{ route('barang-remove') }}" 
                                    method="POST" 
                                    style="display: none;">
                                    @csrf
                                    <input 
                                        type="hidden" 
                                        name="iditems" 
                                        value="{{ $etl->iditems }}">
                                </form>

                                <a href="{{ route('barang-edit', $etl->iditems) }}">
                                    <button class="btn btn-success">
                                        Ubah
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col col-8">
                {{ $items->links() }}
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
                <form 
                    method="post" 
                    action="javascript:void(0)" 
                    autocomplete="off" 
                    id="form-create"
                    onsubmit="publish()">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">
                            Buat items Baru
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('items') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-items">{{ __('items') }}</label>
                            <input 
                                type="text" 
                                name="items" 
                                id="input-items" 
                                class="form-control form-control-alternative{{ $errors->has('items') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan items') }}"  
                                required 
                                autofocus>

                            @if ($errors->has('items'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('items') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan items</button>
                    </div>
                </form>
            </div>
        </div>
    </div> -->

    <!-- <div 
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
                        Ubah items
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
@extends('layouts.app')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-barang-center mb-2">
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
                            <input class="form-control" placeholder="Cari barang" type="text">
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
                    <!-- <a href="{{ route('barang-tambah') }}">
                        <button type="button" class="btn btn-primary" >
                            <i class="fa fa-lg fa-plus"></i>
                            Tambah
                        </button>
                    </a> -->
                </div>
            </div>
            
        </div>
        <div class="table-responsive">
            <!-- Projects table -->
            <table class="table align-barang-center table-flush">
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
                    @foreach ($barang as $etl)
                        <tr>
                            <th>
                                {{ $i++ }}
                            </th>
                            <td>
                                {{ $etl->judul }}
                            </td>
                            <td>
                                {{ $etl->stok }}
                            </td>
                            <td>
                                Rp {{ number_format($etl->harga) }}
                            </td>
                            <td>
                                {{ $etl->diskon * 100 }}%
                            </td>
                            <td>
                                Rp {{ number_format($etl->biaya_pesanan) }}
                            </td>
                            <td>
                                Rp {{ number_format($etl->biaya_penyimpanan) }}
                            </td>
                            <td>
                                {{ $etl->created_at }}
                            </td>
                            <td>
                                <a 
                                    href="{{ route('barang-remove') }}" 
                                    onclick="
                                        event.preventDefault();
                                        document.getElementById('hapus-barang-{{ $etl->id }}').submit();">
                                    <button class="btn btn-danger">
                                        Hapus
                                    </button>
                                </a>

                                <form 
                                    id="hapus-barang-{{ $etl->id }}" 
                                    action="{{ route('barang-remove') }}" 
                                    method="POST" 
                                    style="display: none;">
                                    @csrf
                                    <input 
                                        type="hidden" 
                                        name="idbarang" 
                                        value="{{ $etl->id }}">
                                </form>

                                <button 
                                    data-toggle="modal" 
                                    data-target="#editModal"
                                    class="btn btn-success">
                                    Ubah
                                </button>

                                <!-- <a href="{{ route('barang-edit', $etl->id) }}">
                                    <button class="btn btn-success">
                                        Ubah
                                    </button>
                                </a> -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col col-8">
                {{ $barang->links() }}
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
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px">
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
                            Tambah Barang Baru
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="title">{{ __('Nama Barang *') }}</label>
                            <input 
                                type="text" 
                                name="title" 
                                id="title" 
                                class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Nama barang') }}"  
                                required 
                                autofocus>
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('stock') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="stock">{{ __('Stok *') }}</label>
                            <input 
                                type="number" 
                                name="stock" 
                                id="stock" 
                                class="form-control form-control-alternative{{ $errors->has('stock') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('1 .. 1000') }}"  
                                min="0"
                                max="1000"
                                required >
                                @if ($errors->has('stock'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('stock') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="price">{{ __('Harga *') }}</label>
                            <input 
                                type="number" 
                                name="price" 
                                id="price" 
                                class="form-control form-control-alternative{{ $errors->has('price') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('500000') }}"  
                                min="0"
                                required >
                                @if ($errors->has('price'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('discount') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="discount">{{ __('Diskon dalam persen (ex: 25)') }}</label>
                            <input 
                                type="number" 
                                name="discount" 
                                id="discount" 
                                class="form-control form-control-alternative{{ $errors->has('discount') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('0 - 100') }}"  
                                min="0"
                                max="100"
                                required >
                                @if ($errors->has('discount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('discount') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('price_order') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="price">{{ __('Biaya pemesanan barang *') }}</label>
                            <input 
                                type="number" 
                                name="price_order" 
                                id="price-order" 
                                class="form-control form-control-alternative{{ $errors->has('price_order') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('500000') }}"  
                                min="0"
                                required >
                                @if ($errors->has('price_order'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('price_store') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="price">{{ __('Biaya penyimpanan barang *') }}</label>
                            <input 
                                type="number" 
                                name="price_store" 
                                id="price_store" 
                                class="form-control form-control-alternative{{ $errors->has('price_store') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('500000') }}"  
                                min="0"
                                required >
                                @if ($errors->has('price_store'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('expire_date') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="expire_date">{{ __('Tanggal kadaluarsa *') }}</label>
                            <input 
                                type="date" 
                                name="expire_date" 
                                id="expire_date" 
                                class="form-control form-control-alternative{{ $errors->has('expire_date') ? ' is-invalid' : '' }}" 
                                required >
                                @if ($errors->has('expire_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('expire_date') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('idkategori') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="idkategori">{{ __('Kategori *') }}</label>
                            <select 
                                name="idkategori" 
                                id="idkategori" 
                                class="form-control form-control-alternative{{ $errors->has('idkategori') ? ' is-invalid' : '' }}" 
                                required>
                                @foreach ($kategori as $ctr)
                                    <option value="{{ $ctr->id }}">{{ $ctr->kategori }}</option>
                                @endforeach
                            </select>
                                @if ($errors->has('idkategori'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('idkategori') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('idetalase') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="idetalase">{{ __('Etalase *') }}</label>
                            <select 
                                name="idetalase" 
                                id="idetalase" 
                                class="form-control form-control-alternative{{ $errors->has('idetalase') ? ' is-invalid' : '' }}" 
                                required>
                                @foreach ($etalase as $etl)
                                    <option value="{{ $etl->id }}">{{ $etl->etalase }}</option>
                                @endforeach
                            </select>
                                @if ($errors->has('idetalase'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('idetalase') }}</strong>
                                    </span>
                                @endif
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan barang</button>
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
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px">
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
                            Ubah Barang
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="title">{{ __('Nama Barang *') }}</label>
                            <input 
                                type="text" 
                                name="title" 
                                id="title" 
                                class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Nama barang') }}"  
                                required 
                                autofocus>
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('stock') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="stock">{{ __('Stok *') }}</label>
                            <input 
                                type="number" 
                                name="stock" 
                                id="stock" 
                                class="form-control form-control-alternative{{ $errors->has('stock') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('1 .. 1000') }}"  
                                min="0"
                                max="1000"
                                required >
                                @if ($errors->has('stock'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('stock') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="price">{{ __('Harga *') }}</label>
                            <input 
                                type="number" 
                                name="price" 
                                id="price" 
                                class="form-control form-control-alternative{{ $errors->has('price') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('500000') }}"  
                                min="0"
                                required >
                                @if ($errors->has('price'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('discount') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="discount">{{ __('Diskon dalam persen (ex: 25)') }}</label>
                            <input 
                                type="number" 
                                name="discount" 
                                id="discount" 
                                class="form-control form-control-alternative{{ $errors->has('discount') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('0 - 100') }}"  
                                min="0"
                                max="100"
                                required >
                                @if ($errors->has('discount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('discount') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('price_order') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="price">{{ __('Biaya pemesanan barang *') }}</label>
                            <input 
                                type="number" 
                                name="price_order" 
                                id="price-order" 
                                class="form-control form-control-alternative{{ $errors->has('price_order') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('500000') }}"  
                                min="0"
                                required >
                                @if ($errors->has('price_order'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('price_store') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="price">{{ __('Biaya penyimpanan barang *') }}</label>
                            <input 
                                type="number" 
                                name="price_store" 
                                id="price_store" 
                                class="form-control form-control-alternative{{ $errors->has('price_store') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('500000') }}"  
                                min="0"
                                required >
                                @if ($errors->has('price_store'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('expire_date') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="expire_date">{{ __('Tanggal kadaluarsa *') }}</label>
                            <input 
                                type="date" 
                                name="expire_date" 
                                id="expire_date" 
                                class="form-control form-control-alternative{{ $errors->has('expire_date') ? ' is-invalid' : '' }}" 
                                required >
                                @if ($errors->has('expire_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('expire_date') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('idkategori') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="idkategori">{{ __('Kategori *') }}</label>
                            <select 
                                name="idkategori" 
                                id="idkategori" 
                                class="form-control form-control-alternative{{ $errors->has('idkategori') ? ' is-invalid' : '' }}" 
                                required>
                                @foreach ($kategori as $ctr)
                                    <option value="{{ $ctr->idkategori }}">{{ $ctr->kategori }}</option>
                                @endforeach
                            </select>
                                @if ($errors->has('idkategori'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('idkategori') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('idetalase') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="idetalase">{{ __('Etalase *') }}</label>
                            <select 
                                name="idetalase" 
                                id="idetalase" 
                                class="form-control form-control-alternative{{ $errors->has('idetalase') ? ' is-invalid' : '' }}" 
                                required>
                                @foreach ($etalase as $etl)
                                    <option value="{{ $etl->id }}">{{ $etl->etalase }}</option>
                                @endforeach
                            </select>
                                @if ($errors->has('idetalase'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('idetalase') }}</strong>
                                    </span>
                                @endif
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center mb-2">
                <div class="col-sm">
                    <h3 class="mb-0">Daftar Suplier</h3>
                </div>
                <div class="col-3 form-inline text-right">
                    <form action="#" class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lg fa-search"></i>
                                </span>
                            </div>
                            <input class="form-control" placeholder="Cari suplier" type="text">
                        </div>
                    </form>
                </div>
                <div class="col-2 text-right">
                    <button 
                        data-toggle="modal" 
                        data-target="#createModal"
                        class="btn btn-primary" >
                        <i class="fa fa-lg fa-plus"></i>
                        Tambah
                    </button>
                    <!-- <a href="{{ route('supplier-tambah') }}">
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
                        <th scope="col">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">Nomor Telpon</th>
                        <th scope="col">Alamat</th>
                        <th scope="col" width="200">#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($supplier as $sp)
                        <tr>
                            <th>
                                {{ $i++ }}
                            </th>
                            <td>
                                {{ $sp->nama }}
                            </td>
                            <td>
                                {{ $sp->email }}
                            </td>
                            <td>
                                {{ $sp->no_telpon }}
                            </td>
                            <td>
                                {{ $sp->alamat }}
                            </td>
                            <td>
                                <a 
                                    href="{{ route('supplier-remove') }}" 
                                    onclick="
                                        event.preventDefault();
                                        document.getElementById('hapus-supplier-{{ $sp->id }}').submit();">
                                    <button type="" class="btn btn-danger">
                                        Hapus
                                    </button>
                                </a>

                                <form 
                                    id="hapus-supplier-{{ $sp->id }}" 
                                    action="{{ route('supplier-remove') }}" 
                                    method="POST" 
                                    style="display: none;">
                                    @csrf
                                    <input 
                                        type="hidden" 
                                        name="idsuppliers" 
                                        value="{{ $sp->id }}">
                                </form>

                                <button 
                                    data-toggle="modal" 
                                    data-target="#editModal"
                                    class="btn btn-success">
                                    Ubah
                                </button>

                                <!-- <a href="{{ route('supplier-edit', $sp->id) }}">
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
                {{ $supplier->links() }}
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
                <form method="post" action="{{ route('supplier-push') }}" autocomplete="off">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">
                            Buat Suplier Baru
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="name">{{ __('Nama') }}</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan nama') }}"  
                                required 
                                autofocus>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="email">{{ __('Email') }}</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan email') }}"  
                                required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('phone_number') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="phone_number">{{ __('Nomor Telpon') }}</label>
                            <input 
                                type="text" 
                                name="phone_number" 
                                id="phone_number" 
                                class="form-control form-control-alternative{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan nomor telpon') }}"  
                                required>
                                @if ($errors->has('phone_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="address">{{ __('Alamat') }}</label>
                            <input 
                                type="address" 
                                name="address" 
                                id="address" 
                                class="form-control form-control-alternative{{ $errors->has('address') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan alamat') }}"  
                                required>
                                @if ($errors->has('address'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary">Simpan Suplier</button>
                    </div>
                </div>
            </form>
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
                <form method="post" action="{{ route('supplier-push') }}" autocomplete="off">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">
                            Ubah Suplier
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="name">{{ __('Nama') }}</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan nama') }}"  
                                required 
                                autofocus>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="email">{{ __('Email') }}</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan email') }}"  
                                required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('phone_number') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="phone_number">{{ __('Nomor Telpon') }}</label>
                            <input 
                                type="text" 
                                name="phone_number" 
                                id="phone_number" 
                                class="form-control form-control-alternative{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan nomor telpon') }}"  
                                required>
                                @if ($errors->has('phone_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="address">{{ __('Alamat') }}</label>
                            <input 
                                type="address" 
                                name="address" 
                                id="address" 
                                class="form-control form-control-alternative{{ $errors->has('address') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan alamat') }}"  
                                required>
                                @if ($errors->has('address'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

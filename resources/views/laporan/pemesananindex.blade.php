@extends('layouts.app')

@section('content')

<div id="wrapper">
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Laporan Pemesanan</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-group fa-fw"></i> Laporan Per-Barang
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('laporan-pemesanan-single-item') }}" method="GET">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm form-group{{ $errors->has('tanggal_awal') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="tanggal_awal">{{ __('Tanggal Awal *') }}</label>
                                        <input 
                                            type="date" 
                                            name="tanggal_awal" 
                                            id="tanggal_awal" 
                                            class="form-control form-control-alternative{{ $errors->has('tanggal_awal') ? ' is-invalid' : '' }}" 
                                            placeholder="{{ __('Nama barang') }}"  
                                            required 
                                            autofocus>
                                            @if ($errors->has('tanggal_awal'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('tanggal_awal') }}</strong>
                                                </span>
                                            @endif
                                            
                                        </select>
                                            @if ($errors->has('tanggal_awal'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('tanggal_awal') }}</strong>
                                                </span>
                                            @endif
                                    </div>

                                    <div class="col-sm form-group{{ $errors->has('tanggal_akhir') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="tanggal_akhir">{{ __('Tanggal Akhir *') }}</label>
                                        <input 
                                            type="date" 
                                            name="tanggal_akhir" 
                                            id="tanggal_akhir" 
                                            class="form-control form-control-alternative{{ $errors->has('tanggal_akhir') ? ' is-invalid' : '' }}" 
                                            placeholder="{{ __('Nama barang') }}"  
                                            required 
                                            autofocus>
                                            @if ($errors->has('tanggal_akhir'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('tanggal_akhir') }}</strong>
                                                </span>
                                            @endif
                                            
                                        </select>
                                            @if ($errors->has('tanggal_akhir'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('tanggal_akhir') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <button type="submit" class="btn btn-primary">Download Laporan Pemesanan Per-Barang</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        
            <div class="col-sm">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-group fa-fw"></i> Laporan Per-Supplier
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('laporan-pemesanan-multi-item') }}" method="GET">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm form-group{{ $errors->has('tanggal_awal') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="tanggal_awal">{{ __('Tanggal Awal *') }}</label>
                                        <input 
                                            type="date" 
                                            name="tanggal_awal" 
                                            id="tanggal_awal" 
                                            class="form-control form-control-alternative{{ $errors->has('tanggal_awal') ? ' is-invalid' : '' }}" 
                                            placeholder="{{ __('Nama barang') }}"  
                                            required 
                                            autofocus>
                                            @if ($errors->has('tanggal_awal'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('tanggal_awal') }}</strong>
                                                </span>
                                            @endif
                                            
                                        </select>
                                            @if ($errors->has('tanggal_awal'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('tanggal_awal') }}</strong>
                                                </span>
                                            @endif
                                    </div>

                                    <div class="col-sm form-group{{ $errors->has('tanggal_akhir') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="tanggal_akhir">{{ __('Tanggal Akhir *') }}</label>
                                        <input 
                                            type="date" 
                                            name="tanggal_akhir" 
                                            id="tanggal_akhir" 
                                            class="form-control form-control-alternative{{ $errors->has('tanggal_akhir') ? ' is-invalid' : '' }}" 
                                            placeholder="{{ __('Nama barang') }}"  
                                            required 
                                            autofocus>
                                            @if ($errors->has('tanggal_akhir'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('tanggal_akhir') }}</strong>
                                                </span>
                                            @endif
                                            
                                        </select>
                                            @if ($errors->has('tanggal_akhir'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('tanggal_akhir') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                    <div class="col-sm form-group{{ $errors->has('tanggal_akhir') ? ' has-danger' : '' }}">
                                        <label for="selectSupplier">Pilih Supplier</label>
                                        <select class="form-control" name="id-supplier" id="id-supplier" required>
                                            <option value="0">Pilih Supplier</option>
                                            @foreach ($supplier as $sp)
                                                <option value="{{ $sp->id }}">{{ $sp->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <button type="submit" class="btn btn-primary">Download Laporan Pemesanan Per-Supplier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
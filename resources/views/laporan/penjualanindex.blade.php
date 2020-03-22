@extends('layouts.app')

@section('content')

<div id="wrapper">
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Laporan</h3>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-group fa-fw"></i> Buat Laporan
                </div>
                <div class="panel-body">
                    <form action="{{ route('laporan-penjualan-create') }}" method="GET">
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
                            <button type="submit" class="btn btn-primary">Download Laporan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
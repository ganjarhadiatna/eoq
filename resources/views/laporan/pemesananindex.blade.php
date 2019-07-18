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
                    <form action="{{ route('laporan-pemesanan-single-item') }}" method="GET">
                        @csrf
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Download Laporan Pemesanan Single Item</button>
                        </div>
                    </form>
                </div>
                <div class="panel-body">
                    <form action="{{ route('laporan-pemesanan-multi-item') }}" method="GET">
                        @csrf
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Download Laporan Pemesanan Multi Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
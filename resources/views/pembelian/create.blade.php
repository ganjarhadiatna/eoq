@extends('layouts.app')

@section('content')
	<div class="card bg-secondary shadow">

        <div class="card-header border-0">
            <div class="nav-wrapper">
                <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">
                            EOQ Sederhana
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">
                            Method 2
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false">
                            Method 3
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-4-tab" data-toggle="tab" href="#tabs-icons-text-4" role="tab" aria-controls="tabs-icons-text-4" aria-selected="false">
                            Method 4
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-5-tab" data-toggle="tab" href="#tabs-icons-text-5" role="tab" aria-controls="tabs-icons-text-5" aria-selected="false">
                            Method 5
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-6-tab" data-toggle="tab" href="#tabs-icons-text-6" role="tab" aria-controls="tabs-icons-text-6" aria-selected="false">
                            Method 6
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-7-tab" data-toggle="tab" href="#tabs-icons-text-7" role="tab" aria-controls="tabs-icons-text-7" aria-selected="false">
                            Method 7
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-8-tab" data-toggle="tab" href="#tabs-icons-text-8" role="tab" aria-controls="tabs-icons-text-8" aria-selected="false">
                            Method 8
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- <div class="card-header border-0">
            <div class="row align-items-center mb-2">
                <div class="col-sm">
                    <h3 class="mb-0">EOQ Sederhana</h3>
                </div>
                <div class="col-2 text-right">
                    
                </div>
            </div>
        </div> -->

        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                    <form>

                        <div>
                            <h3 class="mb-0">Informasi Parameter</h3>
                        </div>

                        <div class="row mb-2">

                            <div class="col-sm">

                                <div class="form-group{{ $errors->has('idbarang') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="idbarang">{{ __('Pilih barang') }}</label>
                                    <select 
                                        name="idbarang"
                                        id="idbarang" 
                                        class="form-control form-control-alternative{{ $errors->has('idbarang') ? ' is-invalid' : '' }}" 
                                        required>
                                        <option value="0"></option>
                                        @foreach ($barang as $br)
                                            <option value="{{ $br->id }}">{{ $br->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('idbarang'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('idbarang') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!-- <div class="form-group{{ $errors->has('jumlah_permintaan') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="jumlah_permintaan">{{ __('Jumlah permintaan customer') }}</label>
                                    <input 
                                        type="number" 
                                        name="jumlah_permintaan" 
                                        id="jumlah_permintaan" 
                                        class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                        required>
                                    @if ($errors->has('jumlah_permintaan'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('jumlah_permintaan') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('diskon') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="diskon">{{ __('Persentase harga barang') }}</label>
                                    <input 
                                        type="number" 
                                        name="diskon" 
                                        id="diskon" 
                                        class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                        required>
                                    @if ($errors->has('diskon'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('diskon') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('biaya_penyimpanan') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="biaya_penyimpanan">{{ __('Biaya penyimpanan') }}</label>
                                    <input 
                                        type="number" 
                                        name="biaya_penyimpanan" 
                                        id="biaya_penyimpanan" 
                                        class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                        required>
                                    @if ($errors->has('biaya_penyimpanan'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('biaya_penyimpanan') }}</strong>
                                        </span>
                                    @endif
                                </div> -->

                            </div>
                            <div class="col-sm">
                                
                                <!-- <div class="form-group{{ $errors->has('idsupplier') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="idsupplier">{{ __('Pilih idsupplier') }}</label>
                                    <select 
                                        name="idsupplier"
                                        id="idsupplier" 
                                        class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                        required>
                                        <option value="0"></option>
                                        @foreach ($supplier as $sup)
                                            <option value="{{ $sup->id }}">{{ $sup->nama }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('idsupplier'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('idsupplier') }}</strong>
                                        </span>
                                    @endif
                                </div> -->

                                <!-- <div class="form-group{{ $errors->has('biaya_pesanan') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="biaya_pesanan">{{ __('Biaya pesanan') }}</label>
                                    <input 
                                        type="number" 
                                        name="biaya_pesanan" 
                                        id="biaya_pesanan" 
                                        class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                        required>
                                    @if ($errors->has('biaya_pesanan'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('biaya_pesanan') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('lead_time') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="lead_time">{{ __('Lead time supplier (per-minggu)') }}</label>
                                    <input 
                                        type="number" 
                                        name="lead_time" 
                                        id="lead_time" 
                                        class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                        required>
                                    @if ($errors->has('lead_time'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('lead_time') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('waktu_operasional') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="waktu_operasional">{{ __('Waktu operasional') }}</label>
                                    <input 
                                        type="number" 
                                        name="waktu_operasional" 
                                        id="waktu_operasional" 
                                        class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                        required>
                                    @if ($errors->has('waktu_operasional'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('waktu_operasional') }}</strong>
                                        </span>
                                    @endif
                                </div> -->

                            </div>
                        </div>

                        <div>
                            <h3 class="mb-0">Hasil Keputusan</h3>
                        </div>

                        <div class="row mb-2">

                            <div class="col-sm">
                                <div class="form-group{{ $errors->has('jumlah_unit') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="jumlah_unit">{{ __('Jumlah unit') }}</label>
                                    <input 
                                        type="number" 
                                        disabled="true" 
                                        name="jumlah_unit" 
                                        id="jumlah_unit" 
                                        class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                        required>
                                    @if ($errors->has('jumlah_unit'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('jumlah_unit') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('total_cost') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="total_cost">{{ __('Total cost persediaan') }}</label>
                                    <input 
                                        type="number" 
                                        disabled="true" 
                                        name="total_cost" 
                                        id="total_cost" 
                                        class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                        required>
                                    @if ($errors->has('total_cost'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('total_cost') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            </div>
                            <div class="col-sm">
                                
                                <div class="form-group{{ $errors->has('frekuensi_pembelian') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="frekuensi_pembelian">{{ __('Frekuensi pembelian per-tahun') }}</label>
                                    <input 
                                        type="number" 
                                        disabled="true" 
                                        name="frekuensi_pembelian" 
                                        id="frekuensi_pembelian" 
                                        class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                        required>
                                    @if ($errors->has('frekuensi_pembelian'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('frekuensi_pembelian') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('reorder_point') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="reorder_point">{{ __('Re-order point') }}</label>
                                    <input 
                                        type="number" 
                                        disabled="true" 
                                        name="reorder_point" 
                                        id="reorder_point" 
                                        class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                        required>
                                    @if ($errors->has('reorder_point'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('reorder_point') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            </div>

                        </div>

                        <div class="row align-items-center mb-2">
                            <div class="col-sm">
                                <button 
                                    type="button" 
                                    class="btn btn-success" 
                                    onclick="generate_eoq()">
                                    Generate EOQ
                                </button>
                            </div>
                            <div class="col-4 text-right">
                                <button 
                                    type="button" 
                                    class="btn btn-secondary" >
                                    Simpan Pesanan
                                </button>
                                <button 
                                    type="submit" 
                                    class="btn btn-primary">
                                    Beli Barang
                                </button>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="tab-pane fade show active" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                </div>

                <div class="tab-pane fade show active" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                </div>

                <div class="tab-pane fade show active" id="tabs-icons-text-4" role="tabpanel" aria-labelledby="tabs-icons-text-4-tab">
                </div>


            </div>
        </div>
    </div>

    <script type="text/javascript">

        function generate_eoq() {
            var idbarang = $('#idbarang').val();
            var idsupplier = $('#idsupplier').val();
            var route = '{{ url("/pesanan/eoq/") }}' + '/' + idbarang;

            console.log(route);

            $.ajax({
                url: route,
                type: 'GET',
                processData: false,
                contentType: false,
                dataType: 'JSON',
                // data: {
                //     'idbarang': idbarang, 
                //     'idsupplier': idsupplier
                // },
            })
            .done(function(data) {

                $('#jumlah_unit').val(data.jumlah_unit);
                $('#total_cost').val(data.total_cost);
                $('#frekuensi_pembelian').val(data.frekuensi_pembelian);
                $('#reorder_point').val(data.reorder_point);

                console.log(data);
            })
            .fail(function(e) {
                console.log("error " + e.responseJSON.message);
            })
            .always(function() {
                console.log("complete");
            });
            
        }
        
    </script>

@endsection
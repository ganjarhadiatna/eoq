@extends('layouts.app')

@section('content')
<div>
    <div>
        <h3 class="mb-0">Batasan Modal</h3>
    </div>

    <div class="row mb-2">

        <div class="col-sm">
            <div class="form-group{{ $errors->has('kendala_modal') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="kendala_modal">{{ __('Modal Yang Dimiliki') }}</label>
                <input 
                    type="text" 
                    name="kendala_modal" 
                    id="kendala_modal" 
                    class="form-control form-control-alternative{{ $errors->has('kendala_modal') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    required>
                @if ($errors->has('kendala_modal'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('kendala_modal') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="col-sm">
            <div>
               <label class="form-control-label" for="idbarang">{{ __('Mulai perhitungan?') }}</label>
               <div>
                    <button 
                        type="button" 
                        class="btn btn-success" 
                        onclick="generate_method()">
                        Generate Metode
                    </button>
               </div>
           </div>
        </div>

    </div>

    <div>
        <h3 class="mb-0">Daftar Barang</h3>
    </div>

    <br>

    <div class="table-responsive">
        <form id="form-modal-barang">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="100">NO</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Harga Beli</th>
                        <th scope="col">Jumlah Permintaan</th>
                        <th scope="col">Biaya Pemesanan</th>
                        <th scope="col">Biaya Simpan</th>
                        <th scope="col">Frekuensi Pembelian</th>
                        <th scope="col">Reorder Point</th>
                        <th scope="col">Jumlah Unit</th>
                        <th scope="col">Total Cost</th>
                        <th scope="col">Kebutuhan Investasi</th>
                        <th scope="col">#</th>
                    </tr>
                </thead>
                <tbody id="daftar-barang"></tbody>
                <tbody>
                    <tr>
                        <th scope="col" colspan="10">Total Investasi</th>
                        <th 
                            scope="col" 
                            id="total-investasi">0</th>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th scope="col" colspan="10">Modal</th>
                        <th 
                            scope="col" 
                            id="total-modal">0</th>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th scope="col" colspan="11">Simpan pemesanan?</th>
                        <td scope="col" width="50">
                            <button 
                                type="button" 
                                class="btn btn-success" 
                                onclick="generate_batasan_modal()">
                                Simpan Pesanan
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>


    <script type="text/javascript">

        var dataBM = [];

        function generate_batasan_modal() {
            // var idsupplier = $('#eoq_idsupplier').val();
            var route = '{{ route("batasan-modal-save") }}';

            // console.log(route);
            if (dataBM.length > 0) {
                var a = confirm('apakah barang yang dipilih sudah tepat?');
                if (a) {
                    $.ajax({
                        url: route,
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            'data': dataBM
                        },
                        beforeSend: function () {
                            opLoading();
                        }
                    })
                    .done(function(data) {
                        if (data.status === 'success') {
                            window.location = '{{ route("pesanan-item") }}';
                        }
                        // console.log(data);
                        clLoading();
                    })
                    .fail(function(e) {
                        console.log("error => " + e.responseJSON.message);
                        clLoading();
                    })
                    .always(function() {
                        console.log("complete");
                    });
                }
            } else {
                alert('pilih satu atau lebih barang barang.');
            }
        }

        function generate_method()
        {
            $('#daftar-barang').html('');
            $('#total-investasi').html('0');
            $('#total-modal').html('0');

            var route = '{{ url("/batasan/modal/generate") }}';
            var kendala_modal = $('#kendala_modal').val();
            var bm_idbarang = 1;
            console.log(kendala_modal);

            if (kendala_modal == '') 
            {
                alert('kendala modal harus diisi.');
            } 
            else 
            {
                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        'kendala_modal': kendala_modal
                    },
                    beforeSend: function () {
                        opLoading();
                    }
                })
                .done(function(data) {
                    var data_save = data.data;
                    var dt = [];
                    var jumlah_unit = 0;
                    var total_cost = 0;
                    for (var i = 0; i < data_save.length; i++) {
                        
                        if (data.status_investasi === 'Feasible') {
                            jumlah_unit = data_save[i].jumlah_unit;
                            total_cost = data_save[i].total_cost;
                        }
                        else  {
                            jumlah_unit =  data_save[i].jumlah_unit_feasible;
                            total_cost = data_save[i].total_cost_feasible;
                        }

                        dt += '\
                            <tr>\
                                <td>'+(i + 1)+'</td>\
                                <td>'+data_save[i].nama_barang+'</td>\
                                <td>Rp. <span id="bm-harga-barang-'+data_save[i].idbarang+'">'+data_save[i].harga_barang+'</span></td>\
                                <td><span id="bm-jumlah-permintaan-'+data_save[i].idbarang+'">'+data_save[i].jumlah_permintaan+'</span></td>\
                                <td>Rp. <span id="bm-biaya-pemesanan-'+data_save[i].idbarang+'">'+data_save[i].biaya_pemesanan+'</span></td>\
                                <td>Rp. <span id="bm-biaya-penyimpanan-'+data_save[i].idbarang+'">'+data_save[i].biaya_penyimpanan+'</span></td>\
                                <td><span id="bm-frekuensi-pembelian-'+data_save[i].idbarang+'">'+data_save[i].frekuensi_pembelian+'</span></td>\
                                <td><span id="bm-reorder-point-'+data_save[i].idbarang+'">'+data_save[i].reorder_point+'</span></td>\
                                <td><span id="bm-jumlah-unit-'+data_save[i].idbarang+'">'+jumlah_unit+'</span></td>\
                                <td>Rp. <span id="bm-total-cost-'+data_save[i].idbarang+'">'+total_cost+'</span></td>\
                                <td><b>Rp. '+data_save[i].kebutuhan_investasi+'</b></td>\
                                <td>\
                                    <label class="custom-toggle">\
                                        <input type="checkbox" value="'+data_save[i].idbarang+'" class="checkbox" />\
                                        <span class="custom-toggle-slider rounded-circle"></span>\
                                    </label>\
                                </td>\
                            </tr>\
                        ';
                    }
                    $('#daftar-barang').html(dt);

                    if (data.status_investasi === 'Feasible') {
                        $('#total-investasi').html('<span class="text-green">Rp. ' + data.total_investasi + '</span>');
                        $('#total-modal').html('<span class="text-green">Rp. ' + data.kendala_modal + '</span>');
                        // $('#status-investasi').html('<span class="text-green">' + data.status_investasi + '</span>');
                    } else {
                        $('#total-investasi').html('<span class="text-red">Rp. ' + data.minimum_biaya + '</span>');
                        $('#total-modal').html('<span class="text-green">Rp. ' + data.kendala_modal + '</span>');
                        // $('#status-investasi').html('<span class="text-red">' + data.status_investasi + '</span>');
                    }

                    // console.log(data);
                    clLoading();
                })
                .fail(function(e) {
                    console.log("error " + e.responseJSON.message);
                    clLoading();
                })
                .always(function() {
                    console.log("complete");
                });
            }
        }

        $(document).ready(function () {
            $('#form-modal-barang').on('change', ':checkbox', function () {
                if ($(this).is(':checked')) {
                    var idbarang = $(this).val();
                    var harga_barang = $('#bm-harga-barang-'+idbarang).html();
                    var biaya_penyimpanan = $('#bm-biaya-penyimpanan-'+idbarang).html();
                    var biaya_pemesanan = $('#bm-biaya-pemesanan-'+idbarang).html();
                    var frekuensi_pembelian = $('#bm-frekuensi-pembelian-'+idbarang).html();
                    var reorder_point = $('#bm-reorder-point-'+idbarang).html();
                    var jumlah_permintaan = $('#bm-jumlah-permintaan-'+idbarang).html();
                    var jumlah_unit = $('#bm-jumlah-unit-'+idbarang).html();
                    var total_cost = $('#bm-total-cost-'+idbarang).html();

                    dataBM.push({
                        'idbarang': idbarang, 
                        'biaya_penyimpanan': biaya_penyimpanan,
                        'biaya_pemesanan': biaya_pemesanan,
                        'jumlah_permintaan': jumlah_permintaan,
                        'frekuensi_pembelian': frekuensi_pembelian,
                        'reorder_point': reorder_point,
                        'harga_barang': harga_barang,
                        'jumlah_unit': jumlah_unit,
                        'total_cost': total_cost
                    });

                    // console.log(dataBM);
                } else {
                    for (var i = 0; i < dataBM.length; i++) {
                        if (dataBM[i].idbarang === $(this).val()) {
                            dataBM.splice(i, 1);
                        }
                    }
                    // console.log(dataBM);
                }
            });
        });
        
    </script>

@endsection
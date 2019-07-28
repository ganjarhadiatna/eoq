@extends('layouts.app')

@section('content')
<div>
    <div>
        <h3 class="mb-0">Batasan Gudang</h3>
    </div>

    <div class="row mb-2">

        <div class="col-sm">
            <div class="form-group{{ $errors->has('idetalase') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="idetalase">{{ __('Pilih Etalase *') }}</label>
                <select 
                    name="idetalase" 
                    id="idetalase" 
                    class="form-control form-control-alternative{{ $errors->has('idetalase') ? ' is-invalid' : '' }}" 
                    required>
                    @foreach ($etalase as $etl)
                        <option value="{{ $etl->id }}">
                            {{ $etl->etalase }} | Luas etalase : {{ $etl->ukuran_etalase }} cm3
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('idetalase'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('idetalase') }}</strong>
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

    <br>

    <div>
        <h3 class="mb-0">Daftar Barang</h3>
    </div>

    <br>

    <div class="table-responsive">
        <form id="form-gudang-barang">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="100">NO</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Harga Beli</th>
                        <th scope="col">Jumlah Unit</th>
                        <th scope="col">Jumlah Permintaan</th>
                        <th scope="col">Biaya Pemesanan</th>
                        <th scope="col">Biaya Penyimpanan</th>
                        <th scope="col">Ukuran Kemasan</th>
                        <th scope="col">Kebutuhan Luas Gudang</th>
                        <th scope="col">Frekuensi Pembelian</th>
                        <th scope="col">Reorder Point</th>
                        <th scope="col">EOQ Luas Gudang</th>
                        <th scope="col">Total Cost</th>
                        <th scope="col">#</th>
                    </tr>
                </thead>
                <tbody id="daftar-barang"></tbody>
                <tbody>
                    <tr>
                        <th scope="col" colspan="13">Simpan pemesanan?</th>
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
                <!-- <tbody>
                    <tr>
                        <th scope="col" colspan="8">Total Luas Gudang</th>
                        <th 
                            scope="col" 
                            id="total-luas-gudang">0</th>
                    </tr>
                </tbody> -->
            </table>
        </form>
    </div>
</div>


    <script type="text/javascript">

        var dataLG = [];

        function generate_batasan_modal() {
            // var idsupplier = $('#eoq_idsupplier').val();
            var route = '{{ route("batasan-gudang-save") }}';

            // console.log(route);
            if (dataLG.length > 0) {
                var a = confirm('apakah barang yang dipilih sudah tepat?');
                if (a) {
                    $.ajax({
                        url: route,
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            'data': dataLG
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
            var route = '{{ url("/batasan/gudang/generate") }}';
            // var luas_gudang = $('#luas_gudang').val();
            var idetalase = $('#idetalase').val();
            var bm_idbarang = 1;

            if (1) 
            {
                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        'idetalase': idetalase
                    },
                    beforeSend: function () {
                        opLoading();
                    }
                })
                .done(function(data) {
                    var data_save = data.data;
                    var dt = [];
                    for (var i = 0; i < data_save.length; i++) {
                        dt += '\
                            <tr>\
                                <td>'+(i + 1)+'</td>\
                                <td>'+data_save[i].nama_barang+'</td>\
                                <td>Rp. <span id="gl-harga-barang-'+data_save[i].idbarang+'">'+data_save[i].harga_barang+'</span></td>\
                                <td><span id="gl-jumlah-unit-dulu-'+data_save[i].idbarang+'">'+data_save[i].jumlah_unit+'</span></td>\
                                <td><span id="gl-jumlah-permintaan-'+data_save[i].idbarang+'">'+data_save[i].jumlah_permintaan+'</span></td>\
                                <td><span id="gl-biaya-pemesanan-'+data_save[i].idbarang+'">'+data_save[i].biaya_pemesanan+'</span></td>\
                                <td><span id="gl-biaya-penyimpanan-'+data_save[i].idbarang+'">'+data_save[i].biaya_penyimpanan+'</span></td>\
                                <td><span id="gl-ukuran-barang-'+data_save[i].idbarang+'">'+data_save[i].ukuran_barang+'</span> cm3</td>\
                                <td><span id="gl-kebutuhan-gudang-'+data_save[i].idbarang+'">'+data_save[i].kebutuhan_gudang+'</span> cm3</td>\
                                <td><span id="gl-frekuensi-pembelian-'+data_save[i].idbarang+'">'+data_save[i].frekuensi_pembelian+'</span></td>\
                                <td><span id="gl-reorder-point-'+data_save[i].idbarang+'">'+data_save[i].reorder_point+'</span></td>\
                                <td><span id="gl-jumlah-unit-'+data_save[i].idbarang+'">'+data_save[i].QL+'</span></td>\
                                <td><span id="gl-total-cost-'+data_save[i].idbarang+'">'+data_save[i].total_cost+'</span></td>\
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
                    // $('#total-luas-gudang').html('<b class="text-green">' + data.total_luas_gudang + ' cm3 </b>');

                    // if (data.status_investasi === 'Feasible') {
                    //     $('#total-investasi').html('<span class="text-green">Rp. ' + data.total_investasi + '</span>');
                    //     $('#total-modal').html('<span class="text-green">Rp. ' + data.luas_gudang + '</span>');
                    //     $('#status-investasi').html('<span class="text-green">' + data.status_investasi + '</span>');
                    // } else {
                    //     $('#total-investasi').html('<span class="text-red">Rp. ' + data.total_investasi + '</span>');
                    //     $('#total-modal').html('<span class="text-green">Rp. ' + data.luas_gudang + '</span>');
                    //     $('#status-investasi').html('<span class="text-red">' + data.status_investasi + '</span>');
                    // }

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
            $('#form-gudang-barang').on('change', ':checkbox', function () {
                if ($(this).is(':checked')) {
                    var idbarang = $(this).val();
                    var harga_barang = $('#gl-harga-barang-'+idbarang).html();
                    var biaya_penyimpanan = $('#gl-biaya-penyimpanan-'+idbarang).html();
                    var biaya_pemesanan = $('#gl-biaya-pemesanan-'+idbarang).html();
                    var frekuensi_pembelian = $('#gl-frekuensi-pembelian-'+idbarang).html();
                    var reorder_point = $('#gl-reorder-point-'+idbarang).html();
                    var jumlah_permintaan = $('#gl-jumlah-permintaan-'+idbarang).html();
                    var jumlah_unit = $('#gl-jumlah-unit-'+idbarang).html();
                    var total_cost = $('#gl-total-cost-'+idbarang).html();

                    dataLG.push({
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

                    // console.log(dataLG);
                } else {
                    for (var i = 0; i < dataLG.length; i++) {
                        if (dataLG[i].idbarang === $(this).val()) {
                            dataLG.splice(i, 1);
                        }
                    }
                    // console.log(dataLG);
                }
            });
        });
        
    </script>

@endsection
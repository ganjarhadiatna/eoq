@extends('layouts.app')

@section('content')
<div>
    <div>
        <h3 class="mb-0">Batasan Gudang</h3>
    </div>

    <div class="row mb-2">

        <!-- <div class="col-sm">
            <div class="form-group{{ $errors->has('luas_gudang') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="luas_gudang">{{ __('Luas Gudang Dimiliki') }}</label>
                <input 
                    type="text" 
                    name="luas_gudang" 
                    id="luas_gudang" 
                    class="form-control form-control-alternative{{ $errors->has('luas_gudang') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    required>
                @if ($errors->has('luas_gudang'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('luas_gudang') }}</strong>
                    </span>
                @endif
            </div>
        </div> -->

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
        <form id="form-barang">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="100">NO</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Harga Beli</th>
                        <th scope="col">Jumlah Permintaan</th>
                        <th scope="col">Biaya Pemesanan</th>
                        <th scope="col">Biaya Simpan</th>
                        <th scope="col">EOQ</th>
                        <th scope="col">Total Cost</th>
                        <th scope="col">Kebutuhan Gudang</th>
                    </tr>
                </thead>
                <tbody id="daftar-barang"></tbody>
                <tbody>
                    <tr>
                        <th scope="col" colspan="8">Total Luas Gudang</th>
                        <th 
                            scope="col" 
                            id="total-luas-gudang">0</th>
                    </tr>
                </tbody>
               <!--  <tbody>
                    <tr>
                        <th scope="col" colspan="8">Modal</th>
                        <th 
                            scope="col" 
                            id="total-modal">0</th>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th scope="col" colspan="8">Status Investasi</th>
                        <th 
                            scope="col" 
                            id="status-investasi"></th>
                    </tr>
                </tbody> -->
            </table>
        </form>
    </div>
</div>


    <script type="text/javascript">

        function generate_method()
        {
            var route = '{{ url("/batasan/gudang/generate") }}';
            // var luas_gudang = $('#luas_gudang').val();
            var bm_idbarang = 1;

            if (1) 
            {
                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'JSON',
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
                                <td>Rp. '+data_save[i].harga_barang+'</td>\
                                <td>'+data_save[i].jumlah_permintaan+'</td>\
                                <td>Rp. '+data_save[i].biaya_pemesanan+'</td>\
                                <td>Rp. '+data_save[i].biaya_penyimpanan+'</td>\
                                <td>'+data_save[i].jumlah_unit+'</td>\
                                <td>Rp. '+data_save[i].total_cost+'</td>\
                                <td><b>'+data_save[i].kapasitas_gudang+' M3</b></td>\
                            </tr>\
                        ';
                    }
                    $('#daftar-barang').html(dt);
                    $('#total-luas-gudang').html('<b class="text-green">' + data.total_luas_gudang + ' M3 </b>');

                    // if (data.status_investasi === 'Feasible') {
                    //     $('#total-investasi').html('<span class="text-green">Rp. ' + data.total_investasi + '</span>');
                    //     $('#total-modal').html('<span class="text-green">Rp. ' + data.luas_gudang + '</span>');
                    //     $('#status-investasi').html('<span class="text-green">' + data.status_investasi + '</span>');
                    // } else {
                    //     $('#total-investasi').html('<span class="text-red">Rp. ' + data.total_investasi + '</span>');
                    //     $('#total-modal').html('<span class="text-green">Rp. ' + data.luas_gudang + '</span>');
                    //     $('#status-investasi').html('<span class="text-red">' + data.status_investasi + '</span>');
                    // }

                    console.log(data);
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
        
    </script>

@endsection
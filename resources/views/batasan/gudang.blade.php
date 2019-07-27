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
                            {{ $etl->etalase }} | Luas etalase : {{ $etl->ukuran_etalase }} M3
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
        <form id="form-barang">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="100">NO</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Harga Beli</th>
                        <th scope="col">EOQ</th>
                        <!-- <th scope="col">Batasan Luas Etalase</th> -->
                        <th scope="col">Ukuran Kemasan</th>
                        <th scope="col">EOQ Dengan Batasan Gudang</th>
                        <th scope="col">Kebutuhan Luas Gudang</th>
                    </tr>
                </thead>
                <tbody id="daftar-barang"></tbody>
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
                                <td>Rp. '+data_save[i].harga_barang+'</td>\
                                <td>'+data_save[i].jumlah_unit+'</td>\
                                <td>'+data_save[i].ukuran_barang+' M3</td>\
                                <td>'+data_save[i].QL+' M3</td>\
                                <td>'+data_save[i].kebutuhan_gudang+' M3</td>\
                            </tr>\
                        ';
                    }
                    $('#daftar-barang').html(dt);
                    // $('#total-luas-gudang').html('<b class="text-green">' + data.total_luas_gudang + ' M3 </b>');

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
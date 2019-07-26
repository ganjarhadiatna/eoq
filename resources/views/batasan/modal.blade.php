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
                        <th scope="col">Kebutuhan Investasi</th>
                    </tr>
                </thead>
                <tbody id="daftar-barang"></tbody>
                <tbody>
                    <tr>
                        <th scope="col" colspan="8">Total Investasi</th>
                        <th 
                            scope="col" 
                            id="total-investasi">0</th>
                    </tr>
                </tbody>
                <tbody>
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
                </tbody>
            </table>
        </form>
    </div>
</div>


    <script type="text/javascript">

        function generate_method()
        {
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
                                <td><b>Rp. '+data_save[i].kebutuhan_investasi+'</b></td>\
                            </tr>\
                        ';
                    }
                    $('#daftar-barang').html(dt);

                    if (data.status_investasi === 'Feasible') {
                        $('#total-investasi').html('<span class="text-green">Rp. ' + data.total_investasi + '</span>');
                        $('#total-modal').html('<span class="text-green">Rp. ' + data.kendala_modal + '</span>');
                        $('#status-investasi').html('<span class="text-green">' + data.status_investasi + '</span>');
                    } else {
                        $('#total-investasi').html('<span class="text-red">Rp. ' + data.total_investasi + '</span>');
                        $('#total-modal').html('<span class="text-green">Rp. ' + data.kendala_modal + '</span>');
                        $('#status-investasi').html('<span class="text-red">' + data.status_investasi + '</span>');
                    }

                    console.log(data);
                })
                .fail(function(e) {
                    console.log("error " + e.responseJSON.message);
                })
                .always(function() {
                    console.log("complete");
                });
            }
        }
        
    </script>

@endsection
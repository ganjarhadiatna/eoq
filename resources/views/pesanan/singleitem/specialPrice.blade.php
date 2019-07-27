<!-- <form 
    name="form-generate-special-price" 
    method="post" 
    action="{{ route('pesanan-singleitem-push') }}"
    autocomplete="off" 
    id="form-generate-special-price"> -->
<form 
    name="form-generate-special-price" 
    method="post" 
    action="javascript:void(0)"
    autocomplete="off" 
    id="form-generate-special-price">

    @csrf

    <input type="hidden" name="tipe" value="Special Order">

    <div>
        <h3 class="mb-0">Informasi Parameter</h3>
    </div>

    <div class="row mb-3">

        <div class="col-sm">
            <div class="form-group{{ $errors->has('idbarang') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="sp_idbarang">{{ __('Pilih Barang') }}</label>
                <select 
                    name="idbarang"
                    id="sp_idbarang" 
                    class="form-control form-control-alternative{{ $errors->has('idbarang') ? ' is-invalid' : '' }}" 
                    required>
                    <option value="0">Pilih barang</option>
                    @foreach ($barang as $br)
                        <option value="{{ $br->id }}">{{ $br->nama_barang.' : Rp. '.number_format($br->harga_barang) }}</option>
                    @endforeach
                </select>
                @if ($errors->has('idbarang'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('idbarang') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="col-sm">
            <div class="form-group{{ $errors->has('harga_spesial') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="sp_harga_spesial">{{ __('Harga Spesial') }}</label>
                <input 
                    type="text" 
                    name="harga_spesial" 
                    id="sp_harga_spesial" 
                    class="form-control form-control-alternative{{ $errors->has('harga_spesial') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    required>
                @if ($errors->has('harga_spesial'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('harga_spesial') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="col-sm">
            <div class="form-group{{ $errors->has('tipe_harga') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="sp_tipe_harga">{{ __('Tipe Pemesanan') }}</label>
                <select 
                    name="tipe_harga"
                    id="sp_tipe_harga" 
                    class="form-control form-control-alternative{{ $errors->has('tipe_harga') ? ' is-invalid' : '' }}" 
                    required>
                    <option value="1">Pemesanan Khusus</option>
                    <option value="2">Pemesanan Normal</option>
                </select>
                @if ($errors->has('tipe_harga'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('tipe_harga') }}</strong>
                    </span>
                @endif
            </div>
        </div>  
    </div>

    <div class="row mb-3">
        <div class="col-sm"></div>
        <div class="col-sm"></div>
        <div class="col-sm">
            <div>
                <label class="form-control-label" for="sp_idbarang">{{ __('Mulai perhitungan?') }}</label>
                <div>
                    <button 
                        type="button" 
                        class="btn btn-success" 
                        onclick="generate_special_price()">
                        Generate Metode
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div>
        <h3 class="mb-0">Hasil Keputusan</h3>
    </div>

    <div class="row mb-2">

        <div class="col-sm">

            <div class="form-group{{ $errors->has('harga_barang') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="sp_harga_barang">{{ __('Harga Barang') }}</label>
                <input 
                    type="text" 
                    name="harga_barang" 
                    id="sp_harga_barang" 
                    class="form-control form-control-alternative{{ $errors->has('harga_barang') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    readonly="true" 
                    required>
                @if ($errors->has('harga_barang'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('harga_barang') }}</strong>
                    </span>
                @endif
            </div>

        </div>
        <div class="col-sm">

            <div class="form-group{{ $errors->has('jumlah_permintaan') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="sp_jumlah_permintaan">{{ __('Jumlah Permintaan') }}</label>
                <input 
                    type="text" 
                    name="jumlah_permintaan" 
                    id="sp_jumlah_permintaan" 
                    class="form-control form-control-alternative{{ $errors->has('jumlah_permintaan') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    readonly="true" 
                    required>
                @if ($errors->has('jumlah_permintaan'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('jumlah_permintaan') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('jumlah_unit') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="sp_jumlah_unit">{{ __('EOQ') }}</label>
                <input 
                    type="text" 
                    name="jumlah_unit" 
                    id="sp_jumlah_unit" 
                    class="form-control form-control-alternative{{ $errors->has('jumlah_unit') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    readonly="true" 
                    required>
                @if ($errors->has('jumlah_unit'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('jumlah_unit') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-sm">
            <div class="form-group{{ $errors->has('total_cost') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="sp_total_cost">{{ __('Total Cost') }}</label>
                <input 
                    type="text" 
                    name="total_cost" 
                    id="sp_total_cost" 
                    class="form-control form-control-alternative{{ $errors->has('total_cost') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    readonly="true" 
                    required>
                @if ($errors->has('total_cost'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('total_cost') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('besar_penghematan') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="sp_besar_penghematan">{{ __('Besar Penghematan') }}</label>
                <input 
                    type="text" 
                    name="besar_penghematan" 
                    id="sp_besar_penghematan" 
                    class="form-control form-control-alternative{{ $errors->has('besar_penghematan') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    readonly="true" 
                    required>
                @if ($errors->has('besar_penghematan'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('besar_penghematan') }}</strong>
                    </span>
                @endif
            </div>

        </div>
        <div class="col-sm">
                                
            <div class="form-group{{ $errors->has('frekuensi_pembelian') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="sp_frekuensi_pembelian">{{ __('Frekuensi pembelian per-tahun') }}</label>
                <input 
                    type="text" 
                    name="frekuensi_pembelian" 
                    id="sp_frekuensi_pembelian" 
                    class="form-control form-control-alternative{{ $errors->has('frekuensi_pembelian') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    readonly="true" 
                    required>
                @if ($errors->has('frekuensi_pembelian'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('frekuensi_pembelian') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('reorder_point') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="sp_reorder_point">{{ __('Re-order point') }}</label>
                <input 
                    type="text" 
                    name="reorder_point" 
                    id="sp_reorder_point" 
                    class="form-control form-control-alternative{{ $errors->has('reorder_point') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    readonly="true" 
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
        <div class="col-sm"></div>
        <div class="col-4 text-right">
            <button 
                type="submit" 
                class="btn btn-danger" >
                Simpan Pesanan
            </button>
        </div>
    </div>
</form>

    <div>
        <h3 class="mb-0">Daftar Barang</h3>
    </div>

    <br>

    <div class="table-responsive">
        <form id="eoq-form-barang">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="100">NO</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Tipe</th>
                        <th scope="col">Frekuensi Pembelian</th>
                        <th scope="col">Reorder Point</th>
                        <th scope="col">EOQ</th>
                        <th scope="col">Total Cost</th>
                    </tr>
                </thead>
                <tbody id="sp-daftar-barang"></tbody>
                <tbody>
                    <tr>
                        <th scope="col" colspan="6">Total Keseluruhan</th>
                        <th scope="col" id="sp-jumlah-unit">0</th>
                        <th scope="col" id="sp-total-cost">0</th>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>

<script type="text/javascript">

    function sp_munculkan_barang() {
        // get barang
        var type = 'Special Order';
        var route = '{{ url("/pesanan/bytype/") }}' + '/' + type;

        if (1) {
            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    opLoading();
                }
            })
            .done(function(data) {
                var dt = '';
                var ttl_eoq = 0;
                var ttl_total_cost = 0;
                
                if (data.length > 0) {
                    // op_eoq_daftar_brang('open');
                    for (var i = 0; i < data.length; i++) {

                        // status pemesanan
                        if (data[i].status_pemesanan !== null) {
                            var status_pemesanan = '<td class="text-orange">Sudah Dihitung</td>';
                        } else {
                            var status_pemesanan = '<td class="text-green">Belum Dihitung</td>';
                        }

                        if (data[i].status_pembelian !== null) {
                            var status_pembelian = '<td class="text-orange">Dalam Pemesanan</td>';
                        } else {
                            var status_pembelian = '<td class="text-green">Belum Dipesan</td>';
                        }

                        ttl_eoq += data[i].jumlah_unit;
                        ttl_total_cost += data[i].total_cost;

                        dt += '\
                        <tr>\
                            <td>'+(i + 1)+'</td>\
                            <td>'+data[i].nama_barang+'</td>\
                            <td>'+data[i].harga_barang+'</td>\
                            <td>'+data[i].tipe+'</td>\
                            <td>'+data[i].frekuensi_pembelian+'</td>\
                            <th>'+data[i].reorder_point+'</th>\
                            <th>'+data[i].jumlah_unit+'</th>\
                            <th>'+data[i].total_cost+'</th>\
                        </tr>'
                    }
                }

                $('#sp-daftar-barang').html(dt);
                $('#sp-jumlah-unit').html(ttl_eoq);
                $('#sp-total-cost').html(ttl_total_cost);

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
    }

        function generate_special_price()
        {
            var route = '{{ url("/pesanan/specialprice") }}';
            var sp_idbarang = $('#sp_idbarang').val();
            var sp_harga_spesial = $('#sp_harga_spesial').val();
            var sp_tipe_harga = $('#sp_tipe_harga').val()
            console.log(sp_idbarang);

            if (sp_idbarang == 0) 
            {
                alert('pilih barang terlebih dahulu.');
            } 
            if (sp_harga_spesial == '') 
            {
                alert('harga spesial harus diisi.');
            } 
            else 
            {
                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        'idbarang': sp_idbarang,
                        'special_price': sp_harga_spesial,
                        'tipe_harga': sp_tipe_harga
                    },
                    beforeSend: function () {
                        opLoading();
                    }
                })
                .done(function(data) {
                    $('#sp_harga_barang').val(data.harga_barang);
                    $('#sp_jumlah_unit').val(data.jumlah_unit);
                    $('#sp_total_cost').val(data.total_cost);
                    $('#sp_frekuensi_pembelian').val(data.frekuensi_pembelian);
                    $('#sp_reorder_point').val(data.reorder_point);
                    $('#sp_besar_penghematan').val(data.besar_penghematan);
                    $('#sp_jumlah_permintaan').val(data.jumlah_permintaan);
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

    $(document).ready(function() {
        sp_munculkan_barang();

        $('#form-generate-special-price').on('submit', function(event) {
            event.preventDefault();
            /* Act on the event */

            // console.log(event.target);
            var target = event.target;
            var token = target[0].value;
            var tipe = target[1].value;
            var idbarang = target[2].value;
            var harga_barang = target[6].value;
            var jumlah_unit = target[8].value;
            var total_cost = target[9].value;
            var frekuensi_pembelian = target[11].value;
            var reorder_point = target[12].value;

            $.ajax({
                url: '{{ route("pesanan-singleitem-push") }}',
                type: 'post',
                dataType: 'json',
                data: {
                    '_token': token,
                    'idbarang': idbarang,
                    'tipe': tipe,
                    'harga_barang': harga_barang,
                    'total_cost': total_cost,
                    'jumlah_unit': jumlah_unit,
                    'frekuensi_pembelian': frekuensi_pembelian,
                    'reorder_point': reorder_point
                },
            })
            .done(function(data) {
                if (data.status === 'success') {
                    sp_munculkan_barang();
                } else {
                    alert(data.message);
                }

                // console.log(data);
            })
            .fail(function(e) {
                console.log("error => " + e.responseJSON.message);
            })
            .always(function() {
                console.log("complete");
            });
            
        });

    });
        
</script>
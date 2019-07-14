<!-- <form 
    name="form-generate-sp" 
    method="post" 
    action="{{ route('pesanan-multiitem-push') }}"
    autocomplete="off" 
    id="form-generate-sp"> -->

    <!-- @csrf -->
<div>
    <div>
        <h3 class="mb-0">Informasi Parameter</h3>
    </div>

    <div class="row mb-3">

        <div class="col-sm">
            <div class="form-group{{ $errors->has('ip_idsupplier') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="ip_idsupplier">{{ __('Pilih supplier') }}</label>
                <select 
                    name="ip_idsupplier"
                    id="ip_idsupplier" 
                    class="form-control form-control-alternative{{ $errors->has('ip_idsupplier') ? ' is-invalid' : '' }}" 
                    required>
                    <option value="0">Pilih Supplier</option>
                    @foreach ($supplier as $br)
                        <option value="{{ $br->id }}">{{ $br->nama }}</option>
                    @endforeach
                </select>
                @if ($errors->has('ip_idsupplier'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('ip_idsupplier') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-sm">
            <div class="form-group{{ $errors->has('ip_increase_price') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="ip_increase_price">{{ __('Kenaikan Harga') }}</label>
                <input 
                    type="text" 
                    name="ip_increase_price" 
                    id="ip_increase_price" 
                    class="form-control form-control-alternative{{ $errors->has('ip_increase_price') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    required>
                @if ($errors->has('ip_increase_price'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('ip_increase_price') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-sm">
            <div class="form-group{{ $errors->has('ip_tipe_harga') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="ip_tipe_harga">{{ __('Tipe Pemesanan') }}</label>
                <select 
                    name="ip_tipe_harga"
                    id="ip_tipe_harga" 
                    class="form-control form-control-alternative{{ $errors->has('ip_tipe_harga') ? ' is-invalid' : '' }}" 
                    required>
                    <option value="1">Pemesanan Khusus</option>
                    <option value="2">Pemesanan Normal</option>
                </select>
                @if ($errors->has('ip_tipe_harga'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('ip_tipe_harga') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div>
        <h3 class="mb-0">Daftar Barang</h3>
    </div>

    <div class="table-responsive">
        <form id="ip-form-barang">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="100">NO</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Status Pemesanan</th>
                        <th scope="col">Status Pembelian</th>
                        <th scope="col">EOQ</th>
                        <th scope="col">Total Cost</th>
                        <th scope="col" width="50">#</th>
                    </tr>
                </thead>
                <tbody id="ip-daftar-barang"></tbody>
                <tbody id="ip-daftar-barang">
                    <tr>
                        <th scope="col" colspan="6">Total Keseluruhan</th>
                        <th scope="col" id="ip-jumlah-unit">0</th>
                        <th scope="col" id="ip-total-cost">0</th>
                        <td scope="col" width="50">
                            <button 
                                type="button" 
                                class="btn btn-success" 
                                onclick="generate_sp_multititem()">
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
    var datasp = [];
    var clNow = "modal fade";
    var clOpen = "modal fade show";

    function ip_sp_daftar_brang(stt) 
    {
        if (stt == 'open')
        {
            $('#ip-modal-barang').attr('class', clOpen).show();
        } 
        else 
        {
            $('#ip-modal-barang').attr('class', clNow).hide();
        }
    }

    function sp_event_barang(event) {
        console.log($(this).is(':checked'));
    }

    function ip_munculkan_barang() {
        // get barang
        var idsupplier = $('#ip_idsupplier').val();
        var route = '{{ url("/barang/bysupplier/") }}' + '/' + idsupplier;

        if (idsupplier == 0) {
            // alert('pilih supplier terlebih dahulu.');
            $('#ip-daftar-barang').html('');
        } else {
            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'json'
            })
            .done(function(data) {
                var dt = '';
                
                if (data.length > 0) {
                    // ip_sp_daftar_brang('open');
                    for (var i = 0; i < data.length; i++) {

                        // status pemesanan
                        if (data[i].status_pemesanan !== null) {
                            var status_pemesanan = '<td class="text-orange">Sudah Dipesan</td>';
                        } else {
                            var status_pemesanan = '<td class="text-green">Belum Dipesan</td>';
                        }

                        if (data[i].status_pembelian !== null) {
                            var status_pembelian = '<td class="text-orange">Dalam Pembelian</td>';
                        } else {
                            var status_pembelian = '<td class="text-green">Belum Dibeli</td>';
                        }

                        dt += '\
                        <tr>\
                            <td>'+(i + 1)+'</td>\
                            <td>'+data[i].nama_barang+'</td>\
                            <td>'+data[i].harga_barang+'</td>\
                            <td>'+data[i].stok+'</td>\
                            '+status_pemesanan+'\
                            '+status_pembelian+'\
                            <th id="ip-jumlah-unit-'+data[i].id+'">0</th>\
                            <th id="ip-total-cost-'+data[i].id+'">0</th>\
                            <td>\
                                <label class="custom-toggle">\
                                    <input type="checkbox" value="'+data[i].id+'" class="checked" />\
                                    <span class="custom-toggle-slider rounded-circle"></span>\
                                </label>\
                            </td>\
                        </tr>'
                    }
                }

                $('#ip-daftar-barang').html(dt);

                // console.log(data);
            })
            .fail(function(e) {
                console.log("error => " + e.responseJSON.message);
            })
            .always(function() {
                console.log("complete");
            });
            
        }
    }

    function ip_update_total() {
        var jumlah_unit = 0;
        var total_cost = 0;

        for (var i = 0; i < datasp.length; i++) {
            var jumlah_unit = jumlah_unit + datasp[i].jumlah_unit;
            var total_cost = total_cost + datasp[i].total_cost;
        }

        $('#ip-jumlah-unit').html(jumlah_unit);
        $('#ip-total-cost').html(total_cost);
    }

    function generate_sp_multititem() {
        var idsupplier = $('#ip_idsupplier').val();
        var special_order = $('#ip_increase_price').val();
        var tipe_harga = $('#ip_tipe_harga').val()
        var route = '{{ url("/pesanan/multiitem/sp/") }}';

        // console.log(route);
        if (datasp.length > 0) {
            var a = confirm('apakah barang yang dipilih sudah tepat?');
            if (a) {
                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'idsupplier': idsupplier, 
                        'special_order': special_order,
                        'tipe_harga': tipe_harga,
                        'data': datasp
                    }
                })
                .done(function(data) {
                    if (data.status === 'success') {
                        window.location = '{{ route("pesanan-item") }}';
                    }
                    // console.log(data);
                })
                .fail(function(e) {
                    console.log("error => " + e.responseJSON.message);
                })
                .always(function() {
                    console.log("complete");
                });
            }
        } else {
            alert('pilih satu atau lebih barang barang.');
        }
    }

    function generate_sp_singleitem(idbarang) 
    {
        
        var route = '{{ url("/pesanan/specialprice") }}';
        var ip_idsupplier = $('#ip_idsupplier').val();
        var ip_increase_price = $('#ip_increase_price').val();
        var ip_tipe_harga = $('#ip_tipe_harga').val()

        if (ip_increase_price > 0) {
            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'JSON',
                data: {
                    'idbarang': idbarang,
                    'idsupplier': ip_idsupplier,
                    'special_price': ip_increase_price,
                    'tipe_harga': ip_tipe_harga
                }
            })
            .done(function(data) {
                datasp.push({
                    'idbarang': idbarang, 
                    'biaya_penyimpanan': data.biaya_penyimpanan,
                    'jumlah_permintaan': data.jumlah_permintaan,
                    'harga_barang': data.harga_barang,
                    'jumlah_unit': data.jumlah_unit,
                    'total_cost': data.total_cost
                });

                $('#ip-jumlah-unit-'+idbarang).html(data.jumlah_unit);
                $('#ip-total-cost-'+idbarang).html(data.total_cost);

                ip_update_total();
                console.log(data);
            })
            .fail(function(e) {
                alert(e.responseJSON.message);
                // console.log("error " + e);
                $('#ip-jumlah-unit-'+idbarang).html('0');
                $('#ip-total-cost-'+idbarang).html('0');

                ip_update_total();
            })
            .always(function() {
                console.log("complete");
            });
        } else {
            alert('harga spesial tidak boleh kosong.');
        }
            
    }

    $(document).ready(function () {
        
        $('#ip_idsupplier').change(function(event) {
            // event.preventDefault();
            ip_munculkan_barang();

            datasp = [];
            ip_update_total();
        });

        $('#ip-form-barang').on('change', ':checkbox', function () {
            if ($(this).is(':checked')) {
                
                generate_sp_singleitem($(this).val());

            } else {
                // console.log($(this).val() + ' is now unchecked');
                $('#ip-jumlah-unit-'+$(this).val()).html('0');
                $('#ip-total-cost-'+$(this).val()).html('0');

                // remove array
                for (var i = 0; i < datasp.length; i++) {
                    if (datasp[i].idbarang === $(this).val()) {
                        datasp.splice(i, 1);
                    }
                }

                ip_update_total();
            }
            // console.log(datasp);
        });

    });

</script>

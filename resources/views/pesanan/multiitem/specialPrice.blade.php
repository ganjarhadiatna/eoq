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
            <div class="form-group{{ $errors->has('sp_idsupplier') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="sp_idsupplier">{{ __('Pilih supplier') }}</label>
                <select 
                    name="sp_idsupplier"
                    id="sp_idsupplier" 
                    class="form-control form-control-alternative{{ $errors->has('sp_idsupplier') ? ' is-invalid' : '' }}" 
                    required>
                    <option value="0">Pilih Supplier</option>
                    @foreach ($supplier as $br)
                        <option value="{{ $br->id }}">{{ $br->nama }}</option>
                    @endforeach
                </select>
                @if ($errors->has('sp_idsupplier'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('sp_idsupplier') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-sm">
            <div class="form-group{{ $errors->has('sp_harga_spesial') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="sp_harga_spesial">{{ __('Harga Spesial') }}</label>
                <input 
                    type="text" 
                    name="sp_harga_spesial" 
                    id="sp_harga_spesial" 
                    class="form-control form-control-alternative{{ $errors->has('sp_harga_spesial') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    required>
                @if ($errors->has('sp_harga_spesial'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('sp_harga_spesial') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-sm">
            <div class="form-group{{ $errors->has('sp_tipe_harga') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="sp_tipe_harga">{{ __('Tipe Pemesanan') }}</label>
                <select 
                    name="sp_tipe_harga"
                    id="sp_tipe_harga" 
                    class="form-control form-control-alternative{{ $errors->has('sp_tipe_harga') ? ' is-invalid' : '' }}" 
                    required>
                    <option value="1">Pemesanan Khusus</option>
                    <option value="2">Pemesanan Normal</option>
                </select>
                @if ($errors->has('sp_tipe_harga'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('sp_tipe_harga') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div>
        <h3 class="mb-0">Daftar Barang</h3>
    </div>

    <div class="table-responsive">
        <form id="sp-form-barang">
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
                <tbody id="sp-daftar-barang"></tbody>
                <tbody id="sp-daftar-barang">
                    <tr>
                        <th scope="col" colspan="6">Total Keseluruhan</th>
                        <th scope="col" id="sp-jumlah-unit">0</th>
                        <th scope="col" id="sp-total-cost">0</th>
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

    function op_sp_daftar_brang(stt) 
    {
        if (stt == 'open')
        {
            $('#sp-modal-barang').attr('class', clOpen).show();
        } 
        else 
        {
            $('#sp-modal-barang').attr('class', clNow).hide();
        }
    }

    function sp_event_barang(event) {
        console.log($(this).is(':checked'));
    }

    function sp_munculkan_barang() {
        // get barang
        var idsupplier = $('#sp_idsupplier').val();
        var route = '{{ url("/barang/bysupplier/") }}' + '/' + idsupplier;

        if (idsupplier == 0) {
            // alert('pilih supplier terlebih dahulu.');
            $('#sp-daftar-barang').html('');
        } else {
            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'json'
            })
            .done(function(data) {
                var dt = '';
                
                if (data.length > 0) {
                    // op_sp_daftar_brang('open');
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
                            <th id="sp-jumlah-unit-'+data[i].id+'">0</th>\
                            <th id="sp-total-cost-'+data[i].id+'">0</th>\
                            <td>\
                                <label class="custom-toggle">\
                                    <input type="checkbox" value="'+data[i].id+'" class="checked" />\
                                    <span class="custom-toggle-slider rounded-circle"></span>\
                                </label>\
                            </td>\
                        </tr>'
                    }
                }

                $('#sp-daftar-barang').html(dt);

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

    function sp_update_total() {
        var jumlah_unit = 0;
        var total_cost = 0;

        for (var i = 0; i < datasp.length; i++) {
            var jumlah_unit = jumlah_unit + datasp[i].jumlah_unit;
            var total_cost = total_cost + datasp[i].total_cost;
        }

        $('#sp-jumlah-unit').html(jumlah_unit);
        $('#sp-total-cost').html(total_cost);
    }

    function generate_sp_multititem() {
        var idsupplier = $('#sp_idsupplier').val();
        var special_order = $('#sp_harga_spesial').val();
        var tipe_harga = $('#sp_tipe_harga').val()
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
        var sp_idsupplier = $('#sp_idsupplier').val();
        var sp_harga_spesial = $('#sp_harga_spesial').val();
        var sp_tipe_harga = $('#sp_tipe_harga').val()

        if (sp_harga_spesial > 0) {
            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'JSON',
                data: {
                    'idbarang': idbarang,
                    'idsupplier': sp_idsupplier,
                    'special_price': sp_harga_spesial,
                    'tipe_harga': sp_tipe_harga
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

                $('#sp-jumlah-unit-'+idbarang).html(data.jumlah_unit);
                $('#sp-total-cost-'+idbarang).html(data.total_cost);

                sp_update_total();
                console.log(data);
            })
            .fail(function(e) {
                alert(e.responseJSON.message);
                // console.log("error " + e);
                $('#sp-jumlah-unit-'+idbarang).html('0');
                $('#sp-total-cost-'+idbarang).html('0');

                sp_update_total();
            })
            .always(function() {
                console.log("complete");
            });
        } else {
            alert('harga spesial tidak boleh kosong.');
        }
            
    }

    $(document).ready(function () {
        
        $('#sp_idsupplier').change(function(event) {
            // event.preventDefault();
            sp_munculkan_barang();

            datasp = [];
            sp_update_total();
        });

        $('#sp-form-barang').on('change', ':checkbox', function () {
            if ($(this).is(':checked')) {
                
                generate_sp_singleitem($(this).val());

            } else {
                // console.log($(this).val() + ' is now unchecked');
                $('#sp-jumlah-unit-'+$(this).val()).html('0');
                $('#sp-total-cost-'+$(this).val()).html('0');

                // remove array
                for (var i = 0; i < datasp.length; i++) {
                    if (datasp[i].idbarang === $(this).val()) {
                        datasp.splice(i, 1);
                    }
                }

                sp_update_total();
            }
            // console.log(datasp);
        });

    });

</script>

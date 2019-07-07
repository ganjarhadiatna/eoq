<!-- <form 
    name="form-generate-ip" 
    method="post" 
    action="{{ route('pesanan-multiitem-push') }}"
    autocomplete="off" 
    id="form-generate-ip"> -->

    <!-- @csrf -->
<div>
    <div>
        <h3 class="mb-0">Informasi Parameter</h3>
    </div>

    <div class="row mb-2">

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
                    <ipan class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('ip_idsupplier') }}</strong>
                    </ipan>
                @endif
            </div>
        </div>
        <div class="col-sm">
            <div class="col-sm">
                <div class="form-group{{ $errors->has('ip_kenaikan_harga') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="ip_kenaikan_harga">{{ __('Kenaikan Harga') }}</label>
                    <input 
                        type="text" 
                        name="ip_kenaikan_harga" 
                        id="ip_kenaikan_harga" 
                        class="form-control form-control-alternative{{ $errors->has('ip_kenaikan_harga') ? ' is-invalid' : '' }}" 
                        placeholder="0" 
                        required>
                    @if ($errors->has('ip_kenaikan_harga'))
                        <ipan class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('ip_kenaikan_harga') }}</strong>
                        </ipan>
                    @endif
                </div>
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
                                onclick="generate_ip_multititem()">
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
    var dataip = [];
    var clNow = "modal fade";
    var clOpen = "modal fade show";

    function op_ip_daftar_brang(stt) 
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

    function ip_event_barang(event) {
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
                    // op_ip_daftar_brang('open');
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
                                    <ipan class="custom-toggle-slider rounded-circle"></ipan>\
                                </label>\
                            </td>\
                        </tr>'
                    }
                }

                $('#ip-daftar-barang').html(dt);

                // console.log(data);
            })
            .fail(function(e) {
                console.log("error => " + e.reiponseJSON.message);
            })
            .always(function() {
                console.log("complete");
            });
            
        }
    }

    function ip_update_total() {
        var jumlah_unit = 0;
        var total_cost = 0;

        for (var i = 0; i < dataip.length; i++) {
            var jumlah_unit = jumlah_unit + dataip[i].jumlah_unit;
            var total_cost = total_cost + dataip[i].total_cost;
        }

        $('#ip-jumlah-unit').html(jumlah_unit);
        $('#ip-total-cost').html(total_cost);
    }

    function generate_ip_multititem() {
        var idsupplier = $('#ip_idsupplier').val();
        var biaya_backorder = $('#ip_kenaikan_harga').val();
        var route = '{{ url("/pesanan/multiitem/ip/") }}';

        // console.log(route);
        if (dataip.length > 0) {
            var a = confirm('apakah barang yang dipilih sudah tepat?');
            if (a) {
                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'idsupplier': idsupplier, 
                        'biaya_backorder': biaya_backorder,
                        'data': dataip
                    }
                })
                .done(function(data) {
                    if (data.status === 'success') {
                        window.location = '{{ route("pesanan-item") }}';
                    }
                    // console.log(data);
                })
                .fail(function(e) {
                    console.log("error => " + e.reiponseJSON.message);
                })
                .always(function() {
                    console.log("complete");
                });
            }
        } else {
            alert('pilih satu atau lebih barang barang.');
        }
    }

    function generate_ip_singleitem(idbarang) 
    {
        
        var route = '{{ url("/pesanan/backorder") }}';
        var idsupplier = $('#ip_idsupplier').val();
        var ip_kenaikan_harga = $('#ip_kenaikan_harga').val();

        if (ip_kenaikan_harga > 0) {
            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'JSON',
                data: {
                    'idbarang': idbarang,
                    'idsupplier': idsupplier,
                    'biaya_backorder': ip_kenaikan_harga
                }
            })
            .done(function(data) {
                dataip.push({
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
                // console.log(data);
            })
            .fail(function(e) {
                console.log("error " + e.reiponseJSON.message);
                $('#ip-jumlah-unit-'+idbarang).html('0');
                $('#ip-total-cost-'+idbarang).html('0');

                ip_update_total();
            })
            .always(function() {
                console.log("complete");
            });
        } else {
            alert('biaya backorder tidak boleh kosong.');
        }
            
    }

    $(document).ready(function () {
        
        $('#ip_idsupplier').change(function(event) {
            // event.preventDefault();
            ip_munculkan_barang();

            dataip = [];
            ip_update_total();
        });

        $('#ip-form-barang').on('change', ':checkbox', function () {
            if ($(this).is(':checked')) {
                
                generate_ip_singleitem($(this).val());

            } else {
                // console.log($(this).val() + ' is now unchecked');
                $('#ip-jumlah-unit-'+$(this).val()).html('0');
                $('#ip-total-cost-'+$(this).val()).html('0');

                // remove array
                for (var i = 0; i < dataip.length; i++) {
                    if (dataip[i].idbarang === $(this).val()) {
                        dataip.iplice(i, 1);
                    }
                }

                ip_update_total();
            }
            // console.log(dataip);
        });

    });

</script>

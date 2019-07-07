<!-- <form 
    name="form-generate-qd" 
    method="post" 
    action="{{ route('pesanan-multiitem-push') }}"
    autocomplete="off" 
    id="form-generate-qd"> -->

    <!-- @csrf -->
<div>
    <div>
        <h3 class="mb-0">Informasi Parameter</h3>
    </div>

    <div class="row mb-2">

        <div class="col-sm">
            <div class="form-group{{ $errors->has('qd_idbarang') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="qd_idbarang">{{ __('Pilih barang') }}</label>
                <select 
                    name="qd_idbarang"
                    id="qd_idbarang" 
                    class="form-control form-control-alternative{{ $errors->has('qd_idbarang') ? ' is-invalid' : '' }}" 
                    required>
                    <option value="0">Pilih Supplier</option>
                    @foreach ($supplier as $br)
                        <option value="{{ $br->id }}">{{ $br->nama }}</option>
                    @endforeach
                </select>
                @if ($errors->has('qd_idbarang'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('qd_idbarang') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-sm">

            <!-- <div class="form-group{{ $errors->has('qd_tipe_harga') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="qd_tipe_harga">{{ __('Pilih tipe harga') }}</label>
                <select 
                    name="tipe_harga"
                    id="qd_tipe_harga" 
                    class="form-control form-control-alternative{{ $errors->has('qd_tipe_harga') ? ' is-invalid' : '' }}" 
                    required>
                    <option value="khusus">Harga Khusus</option>
                    <option value="normal">Harga Normal</option>
                </select>
                @if ($errors->has('qd_tipe_harga'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('qd_tipe_harga') }}</strong>
                    </span>
                @endif
            </div> -->

            <!-- <div class="form-group{{ $errors->has('qd_biaya_pemesanan') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="qd_biaya_pemesanan">{{ __('Pilih tipe harga') }}</label>
                <div class="row">
                    <div class="custom-control custom-radio mb-3" style="margin-left: 15px;">
                        <input 
                            type="radio" 
                            name="qd-tipe-harga"
                            id="qd-tipe-harga-1" 
                            class="custom-control-input"
                            checked="true">
                        <label 
                            class="custom-control-label" 
                            for="qd-tipe-harga-1">
                            Harga Khusus
                        </label>
                    </div>
                    <div class="custom-control custom-radio mb-3" style="margin-left: 15px;">
                        <input 
                            type="radio" 
                            name="qd-tipe-harga"
                            id="qd-tipe-harga-2" 
                            class="custom-control-input"
                            checked="false">
                        <label 
                            class="custom-control-label" 
                            for="qd-tipe-harga-2">
                            Harga Normal
                        </label>
                    </div>
                </div>
            </div> -->

            <!-- <div>
	           <label class="form-control-label" for="idsupplier">{{ __('Munculkan barang?') }}</label>
	           <div>
                    <button 
                        type="button" 
                        class="btn btn-success" 
                        onclick="qd_munculkan_barang()">
                        Munculkan Barang
                    </button>
	           </div>
           </div> -->
        </div>
    </div>

    <div>
        <h3 class="mb-0">Daftar Barang</h3>
    </div>

    <div class="table-responsive">
        <form id="qd-form-barang">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="100">NO</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Status Pemesanan</th>
                        <th scope="col">Status Pembelian</th>
                        <th scope="col">qd</th>
                        <th scope="col">Total Cost</th>
                        <th scope="col" width="50">#</th>
                    </tr>
                </thead>
                <tbody id="qd-daftar-barang"></tbody>
            </table>
        </form>
    </div>

</div>

<script type="text/javascript">
    var dataqd = [];
    var clNow = "modal fade";
    var clOpen = "modal fade show";

    function op_qd_daftar_brang(stt) 
    {
        if (stt == 'open')
        {
            $('#qd-modal-barang').attr('class', clOpen).show();
        } 
        else 
        {
            $('#qd-modal-barang').attr('class', clNow).hide();
        }
    }

    function qd_event_barang(event) {
        console.log($(this).is(':checked'));
    }

    function qd_munculkan_barang() {
        // get barang
        var idsupplier = $('#qd_idbarang').val();
        var route = '{{ url("/barang/bysupplier/") }}' + '/' + idsupplier;

        if (idsupplier == 0) {
            // alert('pilih supplier terlebih dahulu.');
            $('#qd-daftar-barang').html('');
        } else {
            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'json'
            })
            .done(function(data) {
                var dt = '';
                
                if (data.length > 0) {
                    // op_qd_daftar_brang('open');
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
                            <th id="qd-jumlah-unit-'+data[i].id+'">0</th>\
                            <th id="qd-total-cost-'+data[i].id+'">0</th>\
                            <td>\
                                <button \
                                    type="button" \
                                    class="btn btn-success" \
                                    onclick="generate_sp_multititem()">\
                                    Simpan Pesanan\
                                </button>\
                            </td>\
                        </tr>'
                    }
                }

                $('#qd-daftar-barang').html(dt);

                // console.log(data);
            })
            .fail(function(e) {
                console.log("error => " + e);
            })
            .always(function() {
                console.log("complete");
            });
            
        }
    }

    function qd_update_total() {
        var jumlah_unit = 0;
        var total_cost = 0;

        for (var i = 0; i < dataqd.length; i++) {
            var jumlah_unit = jumlah_unit + dataqd[i].jumlah_unit;
            var total_cost = total_cost + dataqd[i].total_cost;
        }

        $('#qd-jumlah-unit').html(jumlah_unit);
        $('#qd-total-cost').html(total_cost);
    }

    function generate_qd_multititem() {
        var idsupplier = $('#qd_idbarang').val();
        var route = '{{ url("/pesanan/multiitem/qd/") }}';

        // console.log(route);
        if (dataqd.length > 0) {
            var a = confirm('apakah barang yang dipilih sudah tepat?');
            if (a) {
                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'idsupplier': idsupplier, 
                        'data': dataqd
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

    function generate_qd_singleitem(idbarang) 
    {
        
        var route = '{{ url("/pesanan/qd") }}';
        var idsupplier = $('#qd_idbarang').val();
        // var qd_tipe_harga = $('#qd_tipe_harga').val();

        // console.log(idbarang);

        $.ajax({
            url: route,
            type: 'GET',
            dataType: 'JSON',
            data: {
                'idbarang': idbarang,
                'idsupplier': idsupplier,
                // 'tipe_harga': qd_tipe_harga
            }
        })
        .done(function(data) {
            dataqd.push({
                'idbarang': idbarang, 
                'biaya_penyimpanan': data.biaya_penyimpanan,
                'jumlah_permintaan': data.jumlah_permintaan,
                'harga_barang': data.harga_barang,
                'jumlah_unit': data.jumlah_unit,
                'total_cost': data.total_cost
            });
            $('#qd-jumlah-unit-'+idbarang).html(data.jumlah_unit);
            $('#qd-total-cost-'+idbarang).html(data.total_cost);

            qd_update_total();
            // console.log(data);
        })
        .fail(function(e) {
            // console.log("error " + e);
            $('#qd-jumlah-unit-'+idbarang).html('0');
            $('#qd-total-cost-'+idbarang).html('0');

            qd_update_total();
        })
        .always(function() {
            console.log("complete");
        });
            
    }

    $(document).ready(function () {
        
        $('#qd_idbarang').change(function(event) {
            event.preventDefault();
            qd_munculkan_barang();

            dataqd = [];
            qd_update_total();
        });

        $('#qd-form-barang').on('change', ':checkbox', function () {
            if ($(this).is(':checked')) {
                // console.log($(this).val() + ' is now checked');
                generate_qd_singleitem($(this).val());

                // add array
                // dataqd.push($(this).val());
            } else {
                // console.log($(this).val() + ' is now unchecked');
                $('#qd-jumlah-unit-'+$(this).val()).html('0');
                $('#qd-total-cost-'+$(this).val()).html('0');

                // remove array
                for (var i = 0; i < dataqd.length; i++) {
                    if (dataqd[i].idbarang === $(this).val()) {
                        dataqd.splice(i, 1);
                    }
                }

                qd_update_total();
            }
            // console.log(dataqd);
        });

    });

</script>
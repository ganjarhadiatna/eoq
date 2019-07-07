<!-- <form 
    name="form-generate-bg" 
    method="post" 
    action="{{ route('pesanan-multiitem-push') }}"
    autocomplete="off" 
    id="form-generate-bg"> -->

    <!-- @csrf -->
<div>
    <div>
        <h3 class="mb-0">Informasi Parameter</h3>
    </div>

    <div class="row mb-2">

        <div class="col-sm">
            <div class="form-group{{ $errors->has('bg_idsupplier') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="bg_idsupplier">{{ __('Pilih supplier') }}</label>
                <select 
                    name="bg_idsupplier"
                    id="bg_idsupplier" 
                    class="form-control form-control-alternative{{ $errors->has('bg_idsupplier') ? ' is-invalid' : '' }}" 
                    required>
                    <option value="0">Pilih Supplier</option>
                    @foreach ($supplier as $br)
                        <option value="{{ $br->id }}">{{ $br->nama }}</option>
                    @endforeach
                </select>
                @if ($errors->has('bg_idsupplier'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('bg_idsupplier') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-sm">

            <!-- <div class="form-group{{ $errors->has('bg_tipe_harga') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="bg_tipe_harga">{{ __('Pilih tipe harga') }}</label>
                <select 
                    name="tipe_harga"
                    id="bg_tipe_harga" 
                    class="form-control form-control-alternative{{ $errors->has('bg_tipe_harga') ? ' is-invalid' : '' }}" 
                    required>
                    <option value="khusus">Harga Khusus</option>
                    <option value="normal">Harga Normal</option>
                </select>
                @if ($errors->has('bg_tipe_harga'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('bg_tipe_harga') }}</strong>
                    </span>
                @endif
            </div> -->

            <!-- <div class="form-group{{ $errors->has('bg_biaya_pemesanan') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="bg_biaya_pemesanan">{{ __('Pilih tipe harga') }}</label>
                <div class="row">
                    <div class="custom-control custom-radio mb-3" style="margin-left: 15px;">
                        <input 
                            type="radio" 
                            name="bg-tipe-harga"
                            id="bg-tipe-harga-1" 
                            class="custom-control-input"
                            checked="true">
                        <label 
                            class="custom-control-label" 
                            for="bg-tipe-harga-1">
                            Harga Khusus
                        </label>
                    </div>
                    <div class="custom-control custom-radio mb-3" style="margin-left: 15px;">
                        <input 
                            type="radio" 
                            name="bg-tipe-harga"
                            id="bg-tipe-harga-2" 
                            class="custom-control-input"
                            checked="false">
                        <label 
                            class="custom-control-label" 
                            for="bg-tipe-harga-2">
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
                        onclick="bg_munculkan_barang()">
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
        <form id="bg-form-barang">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="100">NO</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Status Pemesanan</th>
                        <th scope="col">Status Pembelian</th>
                        <th scope="col">bg</th>
                        <th scope="col">Total Cost</th>
                        <th scope="col" width="50">#</th>
                    </tr>
                </thead>
                <tbody id="bg-daftar-barang"></tbody>
                <tbody id="bg-daftar-barang">
                    <tr>
                        <th scope="col" colspan="6">Total Keseluruhan</th>
                        <th scope="col" id="bg-jumlah-unit">0</th>
                        <th scope="col" id="bg-total-cost">0</th>
                        <td scope="col" width="50">
                            <button 
                                type="button" 
                                class="btn btn-success" 
                                onclick="generate_bg_multititem()">
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
    var databg = [];
    var clNow = "modal fade";
    var clOpen = "modal fade show";

    function op_bg_daftar_brang(stt) 
    {
        if (stt == 'open')
        {
            $('#bg-modal-barang').attr('class', clOpen).show();
        } 
        else 
        {
            $('#bg-modal-barang').attr('class', clNow).hide();
        }
    }

    function bg_event_barang(event) {
        console.log($(this).is(':checked'));
    }

    function bg_munculkan_barang() {
        // get barang
        var idsupplier = $('#bg_idsupplier').val();
        var route = '{{ url("/barang/bysupplier/") }}' + '/' + idsupplier;

        if (idsupplier == 0) {
            // alert('pilih supplier terlebih dahulu.');
            $('#bg-daftar-barang').html('');
        } else {
            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'json'
            })
            .done(function(data) {
                var dt = '';
                
                if (data.length > 0) {
                    // op_bg_daftar_brang('open');
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
                            <th id="bg-jumlah-unit-'+data[i].id+'">0</th>\
                            <th id="bg-total-cost-'+data[i].id+'">0</th>\
                            <td>\
                                <label class="custom-toggle">\
                                    <input type="checkbox" value="'+data[i].id+'" class="checkbox" />\
                                    <span class="custom-toggle-slider rounded-circle"></span>\
                                </label>\
                            </td>\
                        </tr>'
                    }
                }

                $('#bg-daftar-barang').html(dt);

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

    function bg_update_total() {
        var jumlah_unit = 0;
        var total_cost = 0;

        for (var i = 0; i < databg.length; i++) {
            var jumlah_unit = jumlah_unit + databg[i].jumlah_unit;
            var total_cost = total_cost + databg[i].total_cost;
        }

        $('#bg-jumlah-unit').html(jumlah_unit);
        $('#bg-total-cost').html(total_cost);
    }

    function generate_bg_multititem() {
        var idsupplier = $('#bg_idsupplier').val();
        var route = '{{ url("/pesanan/multiitem/bg/") }}';

        // console.log(route);
        if (databg.length > 0) {
            var a = confirm('apakah barang yang dipilih sudah tepat?');
            if (a) {
                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'idsupplier': idsupplier, 
                        'data': databg
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

    function generate_bg_singleitem(idbarang) 
    {
        
        var route = '{{ url("/pesanan/bg") }}';
        var idsupplier = $('#bg_idsupplier').val();
        // var bg_tipe_harga = $('#bg_tipe_harga').val();

        // console.log(idbarang);

        $.ajax({
            url: route,
            type: 'GET',
            dataType: 'JSON',
            data: {
                'idbarang': idbarang,
                'idsupplier': idsupplier,
                // 'tipe_harga': bg_tipe_harga
            }
        })
        .done(function(data) {
            databg.push({
                'idbarang': idbarang, 
                'biaya_penyimpanan': data.biaya_penyimpanan,
                'jumlah_permintaan': data.jumlah_permintaan,
                'harga_barang': data.harga_barang,
                'jumlah_unit': data.jumlah_unit,
                'total_cost': data.total_cost
            });
            $('#bg-jumlah-unit-'+idbarang).html(data.jumlah_unit);
            $('#bg-total-cost-'+idbarang).html(data.total_cost);

            bg_update_total();
            // console.log(data);
        })
        .fail(function(e) {
            // console.log("error " + e);
            $('#bg-jumlah-unit-'+idbarang).html('0');
            $('#bg-total-cost-'+idbarang).html('0');

            bg_update_total();
        })
        .always(function() {
            console.log("complete");
        });
            
    }

    $(document).ready(function () {
        
        $('#bg_idsupplier').change(function(event) {
            event.preventDefault();
            bg_munculkan_barang();

            databg = [];
            bg_update_total();
        });

        $('#bg-form-barang').on('change', ':checkbox', function () {
            if ($(this).is(':checked')) {
                // console.log($(this).val() + ' is now checked');
                generate_bg_singleitem($(this).val());

                // add array
                // databg.push($(this).val());
            } else {
                // console.log($(this).val() + ' is now unchecked');
                $('#bg-jumlah-unit-'+$(this).val()).html('0');
                $('#bg-total-cost-'+$(this).val()).html('0');

                // remove array
                for (var i = 0; i < databg.length; i++) {
                    if (databg[i].idbarang === $(this).val()) {
                        databg.splice(i, 1);
                    }
                }

                bg_update_total();
            }
            // console.log(databg);
        });

    });

</script>

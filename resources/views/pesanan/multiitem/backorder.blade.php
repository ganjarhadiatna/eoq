<!-- <form 
    name="form-generate-bo" 
    method="post" 
    action="{{ route('pesanan-multiitem-push') }}"
    autocomplete="off" 
    id="form-generate-bo"> -->

    <!-- @csrf -->
<div>
    <div>
        <h3 class="mb-0">Informasi Parameter</h3>
    </div>

    <div class="row mb-2">

        <div class="col-sm">
            <div class="form-group{{ $errors->has('bo_idsupplier') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="bo_idsupplier">{{ __('Pilih Supplier') }}</label>
                <select 
                    name="bo_idsupplier"
                    id="bo_idsupplier" 
                    class="form-control form-control-alternative{{ $errors->has('bo_idsupplier') ? ' is-invalid' : '' }}" 
                    required>
                    <option value="0">Pilih Supplier</option>
                    @foreach ($supplier as $br)
                        <option value="{{ $br->id }}">{{ $br->nama }}</option>
                    @endforeach
                </select>
                @if ($errors->has('bo_idsupplier'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('bo_idsupplier') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-sm">
            <div class="col-sm">
                <div class="form-group{{ $errors->has('bo_biaya_backorder') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="bo_biaya_backorder">{{ __('Biaya Backorder') }}</label>
                    <input 
                        type="text" 
                        name="bo_biaya_backorder" 
                        id="bo_biaya_backorder" 
                        class="form-control form-control-alternative{{ $errors->has('bo_biaya_backorder') ? ' is-invalid' : '' }}" 
                        placeholder="0" 
                        required>
                    @if ($errors->has('bo_biaya_backorder'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('bo_biaya_backorder') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div>
        <h3 class="mb-0">Daftar Barang</h3>
    </div>

    <div class="table-responsive">
        <form id="bo-form-barang">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="100">NO</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Status Perhitungan</th>
                        <th scope="col">Status Pemesanan</th>
                        <th scope="col">Jumlah Permintaan</th>
                        <th scope="col">EOQ</th>
                        <th scope="col">Total Cost</th>
                        <th scope="col" width="50">#</th>
                    </tr>
                </thead>
                <tbody id="bo-daftar-barang"></tbody>
                <tbody id="bo-daftar-barang">
                    <tr>
                        <th scope="col" colspan="7">Total Keseluruhan</th>
                        <th scope="col" id="bo-jumlah-unit">0</th>
                        <th scope="col" id="bo-total-cost">0</th>
                        <td scope="col" width="50">
                            <button 
                                type="button" 
                                class="btn btn-success" 
                                onclick="generate_bo_multititem()">
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
    var databo = [];
    var clNow = "modal fade";
    var clOpen = "modal fade show";

    function op_bo_daftar_brang(stt) 
    {
        if (stt == 'open')
        {
            $('#bo-modal-barang').attr('class', clOpen).show();
        } 
        else 
        {
            $('#bo-modal-barang').attr('class', clNow).hide();
        }
    }

    function bo_event_barang(event) {
        console.log($(this).is(':checked'));
    }

    function bo_munculkan_barang() {
        // get barang
        var idsupplier = $('#bo_idsupplier').val();
        var route = '{{ url("/barang/bysupplier/") }}' + '/' + idsupplier;

        if (idsupplier == 0) {
            // alert('pilih supplier terlebih dahulu.');
            $('#bo-daftar-barang').html('');
        } else {
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
                
                if (data.length > 0) {
                    // op_bo_daftar_brang('open');
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

                        dt += '\
                        <tr>\
                            <td>'+(i + 1)+'</td>\
                            <td>'+data[i].nama_barang+'</td>\
                            <td>'+data[i].harga_barang+'</td>\
                            <td>'+data[i].stok+'</td>\
                            '+status_pemesanan+'\
                            '+status_pembelian+'\
                            <th id="bo-jumlah-permintaan-'+data[i].id+'">0</th>\
                            <th id="bo-jumlah-unit-'+data[i].id+'">0</th>\
                            <th id="bo-total-cost-'+data[i].id+'">0</th>\
                            <td>\
                                <label class="custom-toggle">\
                                    <input type="checkbox" value="'+data[i].id+'" class="checkbox" />\
                                    <span class="custom-toggle-slider rounded-circle"></span>\
                                </label>\
                            </td>\
                        </tr>'
                    }
                }

                $('#bo-daftar-barang').html(dt);
                clLoading();
                // console.log(data);
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

    function bo_update_total() {
        var jumlah_unit = 0;
        var total_cost = 0;

        for (var i = 0; i < databo.length; i++) {
            var jumlah_unit = jumlah_unit + databo[i].jumlah_unit;
            var total_cost = total_cost + databo[i].total_cost;
        }

        $('#bo-jumlah-unit').html(jumlah_unit);
        $('#bo-total-cost').html(total_cost);
    }

    function generate_bo_multititem() {
        var idsupplier = $('#bo_idsupplier').val();
        var biaya_backorder = $('#bo_biaya_backorder').val();
        var route = '{{ url("/pesanan/multiitem/bo/") }}';

        // console.log(route);
        if (databo.length > 0) {
            var a = confirm('apakah barang yang dipilih sudah tepat?');
            if (a) {
                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'idsupplier': idsupplier, 
                        'biaya_backorder': biaya_backorder,
                        'data': databo
                    },
                    beforeSend: function () {
                        opLoading();
                    }
                })
                .done(function(data) {
                    if (data.status === 'success') {
                        window.location = '{{ route("pesanan-item") }}';
                    }
                    clLoading();
                    // console.log(data);
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

    function generate_bo_singleitem(idbarang) 
    {
        
        var route = '{{ url("/pesanan/backorder") }}';
        var idsupplier = $('#bo_idsupplier').val();
        var bo_biaya_backorder = $('#bo_biaya_backorder').val();

        if (bo_biaya_backorder > 0) {
            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'JSON',
                data: {
                    'idbarang': idbarang,
                    'idsupplier': idsupplier,
                    'biaya_backorder': bo_biaya_backorder
                },
                beforeSend: function () {
                    opLoading();
                }
            })
            .done(function(data) {
                databo.push({
                    'idbarang': idbarang, 
                    'biaya_penyimpanan': data.biaya_penyimpanan,
                    'jumlah_permintaan': data.jumlah_permintaan,
                    'harga_barang': data.harga_barang,
                    'jumlah_unit': data.jumlah_unit,
                    'total_cost': data.total_cost
                });

                $('#bo-jumlah-permintaan-'+idbarang).html(data.jumlah_permintaan);
                $('#bo-jumlah-unit-'+idbarang).html(data.jumlah_unit);
                $('#bo-total-cost-'+idbarang).html(data.total_cost);

                bo_update_total();
                clLoading();
                // console.log(data);
            })
            .fail(function(e) {
                alert(e.responseJSON.message);
                // console.log("error " + e.responseJSON.message);
                $('#bo-jumlah-permintaan-'+idbarang).html('0');
                $('#bo-jumlah-unit-'+idbarang).html('0');
                $('#bo-total-cost-'+idbarang).html('0');

                bo_update_total();
                clLoading();
            })
            .always(function() {
                console.log("complete");
            });
        } else {
            alert('biaya backorder tidak boleh kosong.');
        }
            
    }

    $(document).ready(function () {
        
        $('#bo_idsupplier').change(function(event) {
            // event.preventDefault();
            bo_munculkan_barang();

            databo = [];
            bo_update_total();
        });

        $('#bo-form-barang').on('change', ':checkbox', function () {
            if ($(this).is(':checked')) {
                
                generate_bo_singleitem($(this).val());

            } else {
                // console.log($(this).val() + ' is now unchecked');
                $('#bo-jumlah-permintaan-'+$(this).val()).html('0');
                $('#bo-jumlah-unit-'+$(this).val()).html('0');
                $('#bo-total-cost-'+$(this).val()).html('0');

                // remove array
                for (var i = 0; i < databo.length; i++) {
                    if (databo[i].idbarang === $(this).val()) {
                        databo.splice(i, 1);
                    }
                }

                bo_update_total();
            }
            // console.log(databo);
        });

    });

</script>

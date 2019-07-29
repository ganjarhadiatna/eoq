<!-- <form 
    name="form-generate-espc" 
    method="post" 
    action="{{ route('pesanan-multiitem-push') }}"
    autocomplete="off" 
    id="form-generate-espc"> -->

    <!-- @csrf -->
<div>
    <div>
        <h3 class="mb-0">Informasi Parameter</h3>
    </div>

    <div class="row mb-2">

        <div class="col-sm">
            <div class="form-group{{ $errors->has('espc_idsupplier') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="espc_idsupplier">{{ __('Pilih Supplier') }}</label>
                <select 
                    name="espc_idsupplier"
                    id="espc_idsupplier" 
                    class="form-control form-control-alternative{{ $errors->has('espc_idsupplier') ? ' is-invalid' : '' }}" 
                    required>
                    <option value="0">Pilih Supplier</option>
                    @foreach ($supplier as $br)
                        <option value="{{ $br->id }}">{{ $br->nama }}</option>
                    @endforeach
                </select>
                @if ($errors->has('espc_idsupplier'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('espc_idsupplier') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-sm"></div>
    </div>

    <div>
        <h3 class="mb-0">Daftar Barang</h3>
    </div>

    <div class="table-responsive">
        <form id="espc-form-barang">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="100">NO</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Status Perhitungan</th>
                        <th scope="col">Status Pemesanan</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Jumlah Permintaan</th>
                        <th scope="col">EOQ</th>
                        <th scope="col">Total Cost</th>
                        <th scope="col">Besar Penghematan</th>
                        <th scope="col" width="50">#</th>
                    </tr>
                </thead>
                <tbody id="espc-daftar-barang"></tbody>
                <tbody id="espc-daftar-barang">
                    <tr>
                        <th scope="col" colspan="7">Total Keseluruhan</th>
                        <th scope="col" id="espc-jumlah-unit">0</th>
                        <th scope="col" id="espc-total-cost">0</th>
                        <th scope="col" id="espc-besar-penghematan">0</th>
                        <td scope="col" width="50">
                            <button 
                                type="button" 
                                class="btn btn-success" 
                                onclick="generate_espc_multititem()">
                                Simpan Pesanan
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>

    <!-- Modal -->
    <div 
        class="modal fade" 
        id="specialPriceModal" 
        tabindex="-1" 
        role="dialog" 
        aria-labelledby="specialPriceModalLabel" 
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">
                        Informasi Parameter
                    </h5>
                    <button 
                        onclick="openFormSpecialPrice()" 
                        type="button" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form 
                    name="form-generate-special-price" 
                    method="get" 
                    action="javascript:void(0)"
                    autocomplete="off" 
                    id="form-generate-special-price">
                    
                    @csrf

                    <div class="modal-body">

                        <input type="hidden" name="espc_idbarang" id="espc_idbarang">
                        <div class="form-group{{ $errors->has('espc_tipe_harga') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="espc_tipe_harga">{{ __('Tipe Pemesanan') }}</label>
                            <select 
                                name="espc_tipe_harga"
                                id="espc_tipe_harga" 
                                class="form-control form-control-alternative{{ $errors->has('espc_tipe_harga') ? ' is-invalid' : '' }}" 
                                required>
                                <option value="1">Pemesanan Khusus</option>
                                <option value="2">Pemesanan Normal</option>
                            </select>
                            @if ($errors->has('espc_tipe_harga'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('espc_tipe_harga') }}</strong>
                                </span>
                            @endif
                        </div>
                        <!-- <div class="form-group{{ $errors->has('espc_harga_barang') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="espc_harga_barang">{{ __('Harga barang *') }}</label>
                            <input 
                                type="number" 
                                name="espc_harga_barang" 
                                id="espc_harga_barang" 
                                class="form-control form-control-alternative{{ $errors->has('espc_harga_barang') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('0') }}"  
                                min="0"
                                required >
                                @if ($errors->has('espc_harga_barang'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('espc_harga_barang') }}</strong>
                                    </span>
                                @endif
                            
                        </div> -->
                        <div class="form-group{{ $errors->has('espc_harga_spesial') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="espc_harga_spesial">{{ __('Harga spesial (EX: 2000 > 1500)') }}</label>
                            <input 
                                type="number" 
                                name="espc_harga_spesial" 
                                id="espc_harga_spesial" 
                                class="form-control form-control-alternative{{ $errors->has('espc_harga_spesial') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('0') }}"  
                                min="0"
                                required >
                                @if ($errors->has('espc_harga_spesial'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('espc_harga_spesial') }}</strong>
                                    </span>
                                @endif
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button 
                            type="button" 
                            class="btn btn-secondary" 
                            onclick="openFormSpecialPrice()">Tutup</button>
                        <button 
                            type="submit" 
                            id="espc-generate-metode" 
                            class="btn btn-primary">Generate metode</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    var dataEspc = [];
    var clNow = "modal fade";
    var clOpen = "modal fade show";

    function op_espc_daftar_brang(stt) 
    {
        if (stt == 'open')
        {
            $('#espc-modal-barang').attr('class', clOpen).show();
        } 
        else 
        {
            $('#espc-modal-barang').attr('class', clNow).hide();
        }
    }

    function espc_event_barang(event) {
        console.log($(this).is(':checked'));
    }

    function espc_munculkan_barang() {
        // get barang
        var idsupplier = $('#espc_idsupplier').val();
        var route = '{{ url("/barang/bysupplier/") }}' + '/' + idsupplier;

        if (idsupplier == 0) {
            // alert('pilih supplier terlebih dahulu.');
            $('#espc-daftar-barang').html('');
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
                    // op_espc_daftar_brang('open');
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
                            <td>'+data[i].stok+'</td>\
                            '+status_pemesanan+'\
                            '+status_pembelian+'\
                            <td>'+data[i].harga_barang+'</td>\
                            <th id="espc-jumlah-permintaan-'+data[i].id+'">0</th>\
                            <th id="espc-jumlah-unit-'+data[i].id+'">0</th>\
                            <th id="espc-total-cost-'+data[i].id+'">0</th>\
                            <th id="espc-besar-penghematan-'+data[i].id+'">0</th>\
                            <td>\
                                <label class="custom-toggle">\
                                    <input type="checkbox" value="'+data[i].id+'" class="checkbox" />\
                                    <span class="custom-toggle-slider rounded-circle"></span>\
                                </label>\
                            </td>\
                        </tr>'
                    }
                }

                $('#espc-daftar-barang').html(dt);

                // console.log(data);
                clLoading();
            })
            .fail(function(e) {
                console.log("error => " + e);
                clLoading();
            })
            .always(function() {
                console.log("complete");
            });
            
        }
    }

    function espc_update_total() {
        var jumlah_unit = 0;
        var total_cost = 0;

        for (var i = 0; i < dataEspc.length; i++) {
            var jumlah_unit = jumlah_unit + dataEspc[i].jumlah_unit;
            var total_cost = total_cost + dataEspc[i].total_cost;
        }

        $('#espc-jumlah-unit').html(jumlah_unit);
        $('#espc-total-cost').html(total_cost);
    }

    function generate_espc_multititem() {
        var idsupplier = $('#espc_idsupplier').val();
        var route = '{{ url("/pesanan/multiitem/sp") }}';

        // console.log(route);
        if (dataEspc.length > 0) {
            var a = confirm('apakah barang yang dipilih sudah tepat?');
            if (a) {
                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'idsupplier': idsupplier, 
                        'data': dataEspc
                    },
                    beforeSend: function () {
                        opLoading();
                    }
                })
                .done(function(data) {
                    if (data.status === 'success') {
                        window.location = '{{ route("pesanan-item") }}';
                    } else {
                        alert(data.message);
                    }
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
        } else {
            alert('pilih satu atau lebih barang barang.');
        }
    }

    // function generate_espc_singleitem() 
    // {
        
    //     var route = '{{ url("/pesanan/eoq") }}';
    //     var idbarang = $('#espc_idbarang').val();
    //     var idsupplier = $('#espc_idsupplier').val();
    //     var espc_tipe_harga = $('#espc_tipe_harga').val();
    //     var espc_harga_spesial = $('#espc_harga_spesial').val();

    //     // console.log(idbarang);

    //     $.ajax({
    //         url: route,
    //         type: 'GET',
    //         dataType: 'JSON',
    //         data: {
    //             'idbarang': idbarang,
    //             'idsupplier': idsupplier,
    //             'tipe_harga': espc_tipe_harga,
    //             'special_price': espc_harga_spesial
    //         },
    //         beforeSend: function () {
    //             opLoading();
    //         }
    //     })
    //     .done(function(data) {

    //         dataEspc.push({
    //             'idbarang': idbarang, 
    //             'biaya_penyimpanan': data.biaya_penyimpanan,
    //             'jumlah_permintaan': data.jumlah_permintaan,
    //             'harga_barang': data.harga_barang,
    //             'jumlah_unit': data.jumlah_unit,
    //             'total_cost': data.total_cost
    //         });

    //         $('#specialPriceModal').attr('class', clNow).hide();
    //         $('#espc-jumlah-permintaan-'+idbarang).html(data.jumlah_permintaan);
    //         $('#espc-jumlah-unit-'+idbarang).html(data.jumlah_unit);
    //         $('#espc-total-cost-'+idbarang).html(data.total_cost);

    //         espc_update_total();
    //         clLoading();
    //         // console.log(data);
    //     })
    //     .fail(function(e) {
    //         alert(e.responseJSON.message);
    //         // console.log("error " + e);
    //         $('#espc-jumlah-permintaan-'+idbarang).html('0');
    //         $('#espc-jumlah-unit-'+idbarang).html('0');
    //         $('#espc-total-cost-'+idbarang).html('0');

    //         espc_update_total();
    //         clLoading();
    //     })
    //     .always(function() {
    //         console.log("complete");
    //     });

    // }

    function openFormSpecialPrice(val = '') {
        var tr = $('#specialPriceModal').attr('class');

        if (tr == clNow) {
            $('#specialPriceModal').attr('class', clOpen).show();
        } else {
            $('#specialPriceModal').attr('class', clNow).hide();
        }
    }

    $(document).ready(function () {

        // $('#specialPriceModal').show();

        // $('#espc-generate-metode').on('click', function(event) {
        //     event.preventDefault();
        //     generate_espc_singleitem();
        // });

        $('#form-generate-special-price').on('submit', function(event) {
            event.preventDefault();

            var route = '{{ url("/pesanan/specialprice") }}';

            // var token = event.target[0].value;
            var idbarang = $('#espc_idbarang').val();
            var idsupplier = $('#espc_idsupplier').val();
            var espc_tipe_harga = $('#espc_tipe_harga').val();
            var espc_harga_spesial = $('#espc_harga_spesial').val();

            // console.log(idbarang);

            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'JSON',
                data: {
                    'idbarang': idbarang,
                    'idsupplier': idsupplier,
                    'tipe_harga': espc_tipe_harga,
                    'special_price': espc_harga_spesial
                },
                beforeSend: function () {
                    opLoading();
                }
            })
            .done(function(data) {

                dataEspc.push({
                    'idbarang': idbarang, 
                    'biaya_penyimpanan': data.biaya_penyimpanan,
                    'jumlah_permintaan': data.jumlah_permintaan,
                    'harga_barang': data.harga_barang,
                    'jumlah_unit': data.jumlah_unit,
                    'total_cost': data.total_cost,
                    'special_price': data.special_price,
                    'tipe_harga': data.tipe_harga
                });

                clLoading();

                $('#specialPriceModal').attr('class', clNow).hide();

                $('#espc-jumlah-permintaan-'+idbarang).html(data.jumlah_permintaan);
                $('#espc-jumlah-unit-'+idbarang).html(data.jumlah_unit);
                $('#espc-total-cost-'+idbarang).html(data.total_cost);
                $('#espc-besar-penghematan-'+idbarang).html(data.besar_penghematan);

                espc_update_total();
                console.log(dataEspc);
            })
            .fail(function(e) {
                alert(e.responseJSON.message);
                console.log("error " + e);

                $('#espc-jumlah-permintaan-'+idbarang).html('0');
                $('#espc-jumlah-unit-'+idbarang).html('0');
                $('#espc-total-cost-'+idbarang).html('0');
                $('#espc-besar-penghematan-'+idbarang).html('0');
                $('#espc_idbarang').val('0');
                $('#espc_tipe_harga').val('0');
                $('#espc_harga_spesial').val('0');

                $('#specialPriceModal').attr('class', clNow).hide();

                espc_update_total();
                clLoading();
            })
            .always(function() {
                console.log("complete");
            });
            
        });
        
        $('#espc_idsupplier').change(function(event) {
            event.preventDefault();
            espc_munculkan_barang();

            dataEspc = [];
            espc_update_total();
        });

        $('#espc-form-barang').on('change', ':checkbox', function () {
            if ($(this).is(':checked')) {

                $('#espc_idbarang').val($(this).val());
                $('#specialPriceModal').attr('class', clOpen).show();

                // add array
                // dataEspc.push($(this).val());
            } else {
                // console.log($(this).val() + ' is now unchecked');
                $('#espc-jumlah-permintaan-'+$(this).val()).html('0');
                $('#espc-jumlah-unit-'+$(this).val()).html('0');
                $('#espc-total-cost-'+$(this).val()).html('0');
                $('#espc-besar-penghematan-'+$(this).val()).html('0');

                // remove array
                for (var i = 0; i < dataEspc.length; i++) {
                    if (dataEspc[i].idbarang === $(this).val()) {
                        dataEspc.splice(i, 1);
                    }
                }

                espc_update_total();
            }
            // console.log(dataEspc);
        });

    });

</script>

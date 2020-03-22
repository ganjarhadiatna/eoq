<!-- <form 
    name="form-generate-eipc" 
    method="post" 
    action="{{ route('pesanan-multiitem-push') }}"
    autocomplete="off" 
    id="form-generate-eipc"> -->

    <!-- @csrf -->
<div>
    <div>
        <h3 class="mb-0">Informasi Parameter</h3>
    </div>

    <div class="row mb-2">

        <div class="col-sm">
            <div class="form-group{{ $errors->has('eipc_idsupplier') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="eipc_idsupplier">{{ __('Pilih Supplier') }}</label>
                <select 
                    name="eipc_idsupplier"
                    id="eipc_idsupplier" 
                    class="form-control form-control-alternative{{ $errors->has('eipc_idsupplier') ? ' is-invalid' : '' }}" 
                    required>
                    <option value="0">Pilih Supplier</option>
                    @foreach ($supplier as $br)
                        <option value="{{ $br->id }}">{{ $br->nama }}</option>
                    @endforeach
                </select>
                @if ($errors->has('eipc_idsupplier'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('eipc_idsupplier') }}</strong>
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
        <form id="eipc-form-barang">
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
                <tbody id="eipc-daftar-barang"></tbody>
                <tbody id="eipc-daftar-barang">
                    <tr>
                        <th scope="col" colspan="7">Total Keseluruhan</th>
                        <th scope="col" id="eipc-jumlah-unit">0</th>
                        <th scope="col" id="eipc-total-cost">0</th>
                        <th scope="col" id="eipc-besar-penghematan">0</th>
                        <td scope="col" width="50">
                            <button 
                                type="button" 
                                class="btn btn-success" 
                                onclick="generate_eipc_multititem()">
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
        id="increasePriceModal" 
        tabindex="-1" 
        role="dialog" 
        aria-labelledby="increasePriceModalLabel" 
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">
                        Informasi Parameter
                    </h5>
                    <button 
                        onclick="openFormIncreasePrice()" 
                        type="button" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form 
                    name="form-generate-increase-price" 
                    method="get" 
                    action="javascript:void(0)"
                    autocomplete="off" 
                    id="form-generate-increase-price">
                    
                    @csrf

                    <div class="modal-body">

                        <input type="hidden" name="eipc_idbarang" id="eipc_idbarang">
                        <div class="form-group{{ $errors->has('eipc_tipe_harga') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="eipc_tipe_harga">{{ __('Tipe Pemesanan') }}</label>
                            <select 
                                name="eipc_tipe_harga"
                                id="eipc_tipe_harga" 
                                class="form-control form-control-alternative{{ $errors->has('eipc_tipe_harga') ? ' is-invalid' : '' }}" 
                                required>
                                <option value="1">Pemesanan Khusus</option>
                                <option value="2">Pemesanan Normal</option>
                            </select>
                            @if ($errors->has('eipc_tipe_harga'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('eipc_tipe_harga') }}</strong>
                                </span>
                            @endif
                        </div>
                        <!-- <div class="form-group{{ $errors->has('eipc_harga_barang') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="eipc_harga_barang">{{ __('Harga barang *') }}</label>
                            <input 
                                type="number" 
                                name="eipc_harga_barang" 
                                id="eipc_harga_barang" 
                                class="form-control form-control-alternative{{ $errors->has('eipc_harga_barang') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('0') }}"  
                                min="0"
                                required >
                                @if ($errors->has('eipc_harga_barang'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('eipc_harga_barang') }}</strong>
                                    </span>
                                @endif
                            
                        </div> -->
                        <div class="form-group{{ $errors->has('eipc_kenaikan_harga') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="eipc_kenaikan_harga">
                                {{ __('Kenaikan harga (Ex: 2000 > 3000)') }}
                            </label>
                            <input 
                                type="number" 
                                name="eipc_kenaikan_harga" 
                                id="eipc_kenaikan_harga" 
                                class="form-control form-control-alternative{{ $errors->has('eipc_kenaikan_harga') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('0') }}"  
                                min="0"
                                required >
                                @if ($errors->has('eipc_kenaikan_harga'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('eipc_kenaikan_harga') }}</strong>
                                    </span>
                                @endif
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button 
                            type="button" 
                            class="btn btn-secondary" 
                            onclick="openFormIncreasePrice()">Tutup</button>
                        <button 
                            type="submit" 
                            id="eipc-generate-metode" 
                            class="btn btn-primary">Generate metode</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    var dataEipc = [];
    var clNow = "modal fade";
    var clOpen = "modal fade show";

    function op_eipc_daftar_brang(stt) 
    {
        if (stt == 'open')
        {
            $('#eipc-modal-barang').attr('class', clOpen).show();
        } 
        else 
        {
            $('#eipc-modal-barang').attr('class', clNow).hide();
        }
    }

    function eipc_event_barang(event) {
        console.log($(this).is(':checked'));
    }

    function eipc_munculkan_barang() {
        // get barang
        var idsupplier = $('#eipc_idsupplier').val();
        var route = '{{ url("/barang/bysupplier/") }}' + '/' + idsupplier;

        if (idsupplier == 0) {
            // alert('pilih supplier terlebih dahulu.');
            $('#eipc-daftar-barang').html('');
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
                    // op_eipc_daftar_brang('open');
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
                            <th id="eipc-jumlah-permintaan-'+data[i].id+'">0</th>\
                            <th id="eipc-jumlah-unit-'+data[i].id+'">0</th>\
                            <th id="eipc-total-cost-'+data[i].id+'">0</th>\
                            <th id="eipc-besar-penghematan-'+data[i].id+'">0</th>\
                            <td>\
                                <label class="custom-toggle">\
                                    <input type="checkbox" value="'+data[i].id+'" class="checkbox" />\
                                    <span class="custom-toggle-slider rounded-circle"></span>\
                                </label>\
                            </td>\
                        </tr>'
                    }
                }

                $('#eipc-daftar-barang').html(dt);

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

    function eipc_update_total() {
        var jumlah_unit = 0;
        var total_cost = 0;

        for (var i = 0; i < dataEipc.length; i++) {
            var jumlah_unit = jumlah_unit + dataEipc[i].jumlah_unit;
            var total_cost = total_cost + dataEipc[i].total_cost;
        }

        $('#eipc-jumlah-unit').html(jumlah_unit);
        $('#eipc-total-cost').html(total_cost);
    }

    function generate_eipc_multititem() {
        var idsupplier = $('#eipc_idsupplier').val();
        var route = '{{ url("/pesanan/multiitem/ip") }}';

        // console.log(route);
        if (dataEipc.length > 0) {
            var a = confirm('apakah barang yang dipilih sudah tepat?');
            if (a) {
                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'idsupplier': idsupplier, 
                        'data': dataEipc
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

    // function generate_eipc_singleitem() 
    // {
        
    //     var route = '{{ url("/pesanan/eoq") }}';
    //     var idbarang = $('#eipc_idbarang').val();
    //     var idsupplier = $('#eipc_idsupplier').val();
    //     var eipc_tipe_harga = $('#eipc_tipe_harga').val();
    //     var eipc_kenaikan_harga = $('#eipc_kenaikan_harga').val();

    //     // console.log(idbarang);

    //     $.ajax({
    //         url: route,
    //         type: 'GET',
    //         dataType: 'JSON',
    //         data: {
    //             'idbarang': idbarang,
    //             'idsupplier': idsupplier,
    //             'tipe_harga': eipc_tipe_harga,
    //             'increase_price': eipc_kenaikan_harga
    //         },
    //         beforeSend: function () {
    //             opLoading();
    //         }
    //     })
    //     .done(function(data) {

    //         dataEipc.push({
    //             'idbarang': idbarang, 
    //             'biaya_penyimpanan': data.biaya_penyimpanan,
    //             'jumlah_permintaan': data.jumlah_permintaan,
    //             'harga_barang': data.harga_barang,
    //             'jumlah_unit': data.jumlah_unit,
    //             'total_cost': data.total_cost
    //         });

    //         $('#increasePriceModal').attr('class', clNow).hide();
    //         $('#eipc-jumlah-permintaan-'+idbarang).html(data.jumlah_permintaan);
    //         $('#eipc-jumlah-unit-'+idbarang).html(data.jumlah_unit);
    //         $('#eipc-total-cost-'+idbarang).html(data.total_cost);

    //         eipc_update_total();
    //         clLoading();
    //         // console.log(data);
    //     })
    //     .fail(function(e) {
    //         alert(e.responseJSON.message);
    //         // console.log("error " + e);
    //         $('#eipc-jumlah-permintaan-'+idbarang).html('0');
    //         $('#eipc-jumlah-unit-'+idbarang).html('0');
    //         $('#eipc-total-cost-'+idbarang).html('0');

    //         eipc_update_total();
    //         clLoading();
    //     })
    //     .always(function() {
    //         console.log("complete");
    //     });

    // }

    function openFormIncreasePrice(val = '') {
        var tr = $('#increasePriceModal').attr('class');

        if (tr == clNow) {
            $('#increasePriceModal').attr('class', clOpen).show();
        } else {
            $('#increasePriceModal').attr('class', clNow).hide();
        }
    }

    $(document).ready(function () {

        // $('#increasePriceModal').show();

        // $('#eipc-generate-metode').on('click', function(event) {
        //     event.preventDefault();
        //     generate_eipc_singleitem();
        // });

        $('#form-generate-increase-price').on('submit', function(event) {
            event.preventDefault();

            var route = '{{ url("/pesanan/increaseprice") }}';

            // var token = event.target[0].value;
            var idbarang = $('#eipc_idbarang').val();
            var idsupplier = $('#eipc_idsupplier').val();
            var eipc_tipe_harga = $('#eipc_tipe_harga').val();
            var eipc_kenaikan_harga = $('#eipc_kenaikan_harga').val();

            // console.log(idbarang);

            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'JSON',
                data: {
                    'idbarang': idbarang,
                    'idsupplier': idsupplier,
                    'tipe_harga': eipc_tipe_harga,
                    'increase_price': eipc_kenaikan_harga
                },
                beforeSend: function () {
                    opLoading();
                }
            })
            .done(function(data) {

                dataEipc.push({
                    'idbarang': idbarang, 
                    'biaya_penyimpanan': data.biaya_penyimpanan,
                    'jumlah_permintaan': data.jumlah_permintaan,
                    'harga_barang': data.harga_barang,
                    'jumlah_unit': data.jumlah_unit,
                    'total_cost': data.total_cost,
                    'increase_price': data.increase_price,
                    'tipe_harga': data.tipe_harga
                });

                clLoading();

                $('#increasePriceModal').attr('class', clNow).hide();

                $('#eipc-jumlah-permintaan-'+idbarang).html(data.jumlah_permintaan);
                $('#eipc-jumlah-unit-'+idbarang).html(data.jumlah_unit);
                $('#eipc-total-cost-'+idbarang).html(data.total_cost);
                $('#eipc-besar-penghematan-'+idbarang).html(data.besar_penghematan);

                eipc_update_total();
                // console.log(dataEipc);
            })
            .fail(function(e) {
                alert(e.responseJSON.message);
                console.log("error " + e);

                $('#eipc-jumlah-permintaan-'+idbarang).html('0');
                $('#eipc-jumlah-unit-'+idbarang).html('0');
                $('#eipc-total-cost-'+idbarang).html('0');
                $('#eipc-besar-penghematan-'+idbarang).html('0');
                $('#eipc_idbarang').val('');
                $('#eipc_tipe_harga').val('');
                $('#eipc_kenaikan_harga').val('');

                $('#increasePriceModal').attr('class', clNow).hide();

                eipc_update_total();
                clLoading();
            })
            .always(function() {
                console.log("complete");
            });
            
        });
        
        $('#eipc_idsupplier').change(function(event) {
            event.preventDefault();
            eipc_munculkan_barang();

            dataEipc = [];
            eipc_update_total();
        });

        $('#eipc-form-barang').on('change', ':checkbox', function () {
            if ($(this).is(':checked')) {

                $('#eipc_idbarang').val($(this).val());
                $('#increasePriceModal').attr('class', clOpen).show();

                // add array
                // dataEipc.push($(this).val());
            } else {
                // console.log($(this).val() + ' is now unchecked');
                $('#eipc-jumlah-permintaan-'+$(this).val()).html('0');
                $('#eipc-jumlah-unit-'+$(this).val()).html('0');
                $('#eipc-total-cost-'+$(this).val()).html('0');
                $('#eipc-besar-penghematan-'+$(this).val()).html('0');

                // remove array
                for (var i = 0; i < dataEipc.length; i++) {
                    if (dataEipc[i].idbarang === $(this).val()) {
                        dataEipc.splice(i, 1);
                    }
                }

                eipc_update_total();
            }
            // console.log(dataEipc);
        });

    });

</script>

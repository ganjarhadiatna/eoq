<!-- <form 
    name="form-generate-eoq" 
    method="post" 
    action="{{ route('pesanan-multiitem-push') }}"
    autocomplete="off" 
    id="form-generate-eoq"> -->

    <!-- @csrf -->
<div>
    <div>
        <h3 class="mb-0">Informasi Parameter</h3>
    </div>

    <div class="row mb-2">

        <div class="col-sm">
            <div class="form-group{{ $errors->has('eoq_idsupplier') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="eoq_idsupplier">{{ __('Pilih Supplier') }}</label>
                <select 
                    name="eoq_idsupplier"
                    id="eoq_idsupplier" 
                    class="form-control form-control-alternative{{ $errors->has('eoq_idsupplier') ? ' is-invalid' : '' }}" 
                    required>
                    <option value="0">Pilih Supplier</option>
                    @foreach ($supplier as $br)
                        <option value="{{ $br->id }}">{{ $br->nama }}</option>
                    @endforeach
                </select>
                @if ($errors->has('eoq_idsupplier'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('eoq_idsupplier') }}</strong>
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
        <form id="eoq-form-barang">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="100">NO</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Status Perhitungan</th>
                        <th scope="col">Status Pemesanan</th>
                        <th scope="col">EOQ</th>
                        <th scope="col">Total Cost</th>
                        <th scope="col" width="50">#</th>
                    </tr>
                </thead>
                <tbody id="eoq-daftar-barang"></tbody>
                <tbody id="eoq-daftar-barang">
                    <tr>
                        <th scope="col" colspan="6">Total Keseluruhan</th>
                        <th scope="col" id="eoq-jumlah-unit">0</th>
                        <th scope="col" id="eoq-total-cost">0</th>
                        <td scope="col" width="50">
                            <button 
                                type="button" 
                                class="btn btn-success" 
                                onclick="generate_eoq_multititem()">
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
    var dataEoq = [];
    var clNow = "modal fade";
    var clOpen = "modal fade show";

    function op_eoq_daftar_brang(stt) 
    {
        if (stt == 'open')
        {
            $('#eoq-modal-barang').attr('class', clOpen).show();
        } 
        else 
        {
            $('#eoq-modal-barang').attr('class', clNow).hide();
        }
    }

    function eoq_event_barang(event) {
        console.log($(this).is(':checked'));
    }

    function eoq_munculkan_barang() {
        // get barang
        var idsupplier = $('#eoq_idsupplier').val();
        var route = '{{ url("/barang/bysupplier/") }}' + '/' + idsupplier;

        if (idsupplier == 0) {
            // alert('pilih supplier terlebih dahulu.');
            $('#eoq-daftar-barang').html('');
        } else {
            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'json'
            })
            .done(function(data) {
                var dt = '';
                
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

                        dt += '\
                        <tr>\
                            <td>'+(i + 1)+'</td>\
                            <td>'+data[i].nama_barang+'</td>\
                            <td>'+data[i].harga_barang+'</td>\
                            <td>'+data[i].stok+'</td>\
                            '+status_pemesanan+'\
                            '+status_pembelian+'\
                            <th id="eoq-jumlah-unit-'+data[i].id+'">0</th>\
                            <th id="eoq-total-cost-'+data[i].id+'">0</th>\
                            <td>\
                                <label class="custom-toggle">\
                                    <input type="checkbox" value="'+data[i].id+'" class="checkbox" />\
                                    <span class="custom-toggle-slider rounded-circle"></span>\
                                </label>\
                            </td>\
                        </tr>'
                    }
                }

                $('#eoq-daftar-barang').html(dt);

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

    function eoq_update_total() {
        var jumlah_unit = 0;
        var total_cost = 0;

        for (var i = 0; i < dataEoq.length; i++) {
            var jumlah_unit = jumlah_unit + dataEoq[i].jumlah_unit;
            var total_cost = total_cost + dataEoq[i].total_cost;
        }

        $('#eoq-jumlah-unit').html(jumlah_unit);
        $('#eoq-total-cost').html(total_cost);
    }

    function generate_eoq_multititem() {
        var idsupplier = $('#eoq_idsupplier').val();
        var route = '{{ url("/pesanan/multiitem/eoq/") }}';

        // console.log(route);
        if (dataEoq.length > 0) {
            var a = confirm('apakah barang yang dipilih sudah tepat?');
            if (a) {
                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'idsupplier': idsupplier, 
                        'data': dataEoq
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

    function generate_eoq_singleitem(idbarang) 
    {
        
        var route = '{{ url("/pesanan/eoq") }}';
        var idsupplier = $('#eoq_idsupplier').val();
        // var eoq_tipe_harga = $('#eoq_tipe_harga').val();

        // console.log(idbarang);

        $.ajax({
            url: route,
            type: 'GET',
            dataType: 'JSON',
            data: {
                'idbarang': idbarang,
                'idsupplier': idsupplier,
                // 'tipe_harga': eoq_tipe_harga
            }
        })
        .done(function(data) {
            dataEoq.push({
                'idbarang': idbarang, 
                'biaya_penyimpanan': data.biaya_penyimpanan,
                'jumlah_permintaan': data.jumlah_permintaan,
                'harga_barang': data.harga_barang,
                'jumlah_unit': data.jumlah_unit,
                'total_cost': data.total_cost
            });
            $('#eoq-jumlah-unit-'+idbarang).html(data.jumlah_unit);
            $('#eoq-total-cost-'+idbarang).html(data.total_cost);

            eoq_update_total();
            // console.log(data);
        })
        .fail(function(e) {
            alert(e.responseJSON.message);
            // console.log("error " + e);
            $('#eoq-jumlah-unit-'+idbarang).html('0');
            $('#eoq-total-cost-'+idbarang).html('0');

            eoq_update_total();
        })
        .always(function() {
            console.log("complete");
        });
            
    }

    $(document).ready(function () {
        
        $('#eoq_idsupplier').change(function(event) {
            event.preventDefault();
            eoq_munculkan_barang();

            dataEoq = [];
            eoq_update_total();
        });

        $('#eoq-form-barang').on('change', ':checkbox', function () {
            if ($(this).is(':checked')) {
                // console.log($(this).val() + ' is now checked');
                generate_eoq_singleitem($(this).val());

                // add array
                // dataEoq.push($(this).val());
            } else {
                // console.log($(this).val() + ' is now unchecked');
                $('#eoq-jumlah-unit-'+$(this).val()).html('0');
                $('#eoq-total-cost-'+$(this).val()).html('0');

                // remove array
                for (var i = 0; i < dataEoq.length; i++) {
                    if (dataEoq[i].idbarang === $(this).val()) {
                        dataEoq.splice(i, 1);
                    }
                }

                eoq_update_total();
            }
            // console.log(dataEoq);
        });

    });

</script>

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

            <div class="form-group{{ $errors->has('idsupplier') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="idsupplier">{{ __('Pilih supplier') }}</label>
                <select 
                    name="idsupplier"
                    id="idsupplier" 
                    class="form-control form-control-alternative{{ $errors->has('idsupplier') ? ' is-invalid' : '' }}" 
                    required>
                    <option value="0"></option>
                    @foreach ($supplier as $br)
                        <option value="{{ $br->id }}">{{ $br->nama }}</option>
                    @endforeach
                </select>
                @if ($errors->has('idsupplier'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('idsupplier') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-sm">
            <div class="form-group{{ $errors->has('biaya_pemesanan') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="biaya_pemesanan">{{ __('Biaya Pemesanan') }}</label>
                <input 
                    type="text" 
                    name="biaya_pemesanan" 
                    id="eoq_multiitem_biaya_pemesanan" 
                    class="form-control form-control-alternative{{ $errors->has('biaya_pemesanan') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    required>
                @if ($errors->has('biaya_pemesanan'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('biaya_pemesanan') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-sm"></div>
        <div class="col-sm">
            <div>
	           <label class="form-control-label" for="idsupplier">{{ __('Munculkan barang?') }}</label>
	           <div>
                    <button 
                        type="button" 
                        class="btn btn-success" 
                        onclick="eoq_munculkan_barang()">
                        Munculkan Barang
                    </button>
	           </div>
           </div>
        </div>
    </div>

</div>

<!-- Modal -->
<div 
    class="modal fade show" 
    id="eoq-modal-barang" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="eGenerateModal" 
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 1100px">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title" id="createModalLabel">
                    Daftar Barang
                </h3>
                <button 
                    onclick="op_eoq_daftar_brang('close')" 
                    type="button" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                    <form id="eoq-form-barang">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" width="100">NO</th>
                                <th scope="col">Barang</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Biaya Pemesanan</th>
                                <th scope="col">Biaya Penyimpanan</th>
                                <!-- <th scope="col">jumlah unit</th>
                                <th scope="col">Total Cost</th> -->
                                <th scope="col" width="50">#</th>
                            </tr>
                        </thead>
                        <tbody id="eoq-daftar-barang"></tbody>
                    </table>
                    </form>
                </div>
            </div>

            <div class="modal-body">
                <div style="text-align: right;">
                    <button 
                        type="button" 
                        class="btn btn-success" 
                        onclick="generate_all_eoq_multiitem()">
                        Generate EOQ & Simpan Pesanan
                    </button>
                </div>
            </div>

        </div>
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
        var idsupplier = $('#idsupplier').val();
        var route = '{{ url("/barang/bysupplier/") }}' + '/' + idsupplier;

        if (idsupplier == 0) {
            alert('pilih supplier terlebih dahulu.');
        } else {
            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'json'
            })
            .done(function(data) {
                var dt = '';
                
                if (data.length > 0) {
                    op_eoq_daftar_brang('open');
                    for (var i = 0; i < data.length; i++) {
                        dt += '\
                        <tr>\
                            <td>'+(i + 1)+'</td>\
                            <td>'+data[i].nama_barang+'</td>\
                            <td>'+data[i].harga_barang+'</td>\
                            <td>'+data[i].stok+'</td>\
                            <td>'+data[i].biaya_pemesanan+'</td>\
                            <td>'+data[i].biaya_penyimpanan+'</td>\
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

    function generate_all_eoq_multiitem() {
        var idsupplier = $('#idsupplier').val();
        var biaya_pemesanan = $('#eoq_multiitem_biaya_pemesanan').val();
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
                        'data': dataEoq,
                        'biaya_pemesanan': biaya_pemesanan,
                    }
                })
                .done(function(data) {
                    if (data.status === 'success') {
                        window.location = '{{ route("pesanan-multiitem") }}';
                    }
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

    function generate_eoq_multiitem(idbarang) 
    {
        var route = '{{ url("/pesanan/eoq/") }}' + '/' + idbarang;

        $.ajax({
            url: route,
            type: 'GET',
            processData: false,
            contentType: false,
            dataType: 'JSON',
        })
        .done(function(data) {
            // $('#eoq-jumlah-unit-'+idbarang).html(data.jumlah_unit);
            // $('#eoq-total-cost-'+idbarang).html(data.total_cost);
            // console.log(data.jumlah_unit);
            dataEoq.push({
                'idbarang': idbarang, 
                'biaya_penyimpanan': data.biaya_penyimpanan,
                'jumlah_permintaan': data.jumlah_permintaan,
                'harga_barang': data.harga_barang,
                'jumlah_unit': data.jumlah_unit,
                'total_cost': data.total_cost
            });
        })
        .fail(function(e) {
            // console.log("error " + e);
            $('#eoq-jumlah-unit-'+idbarang).html('0');
            $('#eoq-total-cost-'+idbarang).html('0');
        })
        .always(function() {
            console.log("complete");
        });
            
    }

    $(document).ready(function () {
        $('#eoq-form-barang').on('change', ':checkbox', function () {
            if ($(this).is(':checked')) {
                // console.log($(this).val() + ' is now checked');
                generate_eoq_multiitem($(this).val());

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
            }
            console.log(dataEoq);
        });
    });

</script>

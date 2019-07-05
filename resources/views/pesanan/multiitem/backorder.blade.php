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

    <div class="row mb-3">

        <div class="col-sm">
            <div class="form-group{{ $errors->has('bo_idsupplier') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="bo_idsupplier">{{ __('Pilih supplier') }}</label>
                <select 
                    name="bo_idsupplier"
                    id="bo_idsupplier" 
                    class="form-control form-control-alternative{{ $errors->has('bo_idsupplier') ? ' is-invalid' : '' }}" 
                    required>
                    <option value="0"></option>
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
            <div class="form-group{{ $errors->has('bo_biaya_pemesanan') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="bo_biaya_pemesanan">{{ __('Biaya Pemesanan') }}</label>
                <input 
                    type="text" 
                    name="bo_biaya_pemesanan" 
                    id="bo_multiitem_biaya_pemesanan" 
                    class="form-control form-control-alternative{{ $errors->has('bo_biaya_pemesanan') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    required>
                @if ($errors->has('bo_biaya_pemesanan'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('bo_biaya_pemesanan') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-sm">
            <div class="form-group{{ $errors->has('bo_biaya_backorder') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="bo_biaya_backorder">{{ __('Biaya Backorder') }}</label>
                <input 
                    type="text" 
                    name="bo_biaya_backorder" 
                    id="bo_multiitem_biaya_backorder" 
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

    <div class="row mb-3">
        <div class="col-sm"></div>
        <div class="col-sm"></div>
        <div class="col-sm">
            <div>
               <label class="form-control-label" for="idsupplier">{{ __('Munculkan barang?') }}</label>
               <div>
                    <button 
                        type="button" 
                        class="btn btn-success" 
                        onclick="bo_munculkan_barang()">
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
    id="bo-modal-barang" 
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
                    onclick="op_bo_daftar_brang('close')" 
                    type="button" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                    <form id="bo-form-barang">
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
                            <tbody id="bo-daftar-barang"></tbody>
                        </table>
                    </form>
                </div>
            </div>

            <div class="modal-body">
                <div style="text-align: right;">
                    <button 
                        type="button" 
                        class="btn btn-success" 
                        onclick="generate_all_bo_multiitem()">
                        Generate Backorder & Simpan Pesanan
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    var dataBackOrder = [];
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
                    op_bo_daftar_brang('open');
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
                $('#bo-daftar-barang').html(dt);
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

    function generate_all_bo_multiitem() {
        var idsupplier = $('#bo_idsupplier').val();
        var biaya_pemesanan = $('#bo_multiitem_biaya_pemesanan').val();
        var biaya_backorder = $('#bo_multiitem_biaya_backorder').val();
        var route = '{{ url("/pesanan/multiitem/bo/") }}';

        if (dataBackOrder.length > 0) {
            var a = confirm('apakah barang yang dipilih sudah tepat?');
            if (a) {generate_all_bo_multiitem
                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'idsupplier': idsupplier, 
                        'data': dataBackOrder,
                        'biaya_pemesanan': biaya_pemesanan,
                        'biaya_backorder': biaya_backorder
                    }
                })
                .done(function(data) {
                    if (data.status === 'success') {
                        window.location = '{{ route("pesanan-multiitem") }}';
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

    function generate_bo_multiitem(idbarang) 
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
            // $('#bo-jumlah-unit-'+idbarang).html(data.jumlah_unit);
            // $('#bo-total-cost-'+idbarang).html(data.total_cost);
            dataBackOrder.push({
                'idbarang': idbarang, 
                'biaya_penyimpanan': data.biaya_penyimpanan,
                'jumlah_permintaan': data.jumlah_permintaan,
                'harga_barang': data.harga_barang,
                'jumlah_unit': data.jumlah_unit,
                'total_cost': data.total_cost
            });
            // console.log(dataBackOrder);
        })
        .fail(function(e) {
            // console.log("error " + e);
            $('#bo-jumlah-unit-'+idbarang).html('0');
            $('#bo-total-cost-'+idbarang).html('0');
        })
        .always(function() {
            console.log("complete");
        });
            
    }

    $(document).ready(function () {
        $('#bo-form-barang').on('change', ':checkbox', function () {
            console.log(dataBackOrder);
            if ($(this).is(':checked')) {
                // console.log($(this).val() + ' is now checked');
                generate_bo_multiitem($(this).val());

                // add array
                // dataBackOrder.push($(this).val());
            } else {
                // console.log($(this).val() + ' is now unchecked');
                $('#bo-jumlah-unit-'+$(this).val()).html('0');
                $('#bo-total-cost-'+$(this).val()).html('0');

                // remove array
                for (var i = 0; i < dataBackOrder.length; i++) {
                    if (dataBackOrder[i].idbarang === $(this).val()) {
                        dataBackOrder.splice(i, 1);
                    }
                }
            }
        });
    });

</script>

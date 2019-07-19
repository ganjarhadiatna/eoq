<!-- <form 
    name="form-generate-eoq" 
    method="post" 
    action="{{ route('pesanan-singleitem-push') }}"
    autocomplete="off" 
    id="form-generate-eoq"> -->

    @csrf
    
    <div>
        <h3 class="mb-0">Informasi Parameter</h3>
    </div>

    <div class="row mb-2">

        <div class="col-sm">

            <div class="form-group{{ $errors->has('idbarang') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="idbarang">{{ __('Pilih Barang') }}</label>
                <select 
                    name="idbarang"
                    id="idbarang" 
                    class="form-control form-control-alternative{{ $errors->has('idbarang') ? ' is-invalid' : '' }}" 
                    required>
                    <option value="0">Pilih barang</option>
                    @foreach ($barang as $br)
                        <option value="{{ $br->id }}">{{ $br->nama_barang }}</option>
                    @endforeach
                </select>
                @if ($errors->has('idbarang'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('idbarang') }}</strong>
                    </span>
                @endif
            </div>

        </div>
        <div class="col-sm">
            <div>
	           <label class="form-control-label" for="idbarang">{{ __('Mulai perhitungan?') }}</label>
	           <div>
                    <button 
                        type="button" 
                        class="btn btn-success" 
                        onclick="generate_eoq()">
                        Generate Metode
                    </button>
	           </div>
           </div>
        </div>
    </div>

    <div>
        <h3 class="mb-0">Daftar Diskon</h3>
    </div>

    <div class="table-responsive">
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th scope="col" width="100">NO</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Jumlah Unit</th>
                    <th scope="col">Total Cost</th>
                    <th scope="col">Diskon</th>
                    <th scope="col">Min - Max</th>
                    <th scope="col" width="200">#</th>
                </tr>
            </thead>
            <tbody id="eoq-diskon"></tbody>
        </table>
    </div>

<!-- </form> -->

<script type="text/javascript">
    var clNow = "modal fade";
    var clOpen = "modal fade show";

    function generate_eoq() 
    {

        var idbarang = $('#idbarang').val();
        var route = '{{ url("/pesanan/discount") }}';

        if (idbarang == 0) {
            alert('pilih barang terlebih dahulu.');
        } else {
            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'JSON',
                data: {
                    'idbarang': idbarang
                }
            })
            .done(function(data) {

                $('#frekuensi_pembelian').val(data.frekuensi_pembelian);
                $('#reorder_point').val(data.reorder_point);

                var dt = [];

                if (data.counter != 0) {

                    var diskon = data.data;
                    // add diskon
                    if (data.counter === 1) {
                        dt = '\
                            <tr>\
                                <td>1</td>\
                                <td>'+diskon.harga_barang+'</td>\
                                <td>'+diskon.jumlah_unit+'</td>\
                                <td>'+diskon.total_cost+'</td>\
                                <td>'+(diskon.diskon * 100)+'%</td>\
                                <td>'+diskon.min+'-'+diskon.max+'</td>\
                                <td>\
                                    <button type="button" onclick="op_e_generate(\
                                        '+idbarang+',\
                                        '+diskon.harga_barang+',\
                                        '+diskon.jumlah_unit+',\
                                        '+diskon.total_cost+',\
                                        '+diskon.frekuensi_pembelian+',\
                                        '+diskon.reorder_point+'\
                                    )" \
                                    class="btn btn-danger">\
                                        Pilih Diskon Ini?\
                                    </button>\
                                </td>\
                            </tr>';
                    } else {
                        for (var i = 0; i < diskon.length; i++) {
                            dt += '\
                            <tr>\
                                <td>'+(i + 1)+'</td>\
                                <td>'+diskon[i].harga_barang+'</td>\
                                <td>'+diskon[i].jumlah_unit+'</td>\
                                <td>'+diskon[i].total_cost+'</td>\
                                <td>'+(diskon[i].diskon * 100)+'%</td>\
                                <td>'+diskon[i].min+'-'+diskon[i].max+'</td>\
                                <td>\
                                    <button type="button" onclick="op_e_generate(\
                                        '+idbarang+',\
                                        '+diskon[i].harga_barang+',\
                                        '+diskon[i].jumlah_unit+',\
                                        '+diskon[i].total_cost+',\
                                        '+diskon[i].frekuensi_pembelian+',\
                                        '+diskon[i].reorder_point+'\
                                    )" \
                                    class="btn btn-danger">\
                                        Pilih Diskon Ini?\
                                    </button>\
                                </td>\
                            </tr>';
                        }
                    }
                    $('#eoq-diskon').html(dt);
                } else {
                    // alert('barang tidak punya diskon');
                    var dt = '<tr><td colspan="7">barang tidak punya diskon</td></tr>';
                    $('#eoq-diskon').html(dt);
                }

            })
            .fail(function(e) {
                console.log("error " + e.responseJSON.message);
            })
            .always(function() {
                console.log("complete");
            });
        }
            
    }

    function op_e_generate(idbarang = 0, harga_barang = 0, jumlah_unit = 0, total_cost = 0, frekuensi_pembelian = 0, reorder_point = 0) 
    {
        var a = confirm('pilih diskon ini?');
        if (a) {
            var route = "{{ route('pesanan-singleitem-push-ajax') }}";
            var data = {
                    'idbarang': idbarang,
                    'harga_barang': harga_barang,
                    'jumlah_unit': jumlah_unit,
                    'total_cost': total_cost,
                    'frekuensi_pembelian': frekuensi_pembelian,
                    'reorder_point': reorder_point,
                    'tipe': 'Quantity Discount'
                };
            // alert(data);
            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'json',
                // processData: false,
                // contentType: false,
                data: data,
            })
            .done(function(data) {
                if (data.status === 'success') {
                    window.location = '{{ route("pesanan-item") }}';
                } else {
                    alert(data.message);
                }
                // console.log(data);
            })
            .fail(function(data) {
                console.log(data);
                alert(data.responseJSON.message);
            })
            .always(function() {
                console.log("complete");
            });
        }
    }

    $(document).ready(function () {
        // op_e_generate('open');
    });

</script>
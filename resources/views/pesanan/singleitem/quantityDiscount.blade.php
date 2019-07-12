<form 
    name="form-generate-eoq" 
    method="post" 
    action="{{ route('pesanan-singleitem-push') }}"
    autocomplete="off" 
    id="form-generate-eoq">

    @csrf
    
    <div>
        <h3 class="mb-0">Informasi Parameter</h3>
    </div>

    <div class="row mb-2">

        <div class="col-sm">

            <div class="form-group{{ $errors->has('idbarang') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="idbarang">{{ __('Pilih barang') }}</label>
                <select 
                    name="idbarang"
                    id="idbarang" 
                    class="form-control form-control-alternative{{ $errors->has('idbarang') ? ' is-invalid' : '' }}" 
                    required>
                    <option value="0"></option>
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

    <!-- <div>
        <h3 class="mb-0">Hasil Keputusan</h3>
    </div>

    <div class="row mb-2">

        <div class="col-sm">
            
            <div class="form-group{{ $errors->has('harga_barang') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="harga_barang">{{ __('Harga barang') }}</label>
                <input 
                    type="text" 
                    name="harga_barang" 
                    id="harga_barang" 
                    class="form-control form-control-alternative{{ $errors->has('harga_barang') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    readonly="true" 
                    required>
                @if ($errors->has('harga_barang'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('harga_barang') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('jumlah_unit') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="jumlah_unit">{{ __('Jumlah unit') }}</label>
                <input 
                    type="text" 
                    name="jumlah_unit" 
                    id="jumlah_unit" 
                    class="form-control form-control-alternative{{ $errors->has('jumlah_unit') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    readonly="true" 
                    required>
                @if ($errors->has('jumlah_unit'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('jumlah_unit') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('total_cost') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="total_cost">{{ __('Total cost persediaan') }}</label>
                <input 
                    type="text" 
                    name="total_cost" 
                    id="total_cost" 
                    class="form-control form-control-alternative{{ $errors->has('total_cost') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    readonly="true" 
                    required>
                @if ($errors->has('total_cost'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('total_cost') }}</strong>
                    </span>
                @endif
            </div>

        </div>
        <div class="col-sm">
                                
            <div class="form-group{{ $errors->has('frekuensi_pembelian') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="frekuensi_pembelian">{{ __('Frekuensi pembelian per-tahun') }}</label>
                <input 
                    type="text" 
                    name="frekuensi_pembelian" 
                    id="frekuensi_pembelian" 
                    class="form-control form-control-alternative{{ $errors->has('frekuensi_pembelian') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    readonly="true" 
                    required>
                @if ($errors->has('frekuensi_pembelian'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('frekuensi_pembelian') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('reorder_point') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="reorder_point">{{ __('Re-order point') }}</label>
                <input 
                    type="text" 
                    name="reorder_point" 
                    id="reorder_point" 
                    class="form-control form-control-alternative{{ $errors->has('reorder_point') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    readonly="true" 
                    required>
                @if ($errors->has('reorder_point'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('reorder_point') }}</strong>
                    </span>
                @endif
            </div>

        </div>

    </div> -->

    <!-- <div class="row align-items-center mb-2">
        <div class="col-sm"></div>
        <div class="col-4 text-right">
            <button 
                type="submit" 
                class="btn btn-secondary" >
                Simpan Pesanan
            </button>
        </div>
    </div> -->

    <div>
        <h3 class="mb-0">Daftar Diskon</h3>
    </div>

    <div class="table-responsive">
        <form id="bg-form-barang">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="100">NO</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Jumlah Unit</th>
                        <th scope="col">Total Cost</th>
                        <th scope="col">Diskon</th>
                        <th scope="col">Min - Max</th>
                        <th scope="col">Tipe</th>
                        <th scope="col" width="200">#</th>
                    </tr>
                </thead>
                <tbody id="eoq-diskon"></tbody>
                <!-- <tbody>
                    <tr>
                        <th scope="col" colspan="4">Total Keseluruhan</th>
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
                </tbody> -->
            </table>
        </form>
    </div>

</form>

<!-- Modal -->
<!-- <div 
    class="modal fade show" 
    id="e-generate" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="eGenerateModal" 
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 1000px">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title" id="createModalLabel">
                    Hasil Keputusan
                </h3>
                <button 
                    onclick="op_e_generate('close')" 
                    type="button" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
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
                                <th scope="col">Tipe</th>
                                <th scope="col" width="200">#</th>
                            </tr>
                        </thead>
                        <tbody id="eoq-diskon"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div> -->

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

                op_e_generate('open');

                $('#frekuensi_pembelian').val(data.frekuensi_pembelian);
                $('#reorder_point').val(data.reorder_point);

                var dt = [];

                // add diskon

                // add diskon
                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        dt += '\
                        <tr>\
                            <td>1</td>\
                            <td>'+data[i].harga_barang+'</td>\
                            <td>'+data[i].jumlah_unit+'</td>\
                            <td>'+data[i].total_cost+'</td>\
                            <td>'+(data[i].diskon * 100)+'%</td>\
                            <td>'+data[i].min+'-'+data[i].max+'</td>\
                            <td>Diskon Incremental</td>\
                            <td>\
                                <button onclick="op_e_generate(\
                                    '+'close'+',\
                                    '+data[i].harga_barang+',\
                                    '+data[i].jumlah_unit+',\
                                    '+data[i].total_cost+'\
                                )" \
                                class="btn btn-primary">\
                                    Pilih Ini\
                                </button>\
                            </td>\
                        </tr>';
                    }
                }

                $('#eoq-diskon').html(dt);

                console.log(data);

            })
            .fail(function(e) {
                console.log("error " + e.responseJSON.message);
            })
            .always(function() {
                console.log("complete");
            });
        }
            
    }

    function op_e_generate(stt, harga_barang = 0, jumlah_unit = 0, total_cost = 0) 
    {
        if (stt == 'open') 
        {
            $('#e-generate').attr('class', clOpen).show();
        } 
        else 
        {
            $('#e-generate').attr('class', clNow).hide();
        }
        
        $('#harga_barang').val(harga_barang);
        $('#jumlah_unit').val(jumlah_unit);
        $('#total_cost').val(total_cost);
        
    }

    $(document).ready(function () {
        // op_e_generate('open');
    });

</script>
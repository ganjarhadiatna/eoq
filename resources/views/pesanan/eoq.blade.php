<form 
    name="form-generate-eoq" 
    method="post" 
    action="{{ route('pesanan-push') }}"
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

    <div>
        <h3 class="mb-0">Hasil Keputusan</h3>
    </div>

    <div class="row mb-2">

        <div class="col-sm">
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

    </div>

    <div class="row align-items-center mb-2">
        <div class="col-sm"></div>
        <div class="col-4 text-right">
            <button 
                type="submit" 
                class="btn btn-secondary" >
                Simpan Pesanan
            </button>
        </div>
    </div>

</form>

<!-- Modal -->
<div 
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
                <!-- <button 
                    onclick="openCreateForm()" 
                    type="button" class="close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" width="100">NO</th>
                                <th scope="col">Diskon</th>
                                <th scope="col">Jumlah Unit</th>
                                <th scope="col">Total Cost</th>
                                <th scope="col">Diskon</th>
                                <th scope="col">Min - Max</th>
                                <th scope="col">Tipe</th>
                                <th scope="col" width="200">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td><b>EOQ<b></td>
                                <td>
                                    <button onclick="op_e_generate('close')" class="btn btn-primary">
                                        Pilih Ini
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td><b>Unit Discount</b></td>
                                <td>
                                    <button onclick="op_e_generate('close')" class="btn btn-primary">
                                        Pilih Ini
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td><b>Incremental Discount</b></td>
                                <td>
                                    <button onclick="op_e_generate('close')" class="btn btn-primary">
                                        Pilih Ini
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td><b>Incremental Discount</b></td>
                                <td>
                                    <button onclick="op_e_generate('close')" class="btn btn-primary">
                                        Pilih Ini
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td>XXX</td>
                                <td><b>Incremental Discount</b></td>
                                <td>
                                    <button onclick="op_e_generate('close')" class="btn btn-primary">
                                        Pilih Ini
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    var clNow = "modal fade";
    var clOpen = "modal fade show";

    function generate_eoq() 
    {
        op_e_generate('open');
        // var idbarang = $('#idbarang').val();
        // var route = '{{ url("/pesanan/eoq/") }}' + '/' + idbarang;

        // if (idbarang == 0) {
        //     alert('pilih barang terlebih dahulu.');
        // } else {
        //     $.ajax({
        //         url: route,
        //         type: 'GET',
        //         processData: false,
        //         contentType: false,
        //         dataType: 'JSON',
        //     })
        //     .done(function(data) {
        //         $('#jumlah_unit').val(data.jumlah_unit);
        //         $('#total_cost').val(data.total_cost);
        //         $('#frekuensi_pembelian').val(data.frekuensi_pembelian);
        //         $('#reorder_point').val(data.reorder_point);
        //     })
        //     .fail(function(e) {
        //         console.log("error " + e.responseJSON.message);
        //     })
        //     .always(function() {
        //         console.log("complete");
        //     });
        // }
            
    }

    function op_e_generate(stt) 
    {
        if (stt == 'open') 
        {
            $('#e-generate').attr('class', clOpen).show();
        } 
        else 
        {
            $('#e-generate').attr('class', clNow).hide();
        }
        
    }

    $(document).ready(function () {
        // op_e_generate('open');
    });

</script>
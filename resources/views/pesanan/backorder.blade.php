<form 
    name="form-generate-backorder" 
    method="post" 
    action="{{ route('pesanan-push') }}"
    autocomplete="off" 
    id="form-generate-backorder">

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
                    id="bo_idbarang" 
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

            <div class="form-group{{ $errors->has('biaya_backorder') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="biaya_backorder">{{ __('Biaya Backorder') }}</label>
                <input 
                    type="text" 
                    name="biaya_backorder" 
                    id="bo_biaya_backorder" 
                    class="form-control form-control-alternative{{ $errors->has('biaya_backorder') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    required>
                @if ($errors->has('biaya_backorder'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('biaya_backorder') }}</strong>
                    </span>
                @endif
            </div>

        </div>
    </div>

    <div class="row mb-2">
        <div class="col-sm"></div>
        <div class="col-sm">
            <div>
                <label class="form-control-label" for="idbarang">{{ __('Mulai perhitungan?') }}</label>
                <div>
                    <button 
                        type="button" 
                        class="btn btn-success" 
                        onclick="generate_backorder()">
                        Generate Backorder
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
                    id="bo_jumlah_unit" 
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
                    id="bo_total_cost" 
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
                    id="bo_frekuensi_pembelian" 
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
                    id="bo_reorder_point" 
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

<script type="text/javascript">

        function generate_backorder()
        {
            var idbarang = $('#bo_idbarang').val();
            var biaya_backorder = $('#bo_biaya_backorder').val();
            var route = '{{ url("/pesanan/backorder/") }}' + '/' + idbarang + '/' + biaya_backorder;

            if (idbarang == 0) 
            {
                alert('pilih barang terlebih dahulu.');
            } 
            if (biaya_backorder == '') 
            {
                alert('biaya backorder harus diisi.');
            } 
            else 
            {
                $.ajax({
                    url: route,
                    type: 'GET',
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                })
                .done(function(data) {
                    $('#bo_jumlah_unit').val(data.jumlah_unit);
                    $('#bo_total_cost').val(data.total_cost);
                    $('#bo_frekuensi_pembelian').val(data.frekuensi_pembelian);
                    $('#bo_reorder_point').val(data.reorder_point);
                })
                .fail(function(e) {
                    console.log("error " + e.responseJSON.message);
                })
                .always(function() {
                    console.log("complete");
                });
            }
        }
        
</script>
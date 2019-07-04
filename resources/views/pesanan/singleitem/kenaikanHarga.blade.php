<form 
    name="form-generate-increase-price" 
    method="post" 
    action="{{ route('pesanan-singleitem-push') }}"
    autocomplete="off" 
    id="form-generate-increase-price">

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
                    id="ip_idbarang" 
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

            <div class="form-group{{ $errors->has('kenaikan_harga') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="kenaikan_harga">{{ __('Kenaikan Harga') }}</label>
                <input 
                    type="text" 
                    name="kenaikan_harga" 
                    id="ip_kenaikan_harga" 
                    class="form-control form-control-alternative{{ $errors->has('kenaikan_harga') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    required>
                @if ($errors->has('kenaikan_harga'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('kenaikan_harga') }}</strong>
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
                        onclick="generate_increase_price()">
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

            <div class="form-group{{ $errors->has('jumlah_unit_kenaikan') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="jumlah_unit_kenaikan">{{ __('Jumlah unit setelah kenaikan') }}</label>
                <input 
                    type="text" 
                    name="jumlah_unit_kenaikan" 
                    id="ip_jumlah_unit_kenaikan" 
                    class="form-control form-control-alternative{{ $errors->has('jumlah_unit_kenaikan') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    readonly="true" 
                    required>
                @if ($errors->has('jumlah_unit_kenaikan'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('jumlah_unit_kenaikan') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('jumlah_unit_khusus') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="jumlah_unit_khusus">{{ __('Jumlah unit khusus') }}</label>
                <input 
                    type="text" 
                    name="jumlah_unit" 
                    id="ip_jumlah_unit_khusus" 
                    class="form-control form-control-alternative{{ $errors->has('jumlah_unit_khusus') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    readonly="true" 
                    required>
                @if ($errors->has('jumlah_unit_khusus'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('jumlah_unit_khusus') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('besar_penghematan') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="besar_penghematan">{{ __('Besar Penghematan') }}</label>
                <input 
                    type="text" 
                    name="besar_penghematan" 
                    id="ip_besar_penghematan" 
                    class="form-control form-control-alternative{{ $errors->has('besar_penghematan') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    readonly="true" 
                    required>
                @if ($errors->has('besar_penghematan'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('besar_penghematan') }}</strong>
                    </span>
                @endif
            </div>

            <!--<div class="form-group{{ $errors->has('total_cost_s') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="total_cost_s">{{ __('Total cost persediaan (s)') }}</label>
                <input 
                    type="text" 
                    name="total_cost_s" 
                    id="ip_total_cost_s" 
                    class="form-control form-control-alternative{{ $errors->has('total_cost_s') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    readonly="true" 
                    required>
                @if ($errors->has('total_cost_s'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('total_cost_s') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('total_cost_n') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="total_cost_n">{{ __('Total cost persediaan (n)') }}</label>
                <input 
                    type="text" 
                    name="total_cost_n" 
                    id="ip_total_cost_n" 
                    class="form-control form-control-alternative{{ $errors->has('total_cost_n') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    readonly="true" 
                    required>
                @if ($errors->has('total_cost_n'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('total_cost_n') }}</strong>
                    </span>
                @endif
            </div>-->

        </div>
        <div class="col-sm">
                                
            <div class="form-group{{ $errors->has('frekuensi_pembelian') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="frekuensi_pembelian">{{ __('Frekuensi pembelian per-tahun') }}</label>
                <input 
                    type="text" 
                    name="frekuensi_pembelian" 
                    id="ip_frekuensi_pembelian" 
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
                    id="ip_reorder_point" 
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

        function generate_increase_price()
        {
            var idbarang = $('#ip_idbarang').val();
            var kenaikan_harga = $('#ip_kenaikan_harga').val();
            var route = '{{ url("/pesanan/increases_price/") }}' + '/' + idbarang + '/' + kenaikan_harga;

            if (idbarang == 0) 
            {
                alert('pilih barang terlebih dahulu.');
            } 
            if (kenaikan_harga == '') 
            {
                alert('biaya increase-price harus diisi.');
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
                    $('#ip_jumlah_unit_khusus').val(data.jumlah_unit_khusus);
                    $('#ip_jumlah_unit_kenaikan').val(data.jumlah_unit_kenaikan);
                    // $('#ip_total_cost_s').val(data.total_cost_s);
                    // $('#ip_total_cost_n').val(data.total_cost_n);
                    $('#ip_frekuensi_pembelian').val(data.frekuensi_pembelian);
                    $('#ip_reorder_point').val(data.reorder_point);
                    $('#ip_besar_penghematan').val(data.besar_penghematan);
                })
                .fail(function(e) {
                    console.log("error " + e);
                })
                .always(function() {
                    console.log("complete");
                });
            }
        }
        
</script>
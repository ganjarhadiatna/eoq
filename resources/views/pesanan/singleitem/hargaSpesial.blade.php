<form 
    name="form-generate-special-price" 
    method="post" 
    action="{{ route('pesanan-singleitem-push') }}"
    autocomplete="off" 
    id="form-generate-special-price">

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
                    id="hs_idbarang" 
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

            <div class="form-group{{ $errors->has('harga_spesial') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="harga_spesial">{{ __('Harga Spesial') }}</label>
                <input 
                    type="text" 
                    name="harga_spesial" 
                    id="hs_harga_spesial" 
                    class="form-control form-control-alternative{{ $errors->has('harga_spesial') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    required>
                @if ($errors->has('harga_spesial'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('harga_spesial') }}</strong>
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
                        onclick="generate_special_price()">
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
            <div class="form-group{{ $errors->has('jumlah_unit_sebelumnya') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="jumlah_unit_sebelumnya">{{ __('Jumlah unit sebelumnya') }}</label>
                <input 
                    type="text" 
                    name="jumlah_unit_sebelumnya" 
                    id="hs_jumlah_unit_sebelumnya" 
                    class="form-control form-control-alternative{{ $errors->has('jumlah_unit_sebelumnya') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    readonly="true" 
                    required>
                @if ($errors->has('jumlah_unit_sebelumnya'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('jumlah_unit_sebelumnya') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('jumlah_unit_khusus') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="jumlah_unit_khusus">{{ __('Jumlah unit harga sepesial') }}</label>
                <input 
                    type="text" 
                    name="jumlah_unit" 
                    id="hs_jumlah_unit_khusus" 
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

            <!-- <div class="form-group{{ $errors->has('total_cost_n') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="hs_total_cost_n">{{ __('Total cost persediaan (s)') }}</label>
                <input 
                    type="text" 
                    name="total_cost_n" 
                    id="hs_total_cost_n" 
                    class="form-control form-control-alternative{{ $errors->has('total_cost_n') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    readonly="true" 
                    required>
                @if ($errors->has('total_cost_n'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('total_cost_n') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('total_cost_n') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="total_cost_n">{{ __('Total cost persediaan (n)') }}</label>
                <input 
                    type="text" 
                    name="total_cost_n" 
                    id="hs_total_cost_n" 
                    class="form-control form-control-alternative{{ $errors->has('total_cost_n') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    readonly="true" 
                    required>
                @if ($errors->has('total_cost_n'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('total_cost_n') }}</strong>
                    </span>
                @endif
            </div> -->

            <div class="form-group{{ $errors->has('besar_penghematan') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="besar_penghematan">{{ __('Besar Penghematan') }}</label>
                <input 
                    type="text" 
                    name="besar_penghematan" 
                    id="hs_besar_penghematan" 
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

        </div>
        <div class="col-sm">
                                
            <div class="form-group{{ $errors->has('frekuensi_pembelian') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="frekuensi_pembelian">{{ __('Frekuensi pembelian per-tahun') }}</label>
                <input 
                    type="text" 
                    name="frekuensi_pembelian" 
                    id="hs_frekuensi_pembelian" 
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
                    id="hs_reorder_point" 
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

        function generate_special_price()
        {
            var idbarang = $('#hs_idbarang').val();
            var harga_spesial = $('#hs_harga_spesial').val();
            var route = '{{ url("/pesanan/special_price/") }}' + '/' + idbarang + '/' + harga_spesial;

            if (idbarang == 0) 
            {
                alert('pilih barang terlebih dahulu.');
            } 
            if (harga_spesial == '') 
            {
                alert('harga spesial harus diisi.');
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
                    $('#hs_jumlah_unit_sebelumnya').val(data.jumlah_unit_sebelumnya);
                    $('#hs_jumlah_unit_khusus').val(data.jumlah_unit_khusus);
                    $('#hs_total_cost_s').val(data.total_cost_s);
                    $('#hs_total_cost_n').val(data.total_cost_n);
                    $('#hs_frekuensi_pembelian').val(data.frekuensi_pembelian);
                    $('#hs_reorder_point').val(data.reorder_point);
                    $('#hs_besar_penghematan').val(data.besar_penghematan);
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
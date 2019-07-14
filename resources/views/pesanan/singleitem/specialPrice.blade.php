<form 
    name="form-generate-special-price" 
    method="post" 
    action="{{ route('pesanan-singleitem-push') }}"
    autocomplete="off" 
    id="form-generate-special-price">

    @csrf

    <input type="hidden" name="tipe" value="Special Order">

    <div>
        <h3 class="mb-0">Informasi Parameter</h3>
    </div>

    <div class="row mb-3">

        <div class="col-sm">
            <div class="form-group{{ $errors->has('idbarang') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="sp_idbarang">{{ __('Pilih Barang') }}</label>
                <select 
                    name="idbarang"
                    id="sp_idbarang" 
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
            <div class="form-group{{ $errors->has('harga_spesial') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="sp_harga_spesial">{{ __('Harga Spesial') }}</label>
                <input 
                    type="text" 
                    name="harga_spesial" 
                    id="sp_harga_spesial" 
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

        <div class="col-sm">
            <div class="form-group{{ $errors->has('tipe_harga') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="sp_tipe_harga">{{ __('Tipe Pemesanan') }}</label>
                <select 
                    name="tipe_harga"
                    id="sp_tipe_harga" 
                    class="form-control form-control-alternative{{ $errors->has('tipe_harga') ? ' is-invalid' : '' }}" 
                    required>
                    <option value="1">Pemesanan Khusus</option>
                    <option value="2">Pemesanan Normal</option>
                </select>
                @if ($errors->has('tipe_harga'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('tipe_harga') }}</strong>
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
                <label class="form-control-label" for="sp_idbarang">{{ __('Mulai perhitungan?') }}</label>
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

            <div class="form-group{{ $errors->has('harga_barang') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="sp_harga_barang">{{ __('Harga Barang') }}</label>
                <input 
                    type="text" 
                    name="harga_barang" 
                    id="sp_harga_barang" 
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

            <div class="form-group{{ $errors->has('jumlah_permintaan') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="sp_jumlah_permintaan">{{ __('Jumlah Permintaan') }}</label>
                <input 
                    type="text" 
                    name="jumlah_permintaan" 
                    id="sp_jumlah_permintaan" 
                    class="form-control form-control-alternative{{ $errors->has('jumlah_permintaan') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    readonly="true" 
                    required>
                @if ($errors->has('jumlah_permintaan'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('jumlah_permintaan') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('jumlah_unit') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="sp_jumlah_unit">{{ __('EOQ') }}</label>
                <input 
                    type="text" 
                    name="jumlah_unit" 
                    id="sp_jumlah_unit" 
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
                <label class="form-control-label" for="sp_total_cost">{{ __('Total Cost') }}</label>
                <input 
                    type="text" 
                    name="total_cost" 
                    id="sp_total_cost" 
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

            <div class="form-group{{ $errors->has('besar_penghematan') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="sp_besar_penghematan">{{ __('Besar Penghematan') }}</label>
                <input 
                    type="text" 
                    name="besar_penghematan" 
                    id="sp_besar_penghematan" 
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
                <label class="form-control-label" for="sp_frekuensi_pembelian">{{ __('Frekuensi pembelian per-tahun') }}</label>
                <input 
                    type="text" 
                    name="frekuensi_pembelian" 
                    id="sp_frekuensi_pembelian" 
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
                <label class="form-control-label" for="sp_reorder_point">{{ __('Re-order point') }}</label>
                <input 
                    type="text" 
                    name="reorder_point" 
                    id="sp_reorder_point" 
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
            var route = '{{ url("/pesanan/specialprice") }}';
            var sp_idbarang = $('#sp_idbarang').val();
            var sp_harga_spesial = $('#sp_harga_spesial').val();
            var sp_tipe_harga = $('#sp_tipe_harga').val()
            console.log(sp_idbarang);

            if (sp_idbarang == 0) 
            {
                alert('pilih barang terlebih dahulu.');
            } 
            if (sp_harga_spesial == '') 
            {
                alert('harga spesial harus diisi.');
            } 
            else 
            {
                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        'idbarang': sp_idbarang,
                        'special_price': sp_harga_spesial,
                        'tipe_harga': sp_tipe_harga
                    }
                })
                .done(function(data) {
                    $('#sp_harga_barang').val(data.harga_barang);
                    $('#sp_jumlah_unit').val(data.jumlah_unit);
                    $('#sp_total_cost').val(data.total_cost);
                    $('#sp_frekuensi_pembelian').val(data.frekuensi_pembelian);
                    $('#sp_reorder_point').val(data.reorder_point);
                    $('#sp_besar_penghematan').val(data.besar_penghematan);
                    $('#sp_jumlah_permintaan').val(data.jumlah_permintaan);
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
        
</script>
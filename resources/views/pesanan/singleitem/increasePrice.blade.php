<form 
    name="form-generate-increase-price" 
    method="post" 
    action="{{ route('pesanan-singleitem-push') }}"
    autocomplete="off" 
    id="form-generate-increase-price">

    @csrf

    <input type="hidden" name="tipe" value="Price Increase">

    <div>
        <h3 class="mb-0">Informasi Parameter</h3>
    </div>

    <div class="row mb-3">

        <div class="col-sm">
            <div class="form-group{{ $errors->has('idbarang') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="ip_idbarang">{{ __('Pilih Barang') }}</label>
                <select 
                    name="idbarang"
                    id="ip_idbarang" 
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
            <div class="form-group{{ $errors->has('increase_price') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="ip_increase_price">{{ __('Kenaikan Harga') }}</label>
                <input 
                    type="text" 
                    name="increase_price" 
                    id="ip_increase_price" 
                    class="form-control form-control-alternative{{ $errors->has('increase_price') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    required>
                @if ($errors->has('increase_price'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('increase_price') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="col-sm">
            <div class="form-group{{ $errors->has('tipe_harga') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="ip_tipe_harga">{{ __('Tipe Pemesanan') }}</label>
                <select 
                    name="tipe_harga"
                    id="ip_tipe_harga" 
                    class="form-control form-control-alternative{{ $errors->has('tipe_harga') ? ' is-invalid' : '' }}" 
                    required>
                    <option value="1">Pemesanan Setelah Kenaikan</option>
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
                <label class="form-control-label" for="ip_idbarang">{{ __('Mulai perhitungan?') }}</label>
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

            <div class="form-group{{ $errors->has('harga_barang') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="ip_harga_barang">{{ __('Harga Barang') }}</label>
                <input 
                    type="text" 
                    name="harga_barang" 
                    id="ip_harga_barang" 
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
                <label class="form-control-label" for="ip_jumlah_permintaan">{{ __('Jumlah Permintaan') }}</label>
                <input 
                    type="text" 
                    name="jumlah_permintaan" 
                    id="ip_jumlah_permintaan" 
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
                <label class="form-control-label" for="ip_jumlah_unit">{{ __('EOQ') }}</label>
                <input 
                    type="text" 
                    name="jumlah_unit" 
                    id="ip_jumlah_unit" 
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
                <label class="form-control-label" for="ip_total_cost">{{ __('Total Cost') }}</label>
                <input 
                    type="text" 
                    name="total_cost" 
                    id="ip_total_cost" 
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
                <label class="form-control-label" for="ip_frekuensi_pembelian">{{ __('Frekuensi pembelian per-tahun') }}</label>
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
                <label class="form-control-label" for="ip_reorder_point">{{ __('Re-order point') }}</label>
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
            var route = '{{ url("/pesanan/increaseprice") }}';
            var ip_idbarang = $('#ip_idbarang').val();
            var ip_increase_price = $('#ip_increase_price').val();
            var ip_tipe_harga = $('#ip_tipe_harga').val()
            console.log(ip_idbarang);

            if (ip_idbarang == 0) 
            {
                alert('pilih barang terlebih dahulu.');
            } 
            if (ip_increase_price == '') 
            {
                alert('kenaikan harga harus diisi.');
            } 
            else 
            {
                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        'idbarang': ip_idbarang,
                        'increase_price': ip_increase_price,
                        'tipe_harga': ip_tipe_harga
                    }
                })
                .done(function(data) {
                    $('#ip_harga_barang').val(data.harga_barang);
                    $('#ip_jumlah_unit').val(data.jumlah_unit);
                    $('#ip_total_cost').val(data.total_cost);
                    $('#ip_frekuensi_pembelian').val(data.frekuensi_pembelian);
                    $('#ip_reorder_point').val(data.reorder_point);
                    $('#ip_jumlah_permintaan').val(data.jumlah_permintaan);
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
<!-- <form 
    name="form-generate-increase-price" 
    method="post" 
    action="{{ route('pesanan-singleitem-push') }}"
    autocomplete="off" 
    id="form-generate-increase-price">

    @csrf -->

    <div>
        <h3 class="mb-0">Informasi Parameter</h3>
    </div>

    <div class="row mb-2">

        <div class="col-sm">
            <div class="form-group{{ $errors->has('idsupplier') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="bm_idsupplier">{{ __('Pilih Supplier') }}</label>
                <select 
                    name="idsupplier"
                    id="bm_idsupplier" 
                    class="form-control form-control-alternative{{ $errors->has('idsupplier') ? ' is-invalid' : '' }}" 
                    required>
                    <option value="0">Pilih Supplier</option>
                    @foreach ($supplier as $br)
                        <option value="{{ $br->id }}">{{ $br->nama }}</option>
                    @endforeach
                </select>
                @if ($errors->has('eoq_idsupplier'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('eoq_idsupplier') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="col-sm">
            <div class="form-group{{ $errors->has('kendala_modal') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="bm_kendala_modal">{{ __('Kendala Modal') }}</label>
                <input 
                    type="text" 
                    name="kendala_modal" 
                    id="bm_kendala_modal" 
                    class="form-control form-control-alternative{{ $errors->has('kendala_modal') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    required>
                @if ($errors->has('kendala_modal'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('kendala_modal') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-sm"></div>
        <div class="col-sm">
            <div>
                <label class="form-control-label">{{ __('Mulai perhitungan?') }}</label>
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

            <!-- <div class="form-group{{ $errors->has('harga_barang') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="bm_harga_barang">{{ __('Harga Barang') }}</label>
                <input 
                    type="text" 
                    name="harga_barang" 
                    id="bm_harga_barang" 
                    class="form-control form-control-alternative{{ $errors->has('harga_barang') ? ' is-invalid' : '' }}" 
                    placeholder="0" 
                    readonly="true" 
                    required>
                @if ($errors->has('harga_barang'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('harga_barang') }}</strong>
                    </span>
                @endif
            </div> -->

            <div class="form-group{{ $errors->has('jumlah_unit') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="bm_jumlah_unit">{{ __('EOQ') }}</label>
                <input 
                    type="text" 
                    name="jumlah_unit" 
                    id="bm_jumlah_unit" 
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
                <label class="form-control-label" for="bm_total_cost">{{ __('Total Cost') }}</label>
                <input 
                    type="text" 
                    name="total_cost" 
                    id="bm_total_cost" 
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
                <label class="form-control-label" for="bm_frekuensi_pembelian">{{ __('Frekuensi pembelian per-tahun') }}</label>
                <input 
                    type="text" 
                    name="frekuensi_pembelian" 
                    id="bm_frekuensi_pembelian" 
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
                <label class="form-control-label" for="bm_reorder_point">{{ __('Re-order point') }}</label>
                <input 
                    type="text" 
                    name="reorder_point" 
                    id="bm_reorder_point" 
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

<!-- </form> -->

<script type="text/javascript">

        function generate_special_price()
        {
            var route = '{{ url("/pesanan/multiitem/bm") }}';
            var bm_idsupplier = $('#bm_idsupplier').val();
            var bm_kendala_modal = $('#bm_kendala_modal').val();
            var bm_idbarang = 1;
            console.log(bm_kendala_modal);

            if (bm_idbarang == 0) 
            {
                alert('pilih barang terlebih dahulu.');
            } 
            if (bm_kendala_modal == '') 
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
                        'idsupplier': bm_idsupplier,
                        'kendala_modal': bm_kendala_modal
                    }
                })
                .done(function(data) {
                    // $('#bm_harga_barang').val(data.harga_barang);
                    // $('#bm_jumlah_unit').val(data.jumlah_unit);
                    // $('#bm_total_cost').val(data.total_cost);
                    // $('#bm_frekuensi_pembelian').val(data.frekuensi_pembelian);
                    // $('#bm_reorder_point').val(data.reorder_point);
                    // $('#bm_besar_penghematan').val(data.besar_penghematan);
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
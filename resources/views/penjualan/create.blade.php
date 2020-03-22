@extends('layouts.app')

@section('content')
	<div class="card bg-secondary shadow">
		<div class="card-header bg-white border-0">
			<h3 class="mb-0">{{ __('Tambah Penjualan') }}</h3>
		</div>

		<div class="card-body">
        <div class="row">
            <div class="col-sm">
                <form 
                id="formSubmit" 
                method="post" 
                action="javascript:void(0)" 
                autocomplete="off">
                @csrf


                    <div>
                        <h3 class="mb-0">Kode Transaksi</h3>
                    </div>

                    <div>
                        <div class="form-group{{ $errors->has('kode_transaksi') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="kode_transaksi">{{ __('Kode transaksi (hanya satu kali pengisian) *') }}</label>
                            <input 
                                type="text" 
                                name="kode_transaksi" 
                                id="kode_transaksi" 
                                class="form-control form-control-alternative{{ $errors->has('kode_transaksi') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('AAA-000') }}"
                                min="0"
                                required>
                                @if ($errors->has('kode_transaksi'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('kode_transaksi') }}</strong>
                                    </span>
                                @endif
                        </div>
                    </div>

                    <div>

                        <div>
                            <h3 class="mb-0">Data Barang</h3>
                        </div>

                        <div class="row mb-2">

                            <div class="col-sm">
                                <div class="form-group{{ $errors->has('idbarang') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="idbarang">{{ __('Pilih barang *') }}</label>
                                    <select 
                                        name="idbarang" 
                                        id="idbarang" 
                                        class="form-control form-control-alternative{{ $errors->has('idbarang') ? ' is-invalid' : '' }}" 
                                        required>
                                        <option value="0">Pilih barang</option>
                                        @foreach ($barang as $ctr)
                                            <option value="{{ $ctr->id }}">{{ $ctr->nama_barang }}</option>
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
                                <div class="form-group{{ $errors->has('jumlah_barang') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="jumlah_barang">{{ __('Jumlah barang *') }}</label>
                                    <input 
                                        type="number" 
                                        name="jumlah_barang" 
                                        id="jumlah_barang" 
                                        class="form-control form-control-alternative{{ $errors->has('jumlah_barang') ? ' is-invalid' : '' }}" 
                                        placeholder="{{ __('0') }}"
                                        min="0"
                                        required>
                                        @if ($errors->has('jumlah_barang'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('jumlah_barang') }}</strong>
                                            </span>
                                        @endif
                                </div>
                            </div>

                        </div>

                        <div class="row mb-3">

                            <div class="col-sm">
                                <div class="form-group{{ $errors->has('stok_barang') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="stok_barang">{{ __('Stok barang') }}</label>
                                    <input 
                                        type="text" 
                                        name="stok_barang" 
                                        id="stok_barang" 
                                        class="form-control form-control-alternative{{ $errors->has('stok_barang') ? ' is-invalid' : '' }}" 
                                        placeholder="{{ __('0') }}" 
                                        readonly="true" 
                                        min="0"
                                        disabled 
                                        required>
                                </div>
                                <div class="form-group{{ $errors->has('sisa_stok') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="sisa_stok">{{ __('Sisa stok') }}</label>
                                    <input 
                                        type="text" 
                                        name="sisa_stok" 
                                        id="sisa_stok" 
                                        class="form-control form-control-alternative{{ $errors->has('sisa_stok') ? ' is-invalid' : '' }}" 
                                        placeholder="{{ __('0') }}" 
                                        readonly="true" 
                                        min="0"
                                        required>
                                </div>
                            </div>

                            <div class="col-sm">

                                <div class="form-group{{ $errors->has('harga_barang') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="harga_barang">{{ __('Harga barang') }}</label>
                                    <input 
                                        type="number" 
                                        name="harga_barang" 
                                        id="harga_barang" 
                                        class="form-control form-control-alternative{{ $errors->has('harga_barang') ? ' is-invalid' : '' }}" 
                                        placeholder="{{ __('0') }}" 
                                        readonly="true" 
                                        required>
                                        @if ($errors->has('harga_barang'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('harga_barang') }}</strong>
                                            </span>
                                        @endif
                                </div>
                                <div class="form-group{{ $errors->has('total_biaya') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="total_biaya">{{ __('Total biaya') }}</label>
                                    <input 
                                        type="number" 
                                        name="total_biaya" 
                                        id="total_biaya" 
                                        class="form-control form-control-alternative{{ $errors->has('total_biaya') ? ' is-invalid' : '' }}" 
                                        placeholder="{{ __('0') }}" 
                                        readonly="true" 
                                        required>
                                        @if ($errors->has('total_biaya'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('total_biaya') }}</strong>
                                            </span>
                                        @endif
                                </div>

                            </div>
                            <div class="col-sm">
                                <label class="form-control-label">Tambah?</label>
                                <div>
                                    <button 
                                        type="submit" 
                                        class="btn btn-primary">Tambah Barang</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-5">
                <div>
                    <h3 class="mb-0">Data Penjualan</h3>
                    <label class="form-control-label">{{ __('Data ini tidak akan disimpan di database *') }}</label>
                </div>
                <div class="form-group{{ $errors->has('total_penjualan') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="total_penjualan">{{ __('Total biaya penjualan') }}</label>
                    <input 
                        type="text" 
                        name="total_penjualan" 
                        id="total_penjualan" 
                        class="form-control form-control-alternative{{ $errors->has('total_penjualan') ? ' is-invalid' : '' }}" 
                        placeholder="{{ __('0') }}"
                        min="0"
                        readonly="true" 
                        required>
                        @if ($errors->has('total_penjualan'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('total_penjualan') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="form-group{{ $errors->has('jumlah_uang') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="jumlah_uang">{{ __('Jumlah uang') }}</label>
                    <input 
                        type="text" 
                        name="jumlah_uang" 
                        id="jumlah_uang" 
                        class="form-control form-control-alternative{{ $errors->has('jumlah_uang') ? ' is-invalid' : '' }}" 
                        placeholder="{{ __('0') }}"
                        min="0"
                        required>
                        @if ($errors->has('jumlah_uang'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('jumlah_uang') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="form-group{{ $errors->has('jumlah_kembalian') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="jumlah_kembalian">{{ __('Jumlah kembalian') }}</label>
                    <input 
                        type="text" 
                        name="jumlah_kembalian" 
                        id="jumlah_kembalian" 
                        class="form-control form-control-alternative{{ $errors->has('jumlah_kembalian') ? ' is-invalid' : '' }}" 
                        placeholder="{{ __('0') }}"
                        min="0"
                        readonly="true" 
                        required>
                        @if ($errors->has('jumlah_kembalian'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('jumlah_kembalian') }}</strong>
                            </span>
                        @endif
                </div>
            </div>
        </div>

            <div>
                <h3 class="mb-0">Daftar Barang</h3>
            </div>
            <div class="table-responsive">
                <table class="table align-barang-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="100">NO</th>
                        <th scope="col">Kode Transaksi</th>
                        <th scope="col">Tanggal Transaksi</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Satuan</th>
                        <th scope="col">Jumlah Barang</th>
                        <th scope="col">Harga Barang</th>
                        <th scope="col">Total Biaya</th>
                        <th scope="col" width="200">#</th>
                    </tr>
                </thead>
                <tbody id="get-result"></tbody>
            </div>

		</div>

	</div>

    <script type="text/javascript">

        function removeData(id) {
            var route = "{{ url('/penjualan/hapus/') }}" + '/' + id;
            var a = confirm('hapus data penjualan ini?');
            if (a === true) {
                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                        opLoading();
                    }
                })
                .done(function(data) {
                    if (data.status == 'success') {
                        alert('data berhasil dihapus');
                        getData($('#kode_transaksi').val());
                    } else {
                        alert('data gagal dihapus');
                    }
                    clLoading();
                })
                .fail(function(e) {
                    console.log("error " + e.responseJSON.message);
                    clLoading();
                })
                .always(function() {
                    console.log("complete");
                });
            }
        }

        function getData(kode_transaksi) {
            var route = "{{ url('/penjualan/byKodeTransaksi/') }}" + '/' + kode_transaksi;
            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    // opLoading();
                }
            })
            .done(function(data) {
                var dt = '';
                var total_penjualan = 0;
                for (var i = 0; i < data.length; i++) {
                    dt += '\
                    <tr>\
                        <td>'+(i + 1)+'</td>\
                        <td>'+data[i].kode_transaksi+'</td>\
                        <td>'+data[i].tanggal_penjualan+'</td>\
                        <td>'+data[i].nama_barang+'</td>\
                        <td>'+data[i].satuan+'</td>\
                        <td>'+data[i].jumlah_barang+'</td>\
                        <td>'+data[i].harga_barang+'</td>\
                        <td>'+data[i].total_biaya+'</td>\
                        <td>\
                            <button \
                                onclick="removeData('+data[i].id+')"\
                                class="btn btn-danger">\
                                Hapus\
                            </button>\
                        </td>\
                    </tr>\
                    ';
                    total_penjualan += data[i].total_biaya;
                }

                $('#get-result').html(dt);
                $('#total_penjualan').val(total_penjualan);
                $('#jumlah_uang').val('');
                $('#jumlah_kembalian').val('');

                // clLoading();
            })
            .fail(function(e) {
                console.log("error " + e.responseJSON.message);
                // clLoading();
            })
            .always(function() {
                console.log("complete");
            });
        }

        $(document).ready(function() {

            $('#formSubmit').on('submit', function(event) {
                event.preventDefault();
                /* Act on the event */

                var route = "{{ route('penjualan-add') }}";
                var token = event.target[0].target;
                var kode_transaksi = event.target[1].value;
                var idbarang = event.target[2].value;
                var jumlah_barang = event.target[3].value;
                var stok_barang = event.target[4].value;
                var sisa_stok = event.target[5].value;
                var harga_barang = event.target[6].value;
                var total_biaya = event.target[7].value;

                console.log(route);

                if (idbarang !== '0') {
                    $.ajax({
                        url: route,
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            '_token': token,
                            'kode_transaksi': kode_transaksi,
                            'idbarang': idbarang,
                            'jumlah_barang': jumlah_barang,
                            'stok_barang': stok_barang,
                            'sisa_stok': sisa_stok,
                            'harga_barang': harga_barang,
                            'total_biaya': total_biaya
                        },
                        beforeSend: function () {
                            opLoading();
                        }
                    })
                    .done(function(data) {
                        // console.log(data);
                        if (data.status == 'success') {
                            getData(kode_transaksi);
                        } else {
                            alert('data gagal di upload');
                        }
                        clLoading();
                    })
                    .fail(function(e) {
                        console.log("error => " + e.responseJSON.message);
                        clLoading();
                    })
                    .always(function() {
                        console.log("complete");
                    });
                }
                
            });

            $('#idbarang').on('click', function(event) {
                event.preventDefault();
                /* Act on the event */
                var idbarang = $(this).val();
                var jumlah_barang = $('#jumlah_barang').val();
                var url = '{{ url("/barang/price_item/") }}' + '/' + idbarang;

                if (idbarang != 0) {
                    // get price items
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function () {
                            opLoading();
                        }
                    })
                    .done(function(data) {
                        var total = data.harga_jual * jumlah_barang;

                        console.log(data.harga_jual);
                        $('#harga_barang').val(data.harga_barang);
                        $('#stok_barang').val(data.stok_barang);
                        $('#total_biaya').val(total);
                        clLoading();
                    })
                    .fail(function(data) {
                        console.log(data);
                        clLoading();
                    })
                    .always(function() {
                        console.log("complete");
                    });
                } else {
                    $('#harga_barang').val('');
                    $('#stok_barang').val('');
                    $('#sisa_barang').val('');
                    $('#total_biaya').val('');
                    $('#jumlah_uang').val('');
                    $('#jumlah_kembalian').val('');
                }

                // console.log(url);

            });

            $('#jumlah_barang').keyup(function(event) {

                var total = $('#harga_barang').val() * $('#jumlah_barang').val();
                var stok = $('#stok_barang').val() - $('#jumlah_barang').val();

                $('#total_biaya').val(total);
                if ($('#stok_barang').val() != '0') {
                    $('#sisa_stok').val(stok);
                }
            });

            $('#kode_transaksi').keyup(function(event) {
                getData($('#kode_transaksi').val());
            });

            $('#jumlah_uang').keyup(function(event) {
                var jumlah_uang = $('#jumlah_uang').val();
                var total_penjualan = $('#total_penjualan').val();
                var temp = jumlah_uang - total_penjualan;
                $('#jumlah_kembalian').val(temp);
            });

        });
    </script>

@endsection
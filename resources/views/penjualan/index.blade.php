@extends('layouts.app')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-barang-center mb-2">
                <div class="col-sm">
                    <h3 class="mb-0">Daftar Penjualan</h3>
                </div>
                <div class="col-3 form-inline text-right">
                    <form action="#" class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lg fa-search"></i>
                                </span>
                            </div>
                            <input class="form-control" placeholder="Cari penjualan" type="text">
                        </div>
                    </form>
                </div>
                <div class="col-2 text-right">
                    <button 
                        type="button" 
                        class="btn btn-primary"
                        onclick="openCreateForm()" >
                        <i class="fa fa-lg fa-plus"></i>
                        Tambah
                    </button>
                    <!-- <a href="{{ route('penjualan-tambah') }}">
                        <button 
                            type="button" 
                            class="btn btn-primary" >
                            <i class="fa fa-lg fa-plus"></i>
                            Tambah
                        </button>
                    </a> -->
                </div>
            </div>
            
        </div>
        <div class="table-responsive">
            <!-- Projects table -->
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
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($penjualan as $tr)
                        <tr>
                            <th>
                                {{ $i++ }}
                            </th>
                            <td>
                                {{ $tr->kode_transaksi }}
                            </td>
                            <td>
                                {{ $tr->tanggal_penjualan }}
                            </td>
                            <td>
                                {{ $tr->nama_barang }}
                            </td>
                            <td>
                                {{ $tr->satuan }}
                            </td>
                            <td>
                                {{ $tr->jumlah_barang }}
                            </td>
                            <td>
                                {{ $tr->harga_barang }}
                            </td>
                            <td>
                                {{ $tr->total_biaya }}
                            </td>
                            <td>
                                <a 
                                    href="{{ route('penjualan-remove') }}" 
                                    onclick="
                                        event.preventDefault();
                                        document.getElementById('hapus-penjualan-{{ $tr->id }}').submit();">
                                    <button class="btn btn-danger">
                                        Hapus
                                    </button>
                                </a>

                                <form 
                                    id="hapus-penjualan-{{ $tr->id }}" 
                                    action="{{ route('penjualan-remove') }}" 
                                    method="POST" 
                                    style="display: none;">
                                    @csrf
                                    <input 
                                        type="hidden" 
                                        name="id" 
                                        value="{{ $tr->id }}">
                                </form>

                                <!-- <button 
                                    onclick="openEditForm({{ $tr->id }})" 
                                    class="btn btn-success">
                                    Ubah
                                </button> -->

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
        <div class="col col-8" style="padding-top: 15px">
            {{ $penjualan->links() }}
        </div>
    </div>

    <!-- Modal -->
    <div 
        class="modal fade" 
        id="createModal" 
        tabindex="-1" 
        role="dialog" 
        aria-labelledby="createModalLabel" 
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <form method="post" action="{{ route('penjualan-push') }}" autocomplete="off">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">
                            Buat Penjualan Baru
                        </h5>
                        <button 
                            type="button" 
                            class="close" 
                            onclick="openCreateForm()" >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group{{ $errors->has('idbarang') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="idbarang">{{ __('Pilih Barang *') }}</label>
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

                        <div class="row mb-2">

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
                            </div>
                            <div class="col-sm">
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

                        </div>

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

                        <div class="form-group{{ $errors->has('harga_barang') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="harga_barang">{{ __('Harga Barang') }}</label>
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
                            <label class="form-control-label" for="total_biaya">{{ __('Total Biaya') }}</label>
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
                    <div class="modal-footer">
                        <button 
                            type="button" 
                            class="btn btn-secondary" 
                            onclick="openCreateForm()" >Tutup</button>
                        <button 
                            type="submit" 
                            class="btn btn-primary">Simpan Penjualan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div 
        class="modal fade" 
        id="editModal" 
        tabindex="-1" 
        role="dialog" 
        aria-labelledby="editModalLabel" 
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="post" action="{{ route('penjualan-put') }}" autocomplete="off">
                    @csrf

                    <input type="hidden" name="id">

                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">
                            Ubah Data Penjualan
                        </h5>
                        <button 
                            type="button" 
                            class="close"
                            onclick="openEditForm()" >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group{{ $errors->has('idbarang') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="ubah_idbarang">{{ __('Pilih Barang') }}</label>
                            <select 
                                name="idbarang" 
                                id="ubah_idbarang" 
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

                        <div class="form-group{{ $errors->has('jumlah_barang') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="ubah_jumlah_barang">{{ __('Jumlah barang') }}</label>
                            <input 
                                type="number" 
                                name="jumlah_barang" 
                                id="ubah_jumlah_barang" 
                                class="form-control form-control-alternative{{ $errors->has('jumlah_barang') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('10') }}"
                                min="0"  
                                required>
                                @if ($errors->has('jumlah_barang'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('jumlah_barang') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('harga_barang') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="ubah_harga_barang">{{ __('Harga Barang') }}</label>
                            <input 
                                type="number" 
                                name="harga_barang" 
                                id="ubah_harga_barang" 
                                class="form-control form-control-alternative{{ $errors->has('harga_barang') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('10000') }}"
                                required>
                                @if ($errors->has('harga_barang'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('harga_barang') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('total_biaya') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="ubah_total_biaya">{{ __('Total Biaya') }}</label>
                            <input 
                                type="number" 
                                name="total_biaya" 
                                id="ubah_total_biaya" 
                                class="form-control form-control-alternative{{ $errors->has('total_biaya') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('10000') }}"
                                required>
                                @if ($errors->has('total_biaya'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('total_biaya') }}</strong>
                                    </span>
                                @endif
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button 
                            type="button" 
                            class="btn btn-secondary"
                            onclick="openEditForm()" >Tutup</button>
                        <button 
                            type="submit" 
                            class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        
        var clNow = "modal fade";
        var clOpen = "modal fade show";

        function openEditForm(id = 0) {

            var tr = $('#editModal').attr('class');
            var route = '{{ url("barang/byid/") }}' + '/' + id;

            if (tr == clNow) {

                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(data) {
                    $('#editModal').attr('class', clOpen).show();
                    $('#ubah_id').val(data[0].id);

                    console.log(data);
                })
                .fail(function(e) {
                    console.log("error " + e);
                })
                .always(function() {
                    console.log("complete");
                });
                

            } else {
                $('#editModal').attr('class', clNow).hide();
            }

        }

        function openCreateForm() {
            var tr = $('#createModal').attr('class');

            if (tr == clNow) {
                $('#createModal').attr('class', clOpen).show();
            } else {
                $('#createModal').attr('class', clNow).hide();
            }
        }

        $(document).ready(function() {
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
                    })
                    .done(function(data) {
                        var total = data.harga_barang * jumlah_barang;

                        console.log(data.harga_barang);
                        $('#harga_barang').val(data.harga_barang);
                        $('#stok_barang').val(data.stok_barang);
                        $('#total_biaya').val(total);
                    })
                    .fail(function(data) {
                        console.log(data);
                    })
                    .always(function() {
                        console.log("complete");
                    });
                } else {
                    $('#harga_barang').val('0');
                    $('#stok_barang').val('0');
                    $('#total_biaya').val('0');
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

        });
    </script>

@endsection

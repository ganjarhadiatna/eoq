@extends('layouts.app')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-barang-center mb-2">
                <div class="col-sm">
                    <h3 class="mb-0">Daftar Barang</h3>
                </div>
                <div class="col-3 form-inline text-right">
                    <form action="#" class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lg fa-search"></i>
                                </span>
                            </div>
                            <input class="form-control" placeholder="Cari barang" type="text">
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
                    <!-- <a href="{{ route('barang-tambah') }}">
                        <button type="button" class="btn btn-primary" >
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
                        <th scope="col">Barang</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Biaya Penyimpanan</th>
                        <th scope="col">Tanggal Kadaluarsa</th>
                        <th scope="col">Supplier</th>
                        <th scope="col">Diskon</th>
                        <th scope="col" width="200">#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($barang as $etl)
                        <tr>
                            <th>
                                {{ $i++ }}
                            </th>
                            <td>
                                {{ $etl->nama_barang }}
                            </td>
                            <td>
                                @if ($etl->stok < 10)
                                    <b class="text-red">{{ $etl->stok }}</b>
                                @else
                                    <b class="text-green">{{ $etl->stok }}</b>
                                @endif
                            </td>
                            <td>
                                Rp {{ number_format($etl->harga_barang) }}
                            </td>
                            <td>
                                Rp {{ number_format($etl->biaya_penyimpanan) }}
                            </td>
                            <td>
                                {{ $etl->tanggal_kadaluarsa }}
                            </td>
                            <td>
                                {{ $etl->nama_supplier }}
                            </td>

                            <!-- <td>
                                {{ $etl->kategori }}
                            </td>
                            <td>
                                {{ $etl->etalase }}
                            </td> -->
                            <td>
                                <a href="{{ route('diskon', $etl->id) }}">
                                    <button class="btn btn-white">
                                        {{ $etl->jumlah_diskon.' Diskon' }}
                                    </button>
                                </a>
                            </td>
                            <td>
                                <a 
                                    href="{{ route('barang-remove') }}" 
                                    onclick="
                                        event.preventDefault();
                                        document.getElementById('hapus-barang-{{ $etl->id }}').submit();">
                                    <button class="btn btn-danger">
                                        Hapus
                                    </button>
                                </a>

                                <form 
                                    id="hapus-barang-{{ $etl->id }}" 
                                    action="{{ route('barang-remove') }}" 
                                    method="POST" 
                                    style="display: none;">
                                    @csrf
                                    <input 
                                        type="hidden" 
                                        name="idbarang" 
                                        value="{{ $etl->id }}">
                                </form>

                                <button 
                                    onclick="openEditForm({{ $etl->id }})"
                                    class="btn btn-success">
                                    Ubah
                                </button>

                                <!-- <a href="{{ route('barang-edit', $etl->id) }}">
                                    <button class="btn btn-success">
                                        Ubah
                                    </button>
                                </a> -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col col-8" style="padding-top: 15px">
            {{ $barang->links() }}
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
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px">
            <div class="modal-content">
                <form method="post" action="{{ route('barang-push') }}" autocomplete="off">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">
                            Tambah Barang Baru
                        </h5>
                        <button 
                            onclick="openCreateForm()" 
                            type="button" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('nama_barang') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="nama_barang">{{ __('Nama Barang *') }}</label>
                            <input 
                                type="text" 
                                name="nama_barang" 
                                id="nama_barang" 
                                class="form-control form-control-alternative{{ $errors->has('nama_barang') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Nama barang') }}"  
                                required 
                                autofocus>
                                @if ($errors->has('nama_barang'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nama_barang') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('stok') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="stok">{{ __('Stok *') }}</label>
                            <input 
                                type="number" 
                                name="stok" 
                                id="stok" 
                                class="form-control form-control-alternative{{ $errors->has('stok') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('1 .. 1000') }}"  
                                min="0"
                                max="1000"
                                required >
                                @if ($errors->has('stok'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('stok') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('harga_barang') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="harga_barang">{{ __('Harga *') }}</label>
                            <input 
                                type="number" 
                                name="harga_barang" 
                                id="harga_barang" 
                                class="form-control form-control-alternative{{ $errors->has('harga_barang') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('500000') }}"  
                                min="0"
                                required >
                                @if ($errors->has('harga_barang'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('harga_barang') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <!-- <div class="form-group{{ $errors->has('discount') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="discount">{{ __('Diskon dalam persen (ex: 25)') }}</label>
                            <input 
                                type="number" 
                                name="discount" 
                                id="discount" 
                                class="form-control form-control-alternative{{ $errors->has('discount') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('0 - 100') }}"  
                                min="0"
                                max="100"
                                required >
                                @if ($errors->has('discount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('discount') }}</strong>
                                    </span>
                                @endif
                            
                        </div> -->

                        <!-- <div class="form-group{{ $errors->has('biaya_pemesanan') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="biaya_pemesanan">{{ __('Biaya pemesanan barang *') }}</label>
                            <input 
                                type="number" 
                                name="biaya_pemesanan" 
                                id="biaya_pemesanan" 
                                class="form-control form-control-alternative{{ $errors->has('biaya_pemesanan') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('500000') }}"  
                                min="0"
                                required >
                                @if ($errors->has('biaya_pemesanan'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('biaya_pemesanan') }}</strong>
                                    </span>
                                @endif
                            
                        </div> -->

                        <div class="form-group{{ $errors->has('biaya_penyimpanan') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="biaya_penyimpanan">{{ __('Biaya penyimpanan barang *') }}</label>
                            <input 
                                type="number" 
                                name="biaya_penyimpanan" 
                                id="biaya_penyimpanan" 
                                class="form-control form-control-alternative{{ $errors->has('biaya_penyimpanan') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('500000') }}"  
                                min="0"
                                required >
                                @if ($errors->has('biaya_penyimpanan'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('biaya_penyimpanan') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('tanggal_kadaluarsa') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="tanggal_kadaluarsa">{{ __('Tanggal kadaluarsa *') }}</label>
                            <input 
                                type="date" 
                                name="tanggal_kadaluarsa" 
                                id="tanggal_kadaluarsa" 
                                class="form-control form-control-alternative{{ $errors->has('tanggal_kadaluarsa') ? ' is-invalid' : '' }}" 
                                required >
                                @if ($errors->has('tanggal_kadaluarsa'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tanggal_kadaluarsa') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('idkategori') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="idkategori">{{ __('Pilih Kategori *') }}</label>
                            <select 
                                name="idkategori" 
                                id="idkategori" 
                                class="form-control form-control-alternative{{ $errors->has('idkategori') ? ' is-invalid' : '' }}" 
                                required>
                                @foreach ($kategori as $ctr)
                                    <option value="{{ $ctr->id }}">{{ $ctr->kategori }}</option>
                                @endforeach
                            </select>
                                @if ($errors->has('idkategori'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('idkategori') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('idetalase') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="idetalase">{{ __('Pilih Etalase *') }}</label>
                            <select 
                                name="idetalase" 
                                id="idetalase" 
                                class="form-control form-control-alternative{{ $errors->has('idetalase') ? ' is-invalid' : '' }}" 
                                required>
                                @foreach ($etalase as $etl)
                                    <option value="{{ $etl->id }}">{{ $etl->etalase }}</option>
                                @endforeach
                            </select>
                                @if ($errors->has('idetalase'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('idetalase') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('idsupplier') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="idsupplier">{{ __('Pilih Supplier *') }}</label>
                            <select 
                                name="idsupplier" 
                                id="idsupplier" 
                                class="form-control form-control-alternative{{ $errors->has('idsupplier') ? ' is-invalid' : '' }}" 
                                required>
                                @foreach ($supplier as $sup)
                                    <option value="{{ $sup->id }}">{{ $sup->nama }}</option>
                                @endforeach
                            </select>
                                @if ($errors->has('idsupplier'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('idsupplier') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button 
                            type="button" 
                            class="btn btn-secondary" 
                            onclick="openCreateForm()">Tutup</button>
                        <button 
                            type="submit" 
                            class="btn btn-primary">Simpan barang</button>
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
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px">
            <div class="modal-content">
                <form method="post" action="{{ route('barang-put') }}" autocomplete="off">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">
                            Ubah Barang
                        </h5>
                        <button 
                            onclick="openEditForm()"
                            type="button" 
                            class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        <input type="hidden" name="id" id="ubah_id">

                        <div class="form-group{{ $errors->has('nama_barang') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="nama_barang">{{ __('Nama Barang *') }}</label>
                            <input 
                                type="text" 
                                name="nama_barang" 
                                id="ubah_nama_barang" 
                                class="form-control form-control-alternative{{ $errors->has('nama_barang') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Nama barang') }}"  
                                required 
                                autofocus>
                                @if ($errors->has('nama_barang'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nama_barang') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('stok') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="stok">{{ __('Stok *') }}</label>
                            <input 
                                type="number" 
                                name="stok" 
                                id="ubah_stok" 
                                class="form-control form-control-alternative{{ $errors->has('stok') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('1 .. 1000') }}"  
                                min="0"
                                max="1000"
                                required >
                                @if ($errors->has('stok'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('stok') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('harga_barang') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="harga_barang">{{ __('Harga *') }}</label>
                            <input 
                                type="number" 
                                name="harga_barang" 
                                id="ubah_harga_barang" 
                                class="form-control form-control-alternative{{ $errors->has('harga_barang') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('500000') }}"  
                                min="0"
                                required >
                                @if ($errors->has('harga_barang'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('harga_barang') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <!-- <div class="form-group{{ $errors->has('discount') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="discount">{{ __('Diskon dalam persen (ex: 25)') }}</label>
                            <input 
                                type="number" 
                                name="discount" 
                                id="ubah_discount" 
                                class="form-control form-control-alternative{{ $errors->has('discount') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('0 - 100') }}"  
                                min="0"
                                max="100"
                                required >
                                @if ($errors->has('discount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('discount') }}</strong>
                                    </span>
                                @endif
                            
                        </div> -->

                        <!-- <div class="form-group{{ $errors->has('biaya_pemesanan') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="biaya_pemesanan">{{ __('Biaya pemesanan barang *') }}</label>
                            <input 
                                type="number" 
                                name="biaya_pemesanan" 
                                id="ubah_biaya_pemesanan" 
                                class="form-control form-control-alternative{{ $errors->has('biaya_pemesanan') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('500000') }}"  
                                min="0"
                                required >
                                @if ($errors->has('biaya_pemesanan'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('biaya_pemesanan') }}</strong>
                                    </span>
                                @endif
                            
                        </div> -->

                        <div class="form-group{{ $errors->has('biaya_penyimpanan') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="biaya_penyimpanan">{{ __('Biaya penyimpanan barang *') }}</label>
                            <input 
                                type="number" 
                                name="biaya_penyimpanan" 
                                id="ubah_biaya_penyimpanan" 
                                class="form-control form-control-alternative{{ $errors->has('biaya_penyimpanan') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('500000') }}"  
                                min="0"
                                required >
                                @if ($errors->has('biaya_penyimpanan'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('biaya_penyimpanan') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('tanggal_kadaluarsa') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="tanggal_kadaluarsa">{{ __('Tanggal kadaluarsa *') }}</label>
                            <input 
                                type="date" 
                                name="tanggal_kadaluarsa" 
                                id="ubah_tanggal_kadaluarsa" 
                                class="form-control form-control-alternative{{ $errors->has('tanggal_kadaluarsa') ? ' is-invalid' : '' }}" 
                                required >
                                @if ($errors->has('tanggal_kadaluarsa'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tanggal_kadaluarsa') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('idkategori') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="idkategori">{{ __('Pilih Kategori *') }}</label>
                            <select 
                                name="idkategori" 
                                id="ubah_idkategori" 
                                class="form-control form-control-alternative{{ $errors->has('idkategori') ? ' is-invalid' : '' }}" 
                                required>
                                @foreach ($kategori as $ctr)
                                    <option value="{{ $ctr->id }}">{{ $ctr->kategori }}</option>
                                @endforeach
                            </select>
                                @if ($errors->has('idkategori'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('idkategori') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('idetalase') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="idetalase">{{ __('Pilih Etalase *') }}</label>
                            <select 
                                name="idetalase" 
                                id="ubah_idetalase" 
                                class="form-control form-control-alternative{{ $errors->has('idetalase') ? ' is-invalid' : '' }}" 
                                required>
                                @foreach ($etalase as $etl)
                                    <option value="{{ $etl->id }}">{{ $etl->etalase }}</option>
                                @endforeach
                            </select>
                                @if ($errors->has('idetalase'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('idetalase') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('idsupplier') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="idsupplier">{{ __('Pilih Supplier *') }}</label>
                            <select 
                                name="idsupplier" 
                                id="ubah_idsupplier" 
                                class="form-control form-control-alternative{{ $errors->has('idsupplier') ? ' is-invalid' : '' }}" 
                                required>
                                @foreach ($supplier as $sup)
                                    <option value="{{ $sup->id }}">{{ $sup->nama }}</option>
                                @endforeach
                            </select>
                                @if ($errors->has('idsupplier'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('idsupplier') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button 
                            type="button" 
                            class="btn btn-secondary"
                            onclick="openEditForm()">Tutup</button>
                        <button 
                            type="submit" 
                            class="btn btn-primary">Simpan perubahan</button>
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
                    $('#ubah_nama_barang').val(data[0].nama_barang);
                    $('#ubah_stok').val(data[0].stok);
                    $('#ubah_harga_barang').val(data[0].harga_barang);
                    // $('#ubah_biaya_pemesanan').val(data[0].biaya_pemesanan);
                    $('#ubah_biaya_penyimpanan').val(data[0].biaya_penyimpanan);
                    $('#ubah_tanggal_kadaluarsa').val(data[0].tanggal_kadaluarsa);
                    $('#ubah_idkategori').val(data[0].idkategori);
                    $('#ubah_idetalase').val(data[0].idetalase);
                    $('#ubah_idsupplier').val(data[0].idsupplier);

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
    </script>

@endsection
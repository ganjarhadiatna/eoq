@extends('layouts.app')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center mb-2">
                <div class="col-sm">
                    <h3 class="mb-0">Daftar Suplier</h3>
                </div>
                <div class="col-3 form-inline text-right">
                    <form action="#" class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lg fa-search"></i>
                                </span>
                            </div>
                            <input class="form-control" placeholder="Cari suplier" type="text">
                        </div>
                    </form>
                </div>
                <div class="col-2 text-right">
                    <button 
                        onclick="openCreateForm()" 
                        class="btn btn-primary" >
                        <i class="fa fa-lg fa-plus"></i>
                        Tambah
                    </button>
                    <!-- <a href="{{ route('supplier-tambah') }}">
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
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="100">NO</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">Nomor Telpon</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Leadtime</th>
                        <th scope="col" width="200">#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($supplier as $sp)
                        <tr>
                            <th>
                                {{ $i++ }}
                            </th>
                            <td>
                                {{ $sp->nama }}
                            </td>
                            <td>
                                {{ $sp->email }}
                            </td>
                            <td>
                                {{ $sp->no_telpon }}
                            </td>
                            <td>
                                {{ $sp->alamat }}
                            </td>
                            <td>
                                {{ $sp->leadtime }}
                            </td>
                            <td>
                                <a 
                                    href="{{ route('supplier-remove') }}" 
                                    onclick="
                                        event.preventDefault();
                                        document.getElementById('hapus-supplier-{{ $sp->id }}').submit();">
                                    <button type="" class="btn btn-danger">
                                        Hapus
                                    </button>
                                </a>

                                <form 
                                    id="hapus-supplier-{{ $sp->id }}" 
                                    action="{{ route('supplier-remove') }}" 
                                    method="POST" 
                                    style="display: none;">
                                    @csrf
                                    <input 
                                        type="hidden" 
                                        name="idsuppliers" 
                                        value="{{ $sp->id }}">
                                </form>

                                <button 
                                    onclick="openEditForm({{ $sp->id }})" 
                                    class="btn btn-success">
                                    Ubah
                                </button>

                                <!-- <a href="{{ route('supplier-edit', $sp->id) }}">
                                    <button class="btn btn-success">
                                        Ubah
                                    </button>
                                </a> -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col col-8">
                {{ $supplier->links() }}
            </div>
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
                <form method="post" action="{{ route('supplier-push') }}" autocomplete="off">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">
                            Tambah Suplier Baru
                        </h5>
                        <button 
                            type="button" 
                            class="close" 
                            onclick="openCreateForm()" 
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group{{ $errors->has('nama') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="nama">{{ __('Nama') }}</label>
                            <input 
                                type="text" 
                                name="nama" 
                                id="nama" 
                                class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan nama') }}"  
                                required 
                                autofocus>
                                @if ($errors->has('nama'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="email">{{ __('Email') }}</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan email') }}"  
                                required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('no_telpon') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="no_telpon">{{ __('Nomor Telpon') }}</label>
                            <input 
                                type="text" 
                                name="no_telpon" 
                                id="no_telpon" 
                                class="form-control form-control-alternative{{ $errors->has('no_telpon') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan nomor telpon') }}"  
                                required>
                                @if ($errors->has('no_telpon'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('no_telpon') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('alamat') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="alamat">{{ __('Alamat') }}</label>
                            <input 
                                type="text" 
                                name="alamat" 
                                id="alamat" 
                                class="form-control form-control-alternative{{ $errors->has('alamat') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan alamat') }}"  
                                required>
                                @if ($errors->has('alamat'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('alamat') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('leadtime') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="leadtime">{{ __('Leadtime') }}</label>
                            <input 
                                type="number" 
                                name="leadtime" 
                                id="leadtime" 
                                class="form-control form-control-alternative{{ $errors->has('leadtime') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan leadtime') }}"  
                                required>
                                @if ($errors->has('leadtime'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('leadtime') }}</strong>
                                    </span>
                                @endif
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button 
                            type="button" 
                            class="btn btn-secondary" 
                            onclick="openCreateForm()">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambahkan</button>
                    </div>
                </div>
            </form>
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
                <form 
                    method="post" 
                    action="{{ route('supplier-put') }}" 
                    autocomplete="off">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">
                            Ubah Data Suplier
                        </h5>
                        <button 
                            onclick="openEditForm()" 
                            type="button" 
                            class="close" 
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="ubah_id">
                        <div class="form-group{{ $errors->has('nama') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="ubah_nama">{{ __('Nama') }}</label>
                            <input 
                                type="text" 
                                name="nama" 
                                id="ubah_nama" 
                                class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan nama') }}"  
                                required 
                                autofocus>
                                @if ($errors->has('nama'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="ubah_email">{{ __('Email') }}</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="ubah_email" 
                                class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan email') }}"  
                                required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('no_telpon') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="ubah_no_telpon">{{ __('Nomor Telpon') }}</label>
                            <input 
                                type="text" 
                                name="no_telpon" 
                                id="ubah_no_telpon" 
                                class="form-control form-control-alternative{{ $errors->has('no_telpon') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan nomor telpon') }}"  
                                required>
                                @if ($errors->has('no_telpon'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('no_telpon') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('alamat') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="alamat">{{ __('Alamat') }}</label>
                            <input 
                                type="alamat" 
                                name="alamat" 
                                id="ubah_alamat" 
                                class="form-control form-control-alternative{{ $errors->has('alamat') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan alamat') }}"  
                                required>
                                @if ($errors->has('alamat'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('alamat') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('leadtime') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="leadtime">{{ __('Leadtime') }}</label>
                            <input 
                                type="number" 
                                name="leadtime" 
                                id="ubah_leadtime" 
                                class="form-control form-control-alternative{{ $errors->has('leadtime') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan leadtime') }}"  
                                required>
                                @if ($errors->has('leadtime'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('leadtime') }}</strong>
                                    </span>
                                @endif
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button 
                            onclick="openEditForm()" 
                            type="button" 
                            class="btn btn-secondary" 
                            data-dismiss="modal">Tutup</button>
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
            var route = '{{ url("supplier/byid/") }}' + '/' + id;

            if (tr == clNow) {

                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(data) {
                    $('#editModal').attr('class', clOpen).show();
                    $('#ubah_id').val(data[0].id);
                    $('#ubah_nama').val(data[0].nama);
                    $('#ubah_email').val(data[0].email);
                    $('#ubah_no_telpon').val(data[0].no_telpon);
                    $('#ubah_alamat').val(data[0].alamat);
                    $('#ubah_leadtime').val(data[0].leadtime);

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

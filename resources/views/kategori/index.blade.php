<?php use App\Barang; ?>

@extends('layouts.app')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center mb-2">
                <div class="col-sm">
                    <h3 class="mb-0">Daftar Kategori</h3>
                </div>
                <div class="col-3 form-inline text-right">
                    <form action="#" class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lg fa-search"></i>
                                </span>
                            </div>
                            <input class="form-control" placeholder="Cari kategori" type="text">
                        </div>
                    </form>
                </div>
                <div class="col-2 text-right">
                    <button 
                        type="button" 
                        class="btn btn-primary"
                        onclick="openCreateForm()">
                        <i class="fa fa-lg fa-plus"></i>
                        Tambah
                    </button>
                    <!-- <a href="{{ route('kategori-tambah') }}">
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
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="100">NO</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Jumlah Barang</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col" width="200">#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($kategori as $ctr)
                        <tr>
                            <th>
                                {{ $i++ }}
                            </th>
                            <td>
                                {{ $ctr->kategori }}
                            </td>
                            <td>
                                {{ Barang::GetTotalByKategori($ctr->id) }} Barang
                            </td>
                            <td>
                                {{ $ctr->created_at }}
                            </td>
                            <td>
                                <a 
                                    href="{{ route('kategori-remove') }}" 
                                    onclick="
                                        event.preventDefault();
                                        document.getElementById('hapus-kategori-{{ $ctr->id }}').submit();">
                                    <button class="btn btn-danger">
                                        Hapus
                                    </button>
                                </a>

                                <form 
                                    id="hapus-kategori-{{ $ctr->id }}" 
                                    action="{{ route('kategori-remove') }}" 
                                    method="POST" 
                                    style="display: none;">
                                    @csrf
                                    <input 
                                        type="hidden" 
                                        name="id" 
                                        value="{{ $ctr->id }}">
                                </form>

                                <button 
                                    onclick="openEditForm({{ $ctr->id }})" 
                                    class="btn btn-success">
                                    Ubah
                                </button>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col col-8" style="padding-top: 15px">
            {{ $kategori->links() }}
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
                <form 
                    method="post" 
                    action="{{ route('kategori-push') }}"
                    autocomplete="off" 
                    id="form-create">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">
                            Buat Kategori Baru
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
                        <div class="form-group{{ $errors->has('kategori') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-kategori">{{ __('Kategori') }}</label>
                            <input 
                                type="text" 
                                name="kategori" 
                                id="input-kategori" 
                                class="form-control form-control-alternative{{ $errors->has('kategori') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan kategori') }}"  
                                required 
                                autofocus>

                            @if ($errors->has('kategori'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('kategori') }}</strong>
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
                            class="btn btn-primary">Simpan Kategori</button>
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
                <form 
                    method="post" 
                    action="{{ route('kategori-put') }}"
                    autocomplete="off" 
                    id="form-edit">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">
                            Ubah Kategori
                        </h5>
                        <button 
                            type="button" 
                            class="close" 
                            onclick="openEditForm()" 
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        <input 
                            type="hidden" 
                            name="id" 
                            id="ubah_id">

                        <div class="form-group{{ $errors->has('kategori') ? ' has-danger' : '' }}">
                            
                            <label class="form-control-label" for="input-kategori">{{ __('Kategori') }}</label>

                            <input 
                                type="text" 
                                name="kategori" 
                                id="ubah_kategori" 
                                class="form-control form-control-alternative{{ $errors->has('kategori') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan kategori') }}"  
                                required 
                                autofocus>

                            @if ($errors->has('kategori'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('kategori') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button 
                            type="button" 
                            class="btn btn-secondary" 
                            onclick="openEditForm()"
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
            var route = '{{ url("kategori/byid/") }}' + '/' + id;

            if (tr == clNow) {

                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                        opLoading();
                    }
                })
                .done(function(data) {
                    $('#editModal').attr('class', clOpen).show();
                    $('#ubah_id').val(data[0].id);
                    $('#ubah_kategori').val(data[0].kategori);

                    // console.log(data);
                    clLoading();
                })
                .fail(function(e) {
                    console.log("error " + e);
                    clLoading();
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
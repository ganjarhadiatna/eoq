@extends('layouts.app')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center mb-2">
                <div class="col-sm">
                    <h3 class="mb-0">Daftar Etalase</h3>
                </div>
                <div class="col-3 form-inline text-right">
                    <form action="#" class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lg fa-search"></i>
                                </span>
                            </div>
                            <input class="form-control" placeholder="Cari etalase" type="text">
                        </div>
                    </form>
                </div>
                <div class="col-2 text-right">
                    <button 
                        type="button" 
                        class="btn btn-primary" 
                        data-toggle="modal" 
                        onclick="openCreateForm()">
                        <i class="fa fa-lg fa-plus"></i>
                        Tambah
                    </button>
                    <!-- <a href="{{ route('etalase-tambah') }}">
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
                        <th scope="col">Etalase</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col" width="200">#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($etalase as $etl)
                        <tr>
                            <th>
                                {{ $i++ }}
                            </th>
                            <td>
                                {{ $etl->etalase }}
                            </td>
                            <td>
                                {{ $etl->created_at }}
                            </td>
                            <td>
                                <a 
                                    href="{{ route('etalase-remove') }}" 
                                    onclick="
                                        event.preventDefault();
                                        document.getElementById('hapus-etalase-{{ $etl->id }}').submit();">
                                    <button class="btn btn-danger">
                                        Hapus
                                    </button>
                                </a>

                                <form 
                                    id="hapus-etalase-{{ $etl->id }}" 
                                    action="{{ route('etalase-remove') }}" 
                                    method="POST" 
                                    style="display: none;">
                                    @csrf
                                    <input 
                                        type="hidden" 
                                        name="id" 
                                        value="{{ $etl->id }}">
                                </form>

                                <button 
                                    class="btn btn-success" 
                                    onclick="openEditForm({{ $etl->id }})" >
                                    Ubah
                                </button>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col col-8" style="padding-top: 15px">
            {{ $etalase->links() }}
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
                    action="{{ route('etalase-push') }}"
                    autocomplete="off" 
                    id="form-create">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">
                            Buat etalase Baru
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
                        <div class="form-group{{ $errors->has('etalase') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-etalase">{{ __('Etalase') }}</label>
                            <input 
                                type="text" 
                                name="etalase" 
                                id="input-etalase" 
                                class="form-control form-control-alternative{{ $errors->has('etalase') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan etalase') }}"  
                                required 
                                autofocus>

                            @if ($errors->has('etalase'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('etalase') }}</strong>
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
                            class="btn btn-primary">Simpan etalase</button>
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
                    action="{{ route('etalase-put') }}"
                    autocomplete="off" 
                    id="form-create">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">
                            Ubah Etalase
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

                        <div class="form-group{{ $errors->has('etalase') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="ubah-etalase">{{ __('Etalase') }}</label>
                            <input 
                                type="text" 
                                name="etalase" 
                                id="ubah_etalase" 
                                class="form-control form-control-alternative{{ $errors->has('etalase') ? ' is-invalid' : '' }}" 
                                placeholder="{{ __('Masukan etalase') }}"  
                                required 
                                autofocus>

                            @if ($errors->has('etalase'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('etalase') }}</strong>
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
            var route = '{{ url("etalase/byid/") }}' + '/' + id;

            if (tr == clNow) {

                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(data) {
                    $('#editModal').attr('class', clOpen).show();
                    $('#ubah_id').val(data[0].id);
                    $('#ubah_etalase').val(data[0].etalase);

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
@extends('layouts.app')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center mb-2">
                <div class="col-sm">
                    <h3 class="mb-0">Daftar Pembelian</h3>
                </div>
                <div class="col-3 form-inline text-right">
                    <form action="#" class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lg fa-search"></i>
                                </span>
                            </div>
                            <input class="form-control" placeholder="Cari pesanan" type="text">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <!-- Projects table -->
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="100">NO</th>
                        <!-- <th scope="col">Kode Transaksi</th> -->
                        <th scope="col">Nama Supplier</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Harga Barang</th>
                        <th scope="col">Biaya Penyimpanan</th>
                        <th scope="col">Diskon</th>
                        <th scope="col">Jumlah Pembelian</th>
                        <th scope="col">Total Biaya</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tanggal Pembelian</th>
                        <th scope="col" width="200">#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($pembelian as $pb)
                    	<tr>
                    		<td>{{ $i++ }}</td>
                            <td>{{ $pb->nama_supplier }}</td>
                            <td>{{ $pb->nama_barang }}</td>
                            <td><b>Rp. {{ number_format($pb->harga_barang) }}</b></td>
                            <td><b>Rp. {{ number_format($pb->biaya_penyimpanan) }}</b></td>
                            <td>{{ ($pb->diskon * 100).'%' }}</td>
                            <td>{{ $pb->jumlah_pembelian.' '.$pb->satuan_barang }}</td>
                            <td>
                                <b class="text-green">
                                    Rp.
                                    <?php
                                        $total_biaya = (($pb->jumlah_pembelian * $pb->harga_barang) + $pb->biaya_penyimpanan);
                                        $diskon = $total_biaya * $pb->diskon;
                                        $jumlah = $total_biaya - $diskon;
                                        echo number_format($jumlah);
                                    ?>
                                </b>
                            </td>
                            <td>
                                @if ($pb->status == 'aktif')
                                    <b class="text-red" style="text-transform: uppercase;">{{ $pb->status }}</b>
                                @else
                                    <b class="text-green" style="text-transform: uppercase;">{{ $pb->status }}</b>
                                @endif
                            </td>
                            <td>{{ $pb->tanggal_pembelian }}</td>
                            <td>
                                @if ($pb->status == 'aktif')
                                    <a 
                                        href="{{ route('pembelian-remove') }}" 
                                        onclick="
                                            event.preventDefault();
                                            document.getElementById('hapus-pembelian-{{ $pb->id }}').submit();">
                                        <button class="btn btn-danger">
                                            Hapus
                                        </button>
                                    </a>

                                    <form 
                                        id="hapus-pembelian-{{ $pb->id }}" 
                                        action="{{ route('pembelian-remove') }}" 
                                        method="POST" 
                                        style="display: none;">
                                        @csrf
                                        <input 
                                            type="hidden" 
                                            name="id" 
                                            value="{{ $pb->id }}">
                                    </form>

                                    <a 
                                        href="{{ route('pembelian-done') }}" 
                                        onclick="
                                            event.preventDefault();
                                            document.getElementById('buat-pembelian-{{ $pb->id }}').submit();">
                                        <button class="btn btn-primary">
                                            Barang Sampai
                                        </button>
                                    </a>

                                    <form 
                                        id="buat-pembelian-{{ $pb->id }}" 
                                        action="{{ route('pembelian-done') }}" 
                                        method="POST" 
                                        style="display: none;">
                                        @csrf
                                        <input 
                                            type="hidden" 
                                            name="id" 
                                            value="{{ $pb->id }}">
                                    </form>
                                @else
                                    <a href="{{ route('barang') }}">
                                        <button class="btn btn-success">
                                            Lihat Barang
                                        </button>
                                    </a>
                                @endif
                            </td>
                    	</tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col col-8" style="padding-top: 15px">
            {{ $pembelian->links() }}
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
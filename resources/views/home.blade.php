@extends('layouts.app')

@section('profile')

    <div class="container-fluid">
        <div class="row">
        	<div class="col-xl-6">
        		<div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Transaksi Penjualan</h5>
                                <span class="h2 font-weight-bold mb-0">{{ $jumlah_penjualan }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                            </div>
                        </div>         
                    </div>
                </div>
        	</div>
        	<div class="col-xl-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Barang Yang Sudah Sampai</h5>
                                <span class="h2 font-weight-bold mb-0">{{ $jumlah_barang }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-xl-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Barang Dalam Pemesanan</h5>
                                <span class="h2 font-weight-bold mb-0">{{ $jumlah_pesanan }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                    <i class="fas fa-th"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Barang Akan Kadaluarsa</h5>
                                <span class="h2 font-weight-bold mb-0">{{ $jumlah_barang_kadaluarsa }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-green text-white rounded-circle shadow">
                                    <i class="fas fa-th"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="row mt-5">
            <div class="col">
            	<div class="card shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Performance</h6>
                                <h2 class="mb-0">Penjualan Perbulan</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <!-- Chart wrapper -->
                            <canvas id="myChart" class="chart-canvas" height="220"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Performance</h6>
                                <h2 class="mb-0">Pembelian Perbulan</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <!-- Chart wrapper -->
                            <canvas id="myChart2" class="chart-canvas" height="220"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="container-fluid">

        <div class="row mt-5">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Barang Akan Kadaluarsa</h3>
                            </div>
                            <div class="col text-right">
                                <!-- <a href="#!" class="btn btn-sm btn-primary">See all</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Barang</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Terjual</th>
                                    <th scope="col">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($barangKedaluarsa as $index => $data)
                                <tr>
                                    <th scope="row">
                                        {{ $data->nama_barang }}
                                    </th>
                                    <td>
                                        {{ $data->harga_barang }}
                                    </td>
                                    <td>
                                        {{ $data->getBarangTerjual() }}
                                    </td>
                                    <td>
                                        {{ $data->tanggal_kadaluarsa }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Daftar Rekomendasi Pemesanan Barang</h3>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Barang</th>
                                    <th scope="col">EOQ</th>
                                    <th scope="col">Total Cost</th>
                                    <th scope="col">Reorder Point</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pemesanan as $index => $data)
                                <tr>
                                    <th scope="row">
                                        {{ $data->getNamaBarang()->first()->nama_barang }}
                                    </th>
                                    <td>
                                        {{ $data->jumlah_unit }}
                                    </td>
                                    <td>
                                        {{ $data->total_cost }}
                                    </td>
                                    <td>
                                        {{ $data->reorder_point }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="chartPenjualan" value="{{ json_encode($chartPenjualan) }}" />
        <input type="hidden" name="chartPembelian" value="{{ json_encode($chartPembelian) }}" />
    </div>

    <script>
    var ctx = document.getElementById('myChart');
    let data = $('input[name="chartPenjualan"]').val();
    data = JSON.parse(data);

    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                showLines: true,
                label: '# of Votes',
                data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    stacked: true,
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    </script>

    <script>
    var ctx = document.getElementById('myChart2');
    data = $('input[name="chartPembelian"]').val();
    data = JSON.parse(data);

    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                showLines: true,
                label: '# of Votes',
                data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    stacked: true,
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    </script>

@endsection
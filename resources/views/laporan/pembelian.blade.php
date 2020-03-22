<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <style>
        * {
            padding: 0;
            margin: 0;
            border: 0;
            outline: none;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        h1, h2, h3 {
            color: rgba(0,0,0,0.84);
            line-height: 1.5;
        }
        h4 {
            line-height: 1.5;
            color: rgba(0,0,0,0.84);
            font-size: 14pt;
            margin: 15px 0;
        }

        p {
            line-height: 1.5;
            color: rgba(0,0,0,0.64);
            font-size: 10pt;
        }

        .place-image {
            position: relative;
            width: 100%;
            padding-top: 15px;
            /* display: flex; */
        }
        .place-image .image {
            position: relative;
            display: inline-block;
            width: 250px;
            border-radius: 10px;
            margin: 15px;
        }

        table {
            width: 100%;
        }

        table {
            position: relative;
            width: 100%;
            overflow: hidden;
            border-collapse: collapse;
            margin-bottom: 20px;
            margin-left: 30px;
            margin-right: 30px;
            margin-top: 30px;
            border: 1px rgba(0,0,0,0.1) solid;
            font-size: 10pt;
        }
        table thead {
            position: relative;
            width: 100%;
            margin-top: 30px;
            background-color: #f3f3f3;
            color: rgba(0,0,0,0.64);
            border: 1px rgba(0,0,0,0.1) solid;
            font-size: 10pt;
        }
        table thead tr {
            position: relative;
            margin-top: 30px;
            border: 1px rgba(0,0,0,0.1) solid;
        }
        table thead tr th {
            position: relative;
            padding: 15px;
            margin-top: 30px;
            font-size: 10pt;
            font-weight: 600;
            text-transform: collapse;
            text-align: left;
            border: 1px rgba(0,0,0,0.1) solid;
        }
        table tbody {
            position: relative;
            margin-top: 30px;
            font-size: 10pt;
        }
        /* table tbody tr:hover {
            background-color: #f5f5f5;
        } */
        table tbody tr td {
            position: relative;
            padding: 15px;
            font-size: 10pt;
            font-weight: 500;
            color: rgba(0,0,0,0.84);
            border: 1px rgba(0,0,0,0.1) solid;
        }

        ul {
            position: relative;
            line-height: 1.5;
        }
        ul li {
            position: relative;
            width: 90%;
            margin: auto;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .card {
            position: relative;
            width: 80%;
            margin: auto;
        }

        .card-header {
            position: relative;
            width: 50%;
            margin: 15px -2px;
            display: inline-block;
            vertical-align: top;
        }
        .logo {
            position: relative;
            top: 15px;
        }

        .card-body {
            margin: 15px 0;
        }

        .next-page {
            page-break-after: always;
        }

    </style>
</head>
<body class="container">
        <div class="card-body next-page">
            <h2 align="center">Laporan Pembelian</h2>
            <h3 align="center">Apotek Muthia</h3>
            <h4 align="center">Permata Hijau Nomor A-79 RT 04 / RW 15</h4>
            <table class="table table-bordered">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Kode Transaksi</th>
                  <th>Nama Supplier</th>
                  <th>Nama Barang</th>
                  <th>Satuan Barang</th>
                  <th>Tanggal</th>
                  <th>Jumlah</th>
                  <th>Biaya Penyimpanan</th>
                  <th>Harga Barang</th>
                  <th>Total Biaya</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                <?php $jumlah = 0; ?>
                <?php $total = 0; ?>
                <?php $penyimpanan = 0; ?>
                <?php $biaya = 0; ?>
                @foreach($pembelian as $pj)
                  <tr>
                    <td>
                      {{ $i }}
                    </td>
                    <td>
                      {{ $pj->kode_transaksi }}
                    </td>
                    <td>
                      {{ $pj->nama_supplier }}
                    </td>
                    <td>
                      {{ $pj->nama_barang }}
                    </td>
                    <td>
                      {{ $pj->satuan_barang }}
                    </td>
                    <td>
                      {{ $pj->tanggal_pembelian }}
                    </td>
                    <td>
                      {{ $pj->jumlah_pembelian }}
                    </td>
                    <td>
                      Rp. {{ number_format($pj->biaya_penyimpanan) }}
                    </td>
                    <td>
                      Rp. {{ number_format($pj->harga_barang) }}
                    </td>
                    <td>
                        <?php $biaya = ($pj->harga_barang * $pj->jumlah_pembelian) + $pj->biaya_penyimpanan; ?>
                        Rp. {{ number_format($biaya) }}
                    </td>
                    </tr>
                  <?php $i++ ?>
                  <?php $jumlah += $pj->jumlah_pembelian; ?>
                  <?php $total += $biaya; ?>
                  <?php $penyimpanan += $pj->biaya_penyimpanan; ?>
                @endforeach
                    
                </tbody>
                <tbody>
                    <tr>
                        <td colspan="9">
                            <b>Total Keseluruhan</b>
                        </td>
                        <td>
                            <b>Rp. {{ number_format($total) }}</b>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


    </div>
  
</body>
</html>
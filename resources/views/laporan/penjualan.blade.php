<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>Laporan Penjualan</h1>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>No</th>
          <th>Kode Transaksi</th>
          <th>Nama Barang</th>
          <th>Jumlah Barang</th>
          <th>Harga Barang</th>
          <th>Total Biaya</th>
          <th>Satuan</th>
          <th>Tanggal Penjualan</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach($penjualan as $pj)
          <tr>
            <td>
              {{ $i }}
            </td>
            <td>
              {{ $pj->kode_transaksi }}
            </td>
            <td>
              {{ $pj->nama_barang }}
            </td>
            <td>
              {{ $pj->jumlah_barang }}
            </td>
            <td>
              {{ $pj->harga_barang }}
            </td>
            <td>
              {{ $pj->total_biaya }}
            </td>
            <td>
              {{ $pj->satuan }}
            </td>
            <td>
              {{ $pj->tanggal_penjualan }}
            </td>
          </tr>
          <?php $i++ ?>
        @endforeach
      </tbody>
    </table>
  </body>
</html>
<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" 
    id="sidenav-main">
    <div class="container-fluids">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="pt-0" href="{{ route('home') }}">
            <img src="{{ asset('/img/brand/blue.png') }}" class="navbar-brand-img" alt="...">
        </a>

        <div 
            class="collapse navbar-collapse" 
            id="sidenav-collapse-main">

            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('/img/brand/blue.png') }}">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="fa fa-lg fa-home text-primary"></i>
                        Dashboard
                    </a>
                </li>
            </ul>

            <hr class="my-3">
            <h6 class="navbar-heading text-muted">Master Data</h6>
            
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('kategori') }}">
                        <i class="fa fa-lg fa-th-list text-green"></i>
                        Kategori
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('etalase') }}">
                        <i class="fa fa-lg fa-th-large text-info"></i>
                        Etalase
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('supplier') }}">
                        <i class="fa fa-lg fa-users text-red"></i>
                        Supplier
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('barang') }}">
                        <i class="fa fa-lg fa-star text-blue"></i>
                        Barang
                    </a>
                </li>
            </ul>

            <hr class="my-3">
            <h6 class="navbar-heading text-muted">Transaksi</h6>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pesanan-multiitem') }}">
                        <i class="fa fa-lg fa-chart-pie text-info"></i>
                        Metode EOQ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pesanan-item') }}">
                        <i class="fa fa-lg fa-calendar text-green"></i>
                        Pemesanan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pembelian') }}">
                        <i class="fa fa-lg fa-shopping-bag text-orange"></i>
                        Pembelian
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('penjualan') }}">
                        <i class="fa fa-lg fa-edit text-default"></i>
                        Penjualan
                    </a>
                </li>
            </ul>

            <hr class="my-3">
            <h6 class="navbar-heading text-muted">Lainnya</h6>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('batasan-modal') }}">
                        <i class="fa fa-lg fa-building text-green"></i>
                        Batasan Modal
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('batasan-gudang') }}">
                        <i class="fa fa-lg fa-building text-info"></i>
                        Batasan Gudang
                    </a>
                </li>
            </ul>

            <hr class="my-3">
            <h6 class="navbar-heading text-muted">Laporan</h6>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('laporan-pemesanan') }}">
                        <i class="fa fa-lg fa-print text-info"></i>
                        Laporan Pemesanan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('laporan-pembelian') }}">
                        <i class="fa fa-lg fa-print text-green"></i>
                        Laporan Pembelian
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('laporan-penjualan') }}">
                        <i class="fa fa-lg fa-print text-info"></i>
                        Laporan Penjualan
                    </a>
                </li>
            </ul>

            <hr class="my-3">
        
        </div>

    </div>
</nav>
<?php
 use App\Pemesanan;
?>

@extends('layouts.app')

@section('content')
	<div class="card bg-secondary shadow">

        <div class="card-header border-0">
            <h3 class="mb-0">Manajemen Stok</h3>
            <div class="nav-wrapper">
                <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">
                            EOQ Sederhana
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">
                            Back Order
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-5-tab" data-toggle="tab" href="#tabs-icons-text-5" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false">
                            Special Order
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-6-tab" data-toggle="tab" href="#tabs-icons-text-6" role="tab" aria-controls="tabs-icons-text-4" aria-selected="false">
                            Price Increases
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-7-tab" data-toggle="tab" href="#tabs-icons-text-7" role="tab" aria-controls="tabs-icons-text-4" aria-selected="false">
                            Quantity Discount
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- <div class="card-header border-0">
            <div class="row align-items-center mb-2">
                <div class="col-sm">
                    <h3 class="mb-0">EOQ Sederhana</h3>
                </div>
                <div class="col-2 text-right">
                    
                </div>
            </div>
        </div> -->

        <div class="card-body">
            <div class="tab-content" id="myTabContent">

                <!-- EOQ -->
                <div 
                    class="tab-pane fade show active" 
                    id="tabs-icons-text-1" 
                    role="tabpanel" 
                    aria-labelledby="tabs-icons-text-1-tab">
                    @include('pesanan.multiitem.eoq')
                </div>
                <div 
                    class="tab-pane fade show" 
                    id="tabs-icons-text-2" 
                    role="tabpanel" 
                    aria-labelledby="tabs-icons-text-2-tab">
                    @include('pesanan.multiitem.backorder')
                </div>
                <div 
                    class="tab-pane fade show" 
                    id="tabs-icons-text-5" 
                    role="tabpanel" 
                    aria-labelledby="tabs-icons-text-5-tab">
                    @include('pesanan.singleitem.specialPrice')
                </div>
                <div 
                    class="tab-pane fade show" 
                    id="tabs-icons-text-6" 
                    role="tabpanel" 
                    aria-labelledby="tabs-icons-text-6-tab">
                    @include('pesanan.singleitem.increasePrice')
                </div>
                <div 
                    class="tab-pane fade show" 
                    id="tabs-icons-text-7" 
                    role="tabpanel" 
                    aria-labelledby="tabs-icons-text-7-tab">
                    @include('pesanan.singleitem.quantityDiscount')
                </div>


            </div>
        </div>
    </div>

@endsection
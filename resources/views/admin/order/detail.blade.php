@extends('layouts.app')
@section('title', 'Order Transaction Detail')
@section('custom_css')

<link rel="stylesheet" href="{{ asset('assets/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}">

@endsection
@section('content')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Order Detail #{{ $transactions->id }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Order Detail</li>
                    </ol>
                </nav>
            </div>
            <div class="col-3">
                <div class="text-center mb-n5">
                    <img src="{{ asset('assets/images/breadcrumb/ChatBc.png') }}" alt="modernize-img" class="img-fluid mb-n4">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">Order Detail</h4>
    </div>
    <div class="card-body pt-4 py-2  ">
        <div class="table-responsive border rounded-1">
            <table id="test_config" class="table text-nowrap align-middle mb-0 px-0">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Product</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Brand</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Product Price</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Status</h6>
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactionsItemsData as $transaction)
                    @php
                    $totalAmount = collect($transactionsItemsData)->sum(fn($item) => $item['quantity'] * $item['product_price']);
                    @endphp
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('assets/images' . ($transaction['product_image'] ? $transaction['product_image'] : '/products/default.jpg'))  }}" class="rounded-circle" width="40" height="40">
                                <div class="ms-3">
                                    <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="{{ route('product_detail', ['slug' => $transaction['slug']])}}">
                                        <h6 class="fs-4 fw-semibold mb-0">{{ $transaction['product_name'] }}</h6>

                                    </a>

                                    <span class="fw-normal">Quantity: {{ $transaction['quantity'] }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <h6 class="fw-semibold mb-0">{{ $transaction['product_brand'] }}</h6>
                        </td>
                        <td>
                            <h6 class="fw-semibold mb-0">IDR {{ $transaction['product_price'] }}</h6>
                        </td>
                        <td>
                            @if($transaction['status'] == 'pending')
                            <span class="badge bg-primary-subtle text-primary d-inline-flex align-items-center gap-1">
                                <i class="ti ti-clock-hour-4 fs-3"></i>pending
                            </span>
                            @elseif ($transaction['status'] == 'success')
                            <span class="badge bg-success-subtle text-success d-inline-flex align-items-center gap-1">
                                <i class="ti ti-check fs-4"></i>success
                            </span>
                            @else
                            <span class="badge bg-danger-subtle text-danger d-inline-flex align-items-center gap-1">
                                <i class="ti ti-check fs-4"></i>unknown
                            </span>
                            @endif
                        </td>
                    </tr>

                    @endforeach

                </tbody>
            </table>
        </div>

        <div class="card-body pb-0 ">
            <div class="d-flex mb-3 align-items-center">
                <h4 class="card-title mb-0">Input Item Data</h4>
            </div>
            <form action="{{ route('send_order') }}" method="POST">
                <div class="form-group mb-3">
                    @csrf
                    <textarea class="form-control" name="item_data" rows="3" placeholder="Netflix Account&#10;Email : netflix2@gmail.com&#10;Password : 666IsHere"></textarea>
                    <small id="textHelp" class="form-text text-muted">Input the Information Item : account, gift card, etc</small>
                    <input type="hidden" name="transaction_item_id" value="{{ $transactions->id }}" />
                </div>
                <button type="submit" class="btn btn-md btn-dark"> Send Data </button>
            </form>
        </div>
    </div>


    <div class="card-body pb-10">
        <div class="container">
            <hr>
            <div class="row">
                <div class="col-sm py-0 px-3">
                    <h5>Total : </h5>
                </div>
                <div class="col-sm py-0 px-3 "><span class="mb-1 badge bg-primary-subtle text-primary">IDR {{ $totalAmount }}</span></div>
            </div>
            <div class="row">
                <div class="col-sm py-0 px-3  ">
                    <h5>Shipping : </h5>
                </div>
                <div class="col-sm py-0 px-0"><span class="mb-1 badge bg-success-subtle text-success">FREE</span></div>

            </div>
            <div class="row">
                <div class="col-sm py-0 px-3 ">
                    <h5>Payment Method : </h5>
                </div>
                <div class="col-sm py-0 px-3 "><span class="mb-1 badge  bg-secondary-subtle text-secondary">QRIS</span></div>
            </div>
        </div>

    </div>
    <div class="card-footer">
        <p class="card-text text-center">
            <em>Order history for transaction ID #{{ $transaction['transaction_id']}}</em>
        </p>
    </div>
</div>
@endsection
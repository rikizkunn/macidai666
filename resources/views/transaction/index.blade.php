@extends('layouts.app')
@section('title', 'Order History')
@section('custom_css')

<link rel="stylesheet" href="{{ asset('assets/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}">

@endsection
@section('content')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Order History</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Order History</li>
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
<div class="card">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table id="zero_config" class="table text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-3">
                    <tr>
                        <th>
                            <h6 class="fs-3 fw-semibold mb-0">Product</h6>
                        </th>
                        <th>
                            <h6 class="fs-3 fw-semibold mb-0">Product Name</h6>
                        </th>
                        <th>
                            <h6 class="fs-3 fw-semibold mb-0">Status</h6>
                        </th>
                        <th>
                            <h6 class="fs-3 fw-semibold mb-0">Price</h6>
                        </th>
                        <th>
                            <h6 class="fs-3 fw-semibold mb-0">Order Time</h6>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                    @php
                    $transactionItems = $transactionsItemsData[$transaction->id] ?? [];
                    $totalAmount = collect($transactionItems)->sum(fn($item) => $item['quantity'] * $item['price']);
                    $productBrands = collect($transactionItems)->pluck('product_brand')->unique();
                    $productName = collect($transactionItems)->pluck('product_name')->unique();
                    $productImage = collect($transactionItems)->pluck('product_image')[0];
                    $productNameText = $productName->take(2)->implode(' - ') . ($productName->count() > 2 ? ' .. (' . ($productName->count() - 2) . ' more)' : '');
                    $productBrandsText = $productBrands->take(2)->implode(' - ') . ($productBrands->count() > 2 ? ' .. (' . ($productName->count() - 2) . ' more)' : '');
                    @endphp
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('assets/images' . ($productImage ? $productImage : '/products/default.jpg'))  }}" class="rounded-circle" width="40" height="40">
                                <div class="ms-3">
                                    <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="{{ route('show_transaction', $transaction['id']) }}">
                                        {{ $productBrandsText }}
                                    </a>
                                    <br>
                                    <span class="fw-normal">Digital Items</span>
                                </div>

                            </div>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal fs-3">{{ $productNameText }}</p>
                        </td>
                        <td>
                            @if($transaction->status == 'pending')
                            <span class="badge bg-primary-subtle text-primary d-inline-flex align-items-center gap-1">
                                <i class="ti ti-clock-hour-4 fs-3"></i>pending
                            </span>
                            @elseif ($transaction->status == 'success')
                            <span class="badge bg-success-subtle text-success d-inline-flex align-items-center gap-1">
                                <i class="ti ti-check fs-3"></i>success
                            </span>
                            @else
                            <span class="badge bg-danger-subtle text-danger d-inline-flex align-items-center gap-1">
                                <i class="ti ti-check fs-3"></i>unknown
                            </span>
                            @endif
                        </td>
                        <td>
                            <h6 class="fs-3 fw-semibold mb-0">IDR {{$totalAmount}}</h6>
                        </td>
                        <td>
                            <h6 class="fs-3 fw-semibold mb-0">{{$transaction->created_at}}</h6>
                        </td>
                    </tr>
                    @endforeach



                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection
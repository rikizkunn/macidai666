@extends('layouts.app')
@section('title', 'Dashboard')
@section('custom_css')


@section('content')

<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center gap-4 mb-4">
            <div class="position-relative">
                <div class="border border-2 border-primary rounded-circle">
                    <img src="../assets/images/profile/user-1.jpg" class="rounded-circle m-1" alt="user1" width="60" />
                </div>
            </div>
            <div>
                <h3 class="fw-semibold">{{ Auth::user()->name }}</span>
                </h3>
                <span>Cheers, and happy activities - {{ \Carbon\Carbon::now()->format('F j, Y') }} </span>
            </div>
        </div>
        <div class="card bg-info-subtle overflow-hidden shadow-none">
            <div class="card-body py-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-sm-6">
                        <h5 class="fw-semibold mb-9 fs-5">Happy Shopping on Macidai Store</h5>
                        <p class="mb-9">
                            Our extensive collection includes top-tier subscriptions like Netflix Premium, Spotify, Disney+, Audible, and many more.
                        </p>
                        <a href="{{ route('show_products') }}" class="btn btn-info">Shop Now</a>
                    </div>
                    <div class="col-sm-5">
                        <div class="position-relative mb-n5 text-center">
                            <img src="../assets/images/backgrounds/track-bg.png" alt="modernize-img" class="img-fluid" width="180" height="230">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="card"> -->
        <div class="col-12">
            <div class="card border-1  ">
                <div class="card-body">
                    <div class="d-md-flex align-items-center mb-9">
                        <div>
                            <h4 class="card-title fw-semibold">Order Status</h4>
                            <p class="card-subtitle">Recent purchases product</p>
                        </div>
                        <div class="ms-auto mt-4 mt-md-0">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link rounded active" data-bs-toggle="tab" href="#pending" role="tab">
                                        <span>Pending</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link rounded" data-bs-toggle="tab" href="#success" role="tab">
                                        <span>Success</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <!-- Tab panes -->
                    <div class="tab-content mt-3">
                        <!-- Success Tab Pane -->
                        <div class="tab-pane active" id="pending" role="tabpanel">

                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0 text-nowrap">
                                    <tbody>
                                        @foreach ($transactions as $transaction)
                                        @php
                                        $transactionItems = collect($transactionsItemsData)->filter(function ($item) use ($transaction) {
                                        return $item['transaction_id'] == $transaction->id && $item['status'] == 'pending';
                                        });
                                        @endphp
                                        @if(count($transactionItems) == 0)
                                        <div class="card-body text-center">
                                            <img src="{{ asset('assets/images/products/empty-shopping-bag.gif') }}" alt="modernize-img" class="img-fluid mb-4" width="200">
                                            <h5 class="fw-semibold fs-5 mb-2">No pending orders</h5>
                                            <p class="mb-3">You don't have any pending status Products</p>
                                            <a href="{{ route('show_products') }}" class="btn btn-primary">Go for shopping!</a>
                                        </div>

                                        @endif
                                        @foreach ($transactionItems as $transactionItem)
                                        <tr>
                                            <td class="ps-0">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="flex-shrink-0">
                                                        <img src="{{ asset('assets/images' . ($transactionItem['product_image'] ? $transactionItem['product_image'] : '/products/default.jpg'))  }}" class="rounded" alt="{{ $transactionItem['product_name'] }}" width="80" />
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-semibold">{{ $transactionItem['product_name'] }}</h6>
                                                        <span class="fs-2">Quantity: {{ $transactionItem['quantity'] }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="ps-0">
                                                <span>{{ $transactionItem['product_brand'] }}</span>
                                            </td>
                                            <td class="ps-0">
                                                <h6 class="mb-0">{{ $transactionItem['product_price'] }}</h6>
                                            </td>
                                            <td class="text-end ps-0">
                                                <span class="badge bg-success-subtle text-success rounded-pill">
                                                    <span class="round-8 text-bg-success rounded-circle d-inline-block me-1"></span>{{ $transactionItem['status'] }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Success Tab Pane -->
                        <div class="tab-pane" id="success" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0 text-nowrap">
                                    <tbody>
                                        @foreach ($transactions as $transaction)
                                        @php
                                        $transactionItems = collect($transactionsItemsData)->filter(function ($item) use ($transaction) {
                                        return $item['transaction_id'] == $transaction->id && $item['status'] == 'success';
                                        });
                                        @endphp
                                        @if(count($transactionItems) == 0)
                                        <div class="card-body text-center">
                                            <img src="{{ asset('assets/images/products/empty-shopping-bag.gif') }}" alt="modernize-img" class="img-fluid mb-4" width="200">
                                            <h5 class="fw-semibold fs-5 mb-2">No success orders</h5>
                                            <p class="mb-3">You don't have any success status Products</p>
                                            <a href="{{ route('show_products') }}" class="btn btn-primary">Go for shopping!</a>
                                        </div>

                                        @endif
                                        @foreach ($transactionItems as $transactionItem)
                                        <tr>
                                            <td class="ps-0">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="flex-shrink-0">
                                                        <img src="{{ asset('assets/images' . ($transactionItem['product_image'] ? $transactionItem['product_image'] : '/products/default.jpg'))  }}" class="rounded" alt="{{ $transactionItem['product_name'] }}" width="80" />
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-semibold">{{ $transactionItem['product_name'] }}</h6>
                                                        <span class="fs-2">Quantity: {{ $transactionItem['quantity'] }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="ps-0">
                                                <span>{{ $transactionItem['product_brand'] }}</span>
                                            </td>
                                            <td class="ps-0">
                                                <h6 class="mb-0">${{ $transactionItem['product_price'] }}</h6>
                                            </td>
                                            <td class="text-end ps-0">
                                                <span class="badge bg-warning-subtle text-warning rounded-pill">
                                                    <span class="round-8 text-bg-warning rounded-circle d-inline-block me-1"></span>{{ $transactionItem['status'] }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- <div class="card-body">
                    <p>ss</p>
                </div> -->
            </div>
        </div>

        <!-- </div> -->

        @endsection
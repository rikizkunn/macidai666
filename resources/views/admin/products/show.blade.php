@extends('layouts.app')
@section('title', 'Order History')


@section('custom_css')
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
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
                            <h6 class="fs-3 fw-semibold mb-0">Price (IDR)</h6>
                        </th>
                        <th>
                            <h6 class="fs-3 fw-semibold mb-0">Stock</h6>
                        </th>
                        <th>
                            <h6 class="fs-3 fw-semibold mb-0">Created At</h6>
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)

                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('assets/images' . ($product->product_image ? $product->product_image : '/products/default.jpg'))  }}" class="rounded-circle" width="40" height="40">
                                <div class="ms-3">
                                    <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="{{ route('product_detail', ['slug' => $product->slug]) }}">
                                        {{ $product->product_name }}
                                    </a>
                                    <br>
                                    <span class="fw-normal">{{ $product->brand }}</span>
                                </div>

                            </div>
                        </td>
                        <td>IDR {{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->created_at }}</td>
                        <td>
                            <div class="dropdown dropstart">
                                <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="true">
                                    <i class="ti ti-dots-vertical fs-6"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(-58px, 4px, 0px);" data-popper-placement="left-start">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('edit_product', ['slug' => $product->slug]) }}">
                                            <i class="fs-4 ti ti-edit"></i>Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a data-product-id="{{ $product->product_id }}" class="dropdown-item d-flex align-items-center gap-3 delete-product" href="javascript:void(0)">
                                            <i class="fs-4 ti ti-trash"></i>Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>

                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection


@section('current_js')

<script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/js/forms/sweet-alert.init.js') }}"></script>


@endsection
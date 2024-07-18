@extends('layouts.app')
@section('title', 'Orders Request')


@section('custom_css')
@endsection


@section('content')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Profile Settings</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Profile Settings</li>
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

<div class="col-12">
    <!-- start Tab with dropdown -->
    <div class="card">
        <div class="card-body">

            <div class="mb-3">
                <h5 class="mb-0">Tab with dropdown</h5>
            </div>
            <p class="mb-3 card-subtitle">
                Validate Order and Send the items to customers

            </p>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link d-flex active" data-bs-toggle="tab" href="#pending" role="tab" aria-selected="true">
                        <span>
                            <i class="ti ti-home-2 fs-4"></i>
                        </span>
                        <span class="d-none d-md-block ms-2">Home</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link d-flex" data-bs-toggle="tab" href="#success" role="tab" aria-selected="true">
                        <span>
                            <i class="ti ti-home-2 fs-4"></i>
                        </span>
                        <span class="d-none d-md-block ms-2">Home</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content tabcontent-border p-3" id="myTabContent">
                <div role="tabpanel" class="tab-pane fade active show" id="pending" aria-labelledby="home-tab">
                    <div class="table-responsive">
                        <table id="zero_config" class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-3">
                                <tr>
                                    <th>
                                        <h6 class="fs-3 fw-semibold mb-0">Order ID</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-3 fw-semibold mb-0">Product Name</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-3 fw-semibold mb-0">Price</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-3 fw-semibold mb-0">Status</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-3 fw-semibold mb-0">Order Date</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="success" role="tabpanel" aria-labelledby="profile-tab">
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

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end Tab with dropdown -->
</div>


@endsection
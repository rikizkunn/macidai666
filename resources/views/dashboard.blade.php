@extends('layouts.app')
@section('title', 'Dashboard')
@section('custom_css')
<link rel="stylesheet" href="../assets/libs/owl.carousel/dist/assets/owl.carousel.min.css" />
@endsection

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

        @if(Auth::user()->role == 'admin')
        <div class="owl-carousel counter-carousel owl-theme">
            <div class="item">
                <div class="card border-0 zoom-in bg-primary-subtle shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="../assets/images/svgs/icon-cart.svg" width="50" height="50" class="mb-3" alt="modernize-img" />
                            <p class="fw-semibold fs-3 text-primary mb-1">
                                Products
                            </p>
                            <h5 class="fw-semibold text-primary mb-0">{{ $statistics['productsCount'] }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card border-0 zoom-in bg-warning-subtle shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="../assets/images/svgs/icon-user-male.svg" width="50" height="50" class="mb-3" alt="modernize-img" />
                            <p class="fw-semibold fs-3 text-warning mb-1">Users</p>
                            <h5 class="fw-semibold text-warning mb-0">{{ $statistics['users'] }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card border-0 zoom-in bg-info-subtle shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="../assets/images/svgs/icon-dd-invoice.svg" width="50" height="50" class="mb-3" alt="modernize-img" />
                            <p class="fw-semibold fs-3 text-info mb-1">Total Order</p>
                            <h5 class="fw-semibold text-info mb-0">{{ $statistics['transactionsItems'] }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card border-0 zoom-in bg-danger-subtle shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="../assets/images/svgs/icon-favorites.svg" width="50" height="50" class="mb-3" alt="modernize-img" />
                            <p class="fw-semibold fs-3 text-danger mb-1">Success Order</p>
                            <h5 class="fw-semibold text-danger mb-0">{{ $statistics['success'] }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card border-0 zoom-in bg-success-subtle shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="../assets/images/svgs/icon-speech-bubble.svg" width="50" height="50" class="mb-3" alt="modernize-img" />
                            <p class="fw-semibold fs-3 text-success mb-1">Pending Orders</p>
                            <h5 class="fw-semibold text-success mb-0">{{ $statistics['pending'] }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="card bg-info-subtle overflow-hidden shadow-none">
            <div class="card-body py-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-sm-6">
                        <h5 class="fw-semibold mb-9 fs-5">Happy Shopping on Macidai Store</h5>
                        <p` class="mb-9">
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
        @endif
        <!-- <div class="card"> -->
        <div class="col-12">
            <div class="card border-1  ">
                <div class="card-body">
                    <div class="row">


                        @foreach ($products as $product)
                        <div class="col-sm-6 col-xl-4">
                            <div class="card hover-img overflow-hidden rounded-2">
                                <div class="position-relative">
                                    <a href="{{ route('product_detail', $product->slug) }}">
                                        <img src="{{ asset('assets/images' . ($product->product_image ? $product->product_image : '/products/default.jpg'))  }}" class="card-img-top rounded-0" height="200" alt="...">
                                    </a>
                                    <button type="button" class="btn bg-primary rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3" data-product-id="{{ $product->product_id }}" id="add-cart" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart">
                                        <i class="ti ti-basket fs-4"></i>
                                        </a>

                                </div>
                                <div class="card-body pt-3 p-4">
                                    <h6 class="fs-4">{{ $product->product_name }}</h6>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h6 class="fs-4 mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}
                                            <br>
                                            <span class="fw-normal text-muted fs-2">
                                                <del>Rp {{ number_format($product->price + 10000, 0, ',', '.') }}</del>
                                            </span>
                                        </h6>

                                        <ul class="list-unstyled d-flex align-items-center">
                                            <li>
                                                <a class="me-1" href="#">
                                                    <i class="fa fa-star text-warning"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="me-1" href="#">
                                                    <i class="fa fa-star text-warning"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="me-1" href="#">
                                                    <i class="fa fa-star text-warning"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="me-1" href="#">
                                                    <i class="fa fa-star text-warning"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-star-half text-warning"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach


                        <!-- <div class="col-sm-6 col-xl-4">
            <div class="card hover-img overflow-hidden rounded-2">
              <div class="position-relative">
                <a href="javascript:void(0)">
                  <img src="{{ asset('assets/images/products/bstation.jpg') }}" class="card-img-top rounded-0" alt="...">
                </a>
                <a href="javascript:void(0)" class="bg-primary rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart">
                  <i class="ti ti-basket fs-4"></i>
                </a>
              </div>
              <div class="card-body pt-3 p-4">
                <h6 class="fw-semibold fs-4">MacBook Air Pro</h6>
                <div class="d-flex align-items-center justify-content-between">
                  <h6 class="fw-semibold fs-4 mb-0">$650 <span class="ms-2 fw-normal text-muted fs-3">
                      <del>$900</del>
                    </span>
                  </h6>
                  <ul class="list-unstyled d-flex align-items-center mb-0">
                    <li>
                      <a class="me-1" href="javascript:void(0)">
                        <i class="ti ti-star text-warning"></i>
                      </a>
                    </li>
                    <li>
                      <a class="me-1" href="javascript:void(0)">
                        <i class="ti ti-star text-warning"></i>
                      </a>
                    </li>
                    <li>
                      <a class="me-1" href="javascript:void(0)">
                        <i class="ti ti-star text-warning"></i>
                      </a>
                    </li>
                    <li>
                      <a class="me-1" href="javascript:void(0)">
                        <i class="ti ti-star text-warning"></i>
                      </a>
                    </li>
                    <li>
                      <a class="" href="javascript:void(0)">
                        <i class="ti ti-star text-warning"></i>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="col-sm-6 col-xl-4">
            <div class="card hover-img overflow-hidden rounded-2">
              <div class="position-relative">
                <a href="javascript:void(0)">
                  <img src="{{ asset('assets/images/products/bstation.jpg') }}" class="card-img-top rounded-0" alt="...">
                </a>
                <a href="javascript:void(0)" class="bg-primary rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart">
                  <i class="ti ti-basket fs-4"></i>
                </a>
              </div>
              <div class="card-body pt-3 p-4">
                <h6 class="fw-semibold fs-4">MacBook Air Pro</h6>
                <div class="d-flex align-items-center justify-content-between">
                  <h6 class="fw-semibold fs-4 mb-0">$650 <span class="ms-2 fw-normal text-muted fs-3">
                      <del>$900</del>
                    </span>
                  </h6>
                  <ul class="list-unstyled d-flex align-items-center mb-0">
                    <li>
                      <a class="me-1" href="javascript:void(0)">
                        <i class="ti ti-star text-warning"></i>
                      </a>
                    </li>
                    <li>
                      <a class="me-1" href="javascript:void(0)">
                        <i class="ti ti-star text-warning"></i>
                      </a>
                    </li>
                    <li>
                      <a class="me-1" href="javascript:void(0)">
                        <i class="ti ti-star text-warning"></i>
                      </a>
                    </li>
                    <li>
                      <a class="me-1" href="javascript:void(0)">
                        <i class="ti ti-star text-warning"></i>
                      </a>
                    </li>
                    <li>
                      <a class="" href="javascript:void(0)">
                        <i class="ti ti-star text-warning"></i>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div> -->

                    </div>
                </div>
                <!-- <div class="card-body">
                    <p>ss</p>
                </div> -->
            </div>
        </div>

        <!-- </div> -->
    </div>
</div>


@endsection

@section('current_js')
`
<script src="../assets/libs/owl.carousel/dist/owl.carousel.min.js"></script>
<script src="../assets/js/dashboard.js"></script>
<script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>

@endsection
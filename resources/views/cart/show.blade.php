@extends('layouts.app') 
@section('title', 'Cart') 
@section('custom_css')

<link rel="stylesheet" href="{{ asset('assets/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}">

@endsection
@section('content')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
  <div class="card-body px-4 py-3">
    <div class="row align-items-center">
      <div class="col-9">
        <h4 class="fw-semibold mb-8">Checkout Product</h4>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">Product Detail</li>
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
<div class="checkout ">
  <div class="card">
    <div class="card-body p-4">
      <div class="wizard-content">
        <form action="#" class="tab-wizard wizard-circle">
          <!-- Step 1 -->
          <h6>Cart</h6>
          <section>
            <div class="table-responsive">
              <table class="table align-middle text-nowrap mb-0">
                <thead class="fs-2">
                  <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th class="text-end">Price</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($products as $product)
                  <tr data-product-id="{{ $product->product_id }}">
                    <td class="border-bottom-0">
                      <div class="d-flex align-items-center gap-3 overflow-hidden">
                        <img src="{{ asset('assets/images' . ($product->product_image ? $product->product_image : '/products/default.jpg'))  }}" alt="matdash-img" class="img-fluid rounded" width="80">
                        <div>
                          <h6 class="fw-semibold fs-4 mb-0">{{ $product->product_name }}</h6>
                          <p class="mb-0">digital item</p>
                          <button id="delete-product" data-product-id="{{ $product->product_id }}" type="button" class="btn btn-sm text-danger fs-4"><i class="ti ti-trash"></i></button>
                        </div>
                      </div>
                    </td>
                    <td class="border-bottom-0">
                      <div class="input-group input-group-sm flex-nowrap rounded">
                        <button class="btn minus min-width-40 py-0 border-end border-muted border-end-0 text-muted" type="button" data-product-id="{{ $product->product_id }}" id="decrease">
                          <i class="ti ti-minus"></i>
                        </button>
                        <input type="text" class="min-width-40 flex-grow-0 border border-muted text-muted fs-3 fw-semibold form-control text-center qty" placeholder="" aria-label="Example text with button addon" aria-describedby="add1" value="{{ $cart_product[$product->product_id]['quantity'] }}">
                        <button class="btn min-width-40 py-0 border border-muted border-start-0 text-muted add" type="button" data-product-id="{{ $product->product_id }}" id="increase">
                          <i class="ti ti-plus"></i>
                        </button>
                      </div>
                    </td>
                    <td class="text-end border-bottom-0">
                      <h6 class="fs-4 fw-semibold mb-0">IDR {{ $product->price }}</h6>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="order-summary border rounded p-4 my-4">
              <div class="p-3">
                <h5 class="fs-5 fw-semibold mb-4">Order Summary</h5>
                <div class="d-flex justify-content-between mb-4">
                  <p class="mb-0 fs-4">Shipping</p>
                  <h6 class="mb-0 fs-4 fw-semibold">Free</h6>
                </div>
                <div class="d-flex justify-content-between">
                  <h6 class="mb-0 fs-4 fw-semibold">Total</h6>
                  <h6 class="cart-total mb-0 fs-5 fw-semibold">IDR {{ $cart_total }}</h6>
                </div>
              </div>
            </div>
          </section>
          <!-- Step 2 -->
          <h6>Billing & address</h6>
          <section>
            <div class="billing-address-content">
         
              <div class="card shadow-none border">
                <div class="card-body p-4">
                  <h6 class="mb-3 fs-4 fw-semibold">{{ Auth::user()->name }}</h6>
                  <p class="mb-1 fs-2">Email Address</p>
                  <h6 class="d-flex align-items-center gap-2 my-4 fw-semibold fs-4">
                    <i class="ti ti-mail fs-7"></i> {{ Auth::user()->email }}
                  </h6>
                  <p class="mb-1 fs-2">Information about order will be send to this email address</p>
                  <button type="button" class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 " data-bs-toggle="modal" data-bs-target="#qris-modal">
                        QRIS
                      </button>
                      <div id="qris-modal" class="modal fade" tabindex="-1" aria-labelledby="qris-modal" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                          <div class="modal-content">
                            <div class="modal-header d-flex align-items-center">
                              <h4 class="modal-title" id="myModalLabel">
                                QRIS Payment
                              </h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <h4>
                                Dummy QRIS Payment
                              </h4>
                              <img src="https://cnb.kinokuniya.co.id/themes/basic/images/payment/dummy-qris.png" height="50" class="img-fluid" alt="Blow">
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn bg-danger-subtle text-danger  waves-effect" data-bs-dismiss="modal">
                                Close
                              </button>
                            </div>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                </div>
              </div>
               
              <div class="order-summary border rounded p-4 my-4">
                <div class="p-3">
                  <h5 class="fs-5 fw-semibold mb-4">Order Summary</h5>
                  <div class="d-flex justify-content-between mb-4">
                    <p class="mb-0 fs-4">Shipping</p>
                    <h6 class="mb-0 fs-4 fw-semibold">Free</h6>
                  </div>
                  <div class="d-flex justify-content-between">
                    <h6 class="mb-0 fs-4 fw-semibold">Total</h6>
                    <h6 class="cart-total mb-0 fs-5 fw-semibold">IDR {{ $cart_total }}</h6>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- Step 3 -->
          <h6>Payment</h6>
          <section class="payment-method text-center">
            <h5 class="fw-semibold fs-5">Thank you for your purchase!</h5>
            <h6 class="fw-semibold text-primary mb-7">Your order id: 3fa7-69e1-79b4-dbe0d35f5f5d</h6>
            <img src="{{ asset('assets/images/products/payment-complete.svg') }}" alt="matdash-img" class="img-fluid mb-4" width="350">
            <p class="mb-0 fs-2">We will send you a notification <br>within 2 days when it ships. </p>
            <div class="d-sm-flex align-items-center justify-content-between my-4">
              <a href="../main/eco-shop.html" class="btn btn-success d-block mb-2 mb-sm-0">Continue Shopping</a>
              <a href="javascript:void(0)" class="btn btn-primary d-block">Download Receipt</a>
            </div>
          </section>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('current_js')

<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
<script src="{{ asset('assets/libs/jquery-steps/build/jquery.steps.min.js') }}"></script>
<script src="{{ asset('assets/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/forms/form-wizard.js') }}"></script>
<script src="{{ asset('assets/js/apps/ecommerce.js') }}"></script>

@endsection
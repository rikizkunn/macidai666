@extends('layouts.app')
@section('title', $product->product_name)
@section('custom_css')

<link rel="stylesheet" href="{{ asset('assets/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}">

@endsection
@section('content')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
  <div class="card-body px-4 py-3">
    <div class="row align-items-center">
      <div class="col-9">
        <h4 class="fw-semibold mb-8">{{ $product->product_name }}</h4>
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
<div class="shop-detail">
  <div class="card shadow-none border">
    <div class="card-body p-4">
      <div class="row">
        <div class="col-lg-6">
          <img class="card-img img-responsive h-100 w-100" src="{{ asset('assets/images' . ($product->product_image ? $product->product_image : '/products/default.jpg'))  }}" alt="Card image cap">
        </div>
        <div class="col-lg-6">
          <div class="shop-content">
            <div class="d-flex align-items-center gap-2 mb-2">
              @if ($product->stock > 1)
              <span class="badge text-bg-success fs-2 fw-semibold">In Stock</span>
              @else
              <span class="badge text-bg-danger fs-2 fw-semibold">Not Available</span>
              @endif

              <span class="fs-2">{{ $category_name }}</span>
            </div>
            <h4>{{ $product->product_name }}</h4>
            <p class="mb-3">{{ $product->product_description }}</p>
            <h4 class="mb-3">
              <del class="fs-5 text-muted">Rp {{ number_format($product->price + 10000, 0, ',', '.') }}</del> Rp {{ number_format($product->price, 0, ',', '.') }}
            </h4>
            <div class="d-flex align-items-center gap-8 pb-4 border-bottom">
              <ul class="list-unstyled d-flex align-items-center mb-0">
                <li>
                  <a class="me-1" href="javascript:void(0)">
                    <i class="fa fa-star text-warning"></i>
                  </a>
                </li>
                <li>
                  <a class="me-1" href="javascript:void(0)">
                    <i class="fa fa-star text-warning"></i>
                  </a>
                </li>
                <li>
                  <a class="me-1" href="javascript:void(0)">
                    <i class="fa fa-star text-warning"></i>
                  </a>
                </li>
                <li>
                  <a class="me-1" href="javascript:void(0)">
                    <i class="fa fa-star text-warning"></i>
                  </a>
                </li>
                <li>
                  <a href="javascript:void(0)">
                    <i class="fa fa-star-half text-warning"></i>
                  </a>
                </li>
              </ul>
            </div>
            <form class="form-horizontal" action="{{ route('order_product') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label class="form-label">Package</span>
                </label>
                <select class="form-select" name="package">
                  @foreach ($options as $product_option)
                  <option value="{{ $product_option->slug }}">{{$product_option->brand . ' - ' .  $product_option->option}}</option>
                  @endforeach
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label" for="example-email">Quantity
                </label>
                <div class="input-group input-group-sm rounded">
                  <button class="btn minus min-width-40 py-0 border-end border-muted fs-5 border-end-0 text-muted" type="button" id="add1">
                    <i class="ti ti-minus"></i>
                  </button>
                  <input name="quantity" type="text" class="min-width-40 flex-grow-0 border border-muted text-muted fs-4 fw-semibold form-control text-center qty" placeholder="" aria-label="Example text with button addon" aria-describedby="add1" value="1">
                  <button class="btn min-width-40 py-0 border border-muted fs-5 border-start-0 text-muted add" type="button" id="addo2">
                    <i class="ti ti-plus"></i>
                  </button>
                </div>
              </div>
              <div class="d-sm-flex align-items-center gap-6 pt-8 mb-7">
                <button class="btn d-block btn-primary px-5 py-8 mb-6 mb-sm-0 {{ $product->stock > 0 ? '' : 'disabled' }}" id="buy-now" data-product-id="{{ $product->product_id }}" type="submit">Buy Now</button>
            </form>

            <button type="button" class="
                        btn btn-lg
                        px-4
                        fs-4
                        btn-light-info
                        text-info
                        font-weight-medium {{ $product->stock > 0 ? '' : 'disabled' }}
                      " id="add-cart" data-product-id="{{ $product->product_id }}">
              Add Cart
            </button>

          </div>
          <p class="mb-0">Instant Shipping </p>
          <a href="javascript:void(0)">Why the longer time for delivery?</a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card shadow-none border">
  <div class="card-body p-4">
    <ul class="nav nav-pills user-profile-tab border-bottom" id="pills-tab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link position-relative rounded-0 active d-flex align-items-center justify-content-center bg-transparent fs-3 py-6" id="pills-description-tab" data-bs-toggle="pill" data-bs-target="#pills-description" type="button" role="tab" aria-controls="pills-description" aria-selected="true"> Description </button>
      </li>
    </ul>
    <div class="tab-content pt-4" id="pills-tabContent">
      <div class="tab-pane fade show active" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab" tabindex="0">
        <h5 class="fs-4 mb-2"> Detail Produk dan Penjelasan Syarat Klaim Garansi </h5>
        <p class="mb-2"> {{ $product->product_description }} </p>
        <p class="mb-0"> Kami berkomitmen untuk memberikan pengalaman terbaik bagi pelanggan kami dengan menawarkan garansi universal untuk semua produk digital. Garansi ini mencakup beberapa kondisi berikut:
        <ol class="mb-0">
          <li><b>Tidak Bisa Login</b><br>Jika Anda mengalami masalah login dan tidak bisa mengakses akun Anda, Harap hubungi layanan pelanggan kami untuk mendapatkan bantuan teknis.</li>
          <li><b>Tidak Bisa Digunakan Sebelum 24 Jam</b><br>Jika akun Anda tidak dapat diakses dalam waktu 24 jam setelah pembelian, kami akan mengembalikan uang Anda atau memberikan solusi alternatif yang setara. Harap simpan bukti pembelian dan hubungi layanan pelanggan kami untuk proses klaim garansi.</li>
          <li><b>Multiple Device Dilarang</b><br>Untuk menjaga keamanan dan kenyamanan pengguna, penggunaan akun pada multiple device (banyak perangkat) secara bersamaan dilarang. Jika akun Anda terdeteksi digunakan pada beberapa perangkat sekaligus, akses Anda mungkin dibatasi.</li>
        </ol>
        Dengan garansi ini, kami berusaha untuk memberikan layanan terbaik dan memastikan kepuasan Anda sebagai pelanggan. Jika ada pertanyaan atau masalah, jangan ragu untuk menghubungi kami kapan saja.
        </p>

      </div>
    </div>
  </div>
</div>
<div class="related-products pt-7">
  <h4 class="mb-3 fw-semibold">Related Products</h4>
  <div class="row">
    <div class="col-sm-6 col-xl-3">
      <div class="card hover-img overflow-hidden">
        <div class="position-relative">
          <a href="javascript:void(0)">
            <img src="../assets/images/products/s2.jpg" class="card-img-top" alt="modernize-img">
          </a>
        </div>
        <div class="card-body pt-3 p-4">
          <h6 class="fs-4">Body Lotion</h6>
          <div class="d-flex align-items-center justify-content-between">
            <h6 class="fs-4 mb-0">$89 <span class="ms-2 fw-normal text-muted fs-3">
                <del>$99</del>
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
                <a href="javascript:void(0)">
                  <i class="ti ti-star text-warning"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card hover-img overflow-hidden">
        <div class="position-relative">
          <a href="javascript:void(0)">
            <img src="../assets/images/products/s4.jpg" class="card-img-top" alt="modernize-img">
          </a>
        </div>
        <div class="card-body pt-3 p-4">
          <h6 class="fs-4">Glossy Solution</h6>
          <div class="d-flex align-items-center justify-content-between">
            <h6 class="fs-4 mb-0">$50 <span class="ms-2 fw-normal text-muted fs-3">
                <del>$65</del>
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
                <a href="javascript:void(0)">
                  <i class="ti ti-star text-warning"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card hover-img overflow-hidden">
        <div class="position-relative">
          <a href="javascript:void(0)">
            <img src="{{ asset('assets/images' . ($product->product_image ? $product->product_image : '/products/default.jpg'))  }}" class="card-img-top" alt="modernize-img">
          </a>
        </div>
        <div class="card-body pt-3 p-4">
          <h6 class="fs-4">Derma-E</h6>
          <div class="d-flex align-items-center justify-content-between">
            <h6 class="fs-4 mb-0">$650 <span class="ms-2 fw-normal text-muted fs-3">
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
                <a href="javascript:void(0)">
                  <i class="ti ti-star text-warning"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card hover-img overflow-hidden">
        <div class="position-relative">
          <a href="javascript:void(0)">
            <img src="../assets/images/products/s6.jpg" class="card-img-top" alt="modernize-img">
          </a>
        </div>
        <div class="card-body pt-3 p-4">
          <h6 class="fs-4">SockSoho</h6>
          <div class="d-flex align-items-center justify-content-between">
            <h6 class="fs-4 mb-0">$25 <span class="ms-2 fw-normal text-muted fs-3">
                <del>$31</del>
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
                <a href="javascript:void(0)">
                  <i class="ti ti-star text-warning"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
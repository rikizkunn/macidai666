@extends('layouts.app')

@section('title', 'Create Product')

@section('custom_css')

<link rel="stylesheet" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}" />
@endsection
@section('content')
<div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Create Product</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="./index.html">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Shop</li>
                    </ol>
                </nav>
            </div>
            <div class="col-3">
                <div class="text-center mb-n5">
                    <img src="{{ asset('assets/images/breadcrumb/ChatBc.png') }}" alt="" class="img-fluid mb-n4">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 ">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-7">
                    <h4 class="card-title">Product Details</h4>

                    <button class="navbar-toggler border-0 shadow-none d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                        <i class="ti ti-menu fs-5 d-flex"></i>
                    </button>
                </div>

                <div class="mb-4">
                    <label class="form-label">Product Name <span class="text-danger">*</span>
                    </label>
                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                    <input type="text" name="product_name" class="form-control" value="{{ $product->product_name }}" placeholder="Netflix 1 Bulan">
                    <p class="fs-2">A product name is required and recommended to be unique.</p>
                </div>
                <div class="mb-4">
                    <label class="form-label">Brand <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="brand" class="form-control" value="{{ $product->brand }}" placeholder="Netflix">
                    <p class="fs-2">Brand of the product </p>
                </div>
                <div>
                    <label class="form-label">Description</label>
                    <textarea id="mymce" name="product_description">{{ $product->product_description }}</textarea>
                    <p class="fs-2 mb-0">Set a description to the product for better visibility.</p>
                </div>

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-7">Media</h4>

                <input class="form-control" name="product_image" type="file" id="formFile">

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-7">Pricing</h4>


                <div class="mb-7">
                    <label class="form-label">Base Price <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="price" class="form-control" value="{{ $product->price }}">
                    <p class="fs-2">Set the product price.</p>
                </div>

            </div>
        </div>
        <div class="form-actions mb-5">
            <button id="update-product" type="submit" class="btn btn-primary">
                Save changes
            </button>
            <button type="button" class="btn bg-danger-subtle text-danger ms-6">
                Cancel
            </button>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="offcanvas-md offcanvas-end overflow-auto" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="card rounded-3 card-hover border">
                <div class="card-body">
                    <h4 class="card-title mb-7">Categories</h4>
                    <div class="mb-3">
                        <label class="form-label">Categories</label>
                        <select name="categories" class="select2 form-control">
                            @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{$product->category_id == $cat->id  ? 'selected' : ''}}>{{ $cat->category_name }}</option>
                            @endforeach
                        </select>
                        <p class="fs-2 mb-0">
                            Add product to a category.
                        </p>
                    </div>
                </div>
            </div>
            <div class="card rounded-3 card-hover border">
                <div class="card-body">
                    <h4 class="card-title mb-7">Option</h4>
                    <div class="mb-3">
                        <div class="form-group">
                            <label class="form-label">Option Product</label>
                            <input type="text" name="option" class="form-control" id="nametext" aria-describedby="name" value="{{ $product->option }}" placeholder="1 ">
                            <small id="name" class="form-text text-muted">2 Bulan, 3 Bulan etc</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card rounded-3 card-hover border">
                <div class="card-body">
                    <h4 class="card-title mb-7">Stock Items</h4>
                    <div class="mb-3">
                        <div class="form-group">
                            <label class="form-label">Stock Items of Product</label>

                            <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
                            <small id="name" class="form-text text-muted">10, 20 etc</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('current_js')
<script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/js/forms/tinymce-init.js') }}"></script>

<script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/forms/select2.init.js') }}"></script>
<script src="{{ asset('assets/libs/jquery.repeater/jquery.repeater.min.js') }}"></script>
<script src="{{ asset('assets/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/forms/repeater-init.js') }}"></script>
@endsection
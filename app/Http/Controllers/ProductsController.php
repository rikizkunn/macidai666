<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Categories;
use \Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::get();
        $products = Products::paginate(12);
        return view('products.index', ['products' => $products, 'categories' => $categories]);
    }

    public function filtering_product(Request $request)
    {

        $query = Products::query();

        if ($request->has('cat_id')) {
            $query->where('category_id', $request->cat_id);
        }

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    break;
            }
        }

        // Get the results
        $products = $query->paginate(9);
        $categories = Categories::get();

        return view('products.index', ['products' => $products, 'categories' => $categories]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show Order Product
     */
    public function show_order(Request $request)
    {

        dd($request);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $product = Products::where('slug', '=', $slug)->first();
        if ($product == null) {
            return redirect()->route('404');
        }
        $checkCategory = Categories::find($product->category_id);
        if ($checkCategory) {
            $categoryName = $checkCategory->category_name;
        }

        $options = Products::where('brand', '=', $product->brand)->get();

        // $data = explode(' ', $product->product_name);
        // dd($data);
        return view('products.show', ['product' => $product, 'category_name' => $categoryName, 'options' => $options]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $products)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $products)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Categories;
use \Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        $categories = Categories::get();

        return view('admin.products.create', ["categories" => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request);
        // Validate the request data
        $request->validate([
            'product_name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required|numeric',
            'categories' => 'required|exists:categories,id', // Ensure category exists
            'option' => 'nullable|string',
            'stock' => 'required|integer',
        ]);


        $slug = Str::slug($request->product_name, '-');

        // Handle the file upload
        if ($request->hasFile('product_image')) {
            $imageName = time() . '.' . $request->product_image->extension();
            $request->product_image->move(public_path('assets/images/products'), $imageName);
        } else {
            $imageName = null;
        }

        // Create the product
        Products::create([
            'product_name' => $request->product_name,
            'product_description' => $request->product_description,
            'product_image' => '/products/' . $imageName,
            'price' => $request->price,
            'category_id' => $request->categories,
            'option' => $request->option,
            'stock' => $request->stock,
            'slug' => $slug,
            'brand' => $request->brand,
        ]);


        return response()->json(['message' => 'Product has been successfully saved!'], 200);
    }

    /**
     * Show Order Product
     */
    public function show_products_admin(Request $request)
    {
        $products = Products::orderBy('created_at', 'desc')->get();

        return view('admin.products.show', ["products" => $products]);
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
    public function edit($slug)
    {

        $categories = Categories::get();

        $product = Products::where('slug', '=', $slug)->first();
        if ($product == null) {
            return redirect()->route('404');
        }
        $checkCategory = Categories::find($product->category_id);
        if ($checkCategory) {
            $categoryName = $checkCategory->category_name;
        }

        // $data = explode(' ', $product->product_name);
        // dd($data);
        return view('admin.products.edit', ['product' => $product, 'category_name' => $categoryName, "categories" => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {


        // Validate the request data
        $request->validate([
            'product_name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'product_image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // Example: max 2MB file size
            'price' => 'required|numeric|min:0',
            'categories' => 'required',
            'option' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
        ]);
        // dd($request->product_id);
        // Find the product by ID
        $slug = Str::slug($request->product_name, '-');

        $product = Products::findOrFail($request->product_id);

        // Update the product with the validated data
        $product->product_name = $request->product_name;
        $product->brand = $request->brand;
        $product->product_description = $request->product_description;
        $product->price = $request->price;
        $product->category_id = $request->categories;
        $product->option = $request->option;
        $product->stock = $request->stock;
        $product->slug = $slug;

        // dd($product);
        // Handle product image upload if provided
        if ($request->hasFile('product_image')) {
            // Delete existing image if needed
            $imageName = time() . '.' . $request->product_image->extension();
            $request->product_image->move(public_path('assets/images/products'), $imageName);

            // Save image path to the product
            $product->product_image = '/products/' . $imageName;
        }
        // Save the product
        $product->update();

        // Optionally, return a response
        return response()->json(['message' => 'Product has been updated successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Products $products)
    {

        // Validate the request data
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
        ]);

        // Find the product
        $product = Products::where('product_id', '=', $request->product_id);

        // Delete the product
        $product->delete();

        // Return a success response
        return response()->json(['message' => 'Product has been successfully deleted!'], 200);
    }
}

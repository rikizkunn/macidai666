<?php

namespace App\Http\Controllers;

use App\Models\Products;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;

class CartController extends Controller
{
    
    public function addToCart(Request $request) {

        $product = Products::where('product_id', '=', $request->product_id)->first();

        $cart = $request->session()->get('cart', []);

        if(isset($cart[$product->product_id])) {
            $cart[$product->product_id]['quantity']++;
        } else {

        $cart[$product->product_id] = [
            "product_id" => $product->product_id,
            "title" => $product->product_name,
            "quantity" => $request->quantity,
            "images" => $product->product_image,
            "price" => $product->price
        ];
        }
        
        $request->session()->put('cart', $cart);
        // session(['cart', $cart]);

        $cart_products = collect($request->session()->get('cart'));
        $cart_total = 0;
        foreach ($cart_products as $key => $product) {
            
            $cart_total += $product['quantity'] * $product['price'];
        }
        $total_products_count = count($request->session()->get('cart'));
        

        return response()->json(['status'=>true, 'total_products_count'=>$total_products_count, 'cart_total'=> $cart_total],  200);
    }


    public function showCart(Request $request) {
        $cart_products = collect($request->session()->get('cart', []));
        $cart_total = 0;
       
        // Extract product IDs from the cart
        $product_ids = $cart_products->pluck('product_id')->toArray();

        $products = Products::whereIn('product_id', $product_ids)->get();
        
        // Calculate the total quantity of products in the cart
        if($cart_products->isNotEmpty()) {
            foreach ($cart_products as $product) {
                $cart_total += $product['quantity'] * $product['price'];
            }
        }
    
        // Get the total number of products in the cart
        $total_products_count = $cart_products->count();
    
       
        // dd($product_ids);
        return view('cart.show', [
            'products' => $products,
            'cart_total' => $cart_total,
            'total_products_count' => $total_products_count,
            'cart_product' => $cart_products
        ]);
    }


    public function updateCart(Request $request)
    {   

        if(isset($request->product_id) && isset($request->quantity))
        {
            $cart = $request->session()->get('cart');
            
            $cart[$request->product_id]['quantity'] = $request->quantity;
            $request->session()->put('cart', $cart);
            $update_amount_of_product = $cart[$request->product_id]['quantity'];
            $cart_products = collect($request->session()->get('cart'));
            $cart_total = 0;
            if(session('cart')){
                foreach ($cart_products as $key => $product) {
                    
                    $cart_total += $product['quantity'] * $product['price'];
                }
            }

            return response()->json(['status'=>true, 'update_amount_of_product'=>$update_amount_of_product, 'cart_total'=>$cart_total]);
        }
    }

    public function destroyCart(Request $request)
    {
        $id = $request->product_id;
        $cart = $request->session()->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
        }
        $request->session()->put('cart', $cart);
        $cart_products = collect($request->session()->get('cart'));
        $cart_total = 0;
        if(session('cart')){
            foreach ($cart_products as $key => $product) {
                
                $cart_total += $product['quantity'] * $product['price'];
            }
        }
        return response()->json(['status'=>true, 'cart_total'=>$cart_total]);
    }
    
}

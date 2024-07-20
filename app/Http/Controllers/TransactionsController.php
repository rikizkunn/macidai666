<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Transactions;
use App\Models\TransactionsItems;
use App\Models\DigitalItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Step 1: Retrieve the transactions for the authenticated user
        $transactions = Transactions::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        // dd($transaction);
        // Step 2: Extract the id values from the transactions
        $transactionIds = $transactions->pluck('id')->toArray();

        // Step 3: Query TransactionsItems using these IDs
        $transactionHistory = TransactionsItems::whereIn('transaction_id', $transactionIds)->orderBy('created_at', 'desc')->get();
        // dd($transactionHistory);
        // Step 4: Get product information
        $productIds = $transactionHistory->pluck('product_id')->unique()->toArray();
        $products = Products::whereIn('product_id', $productIds)->get()->keyBy('product_id');

        // Step 5: Organize transaction items data
        $transactionsItemsData = [];
        foreach ($transactionHistory as $transaction_data) {
            $product = $products[$transaction_data->product_id];
            $transactionsItemsData[$transaction_data->transaction_id][] = [
                'transaction_id' => $transaction_data->transaction_id,
                'created_at' => $transaction_data->created_at,
                'product_id' => $transaction_data->product_id,
                'quantity' => $transaction_data->quantity,
                'price' => $transaction_data->price,
                'product_name' => $product->product_name,
                'product_brand' => $product->brand,
                'product_photo' => $product->product_image
            ];
        }

        return view('transaction.index', ['transactions' => $transactions, 'transactionsItemsData' => $transactionsItemsData]);
    }

    public function order_history()
    {
        $transactions = Transactions::where('user_id', '=', Auth::user()->id)->latest()->get();
        $transactionIds = $transactions->pluck('id')->toArray();
        $transactionHistory = TransactionsItems::whereIn('transaction_id', $transactionIds)->latest()->get();

        return view('transaction.index', ['transactions' => $transactions, 'transactions_history' => $transactionHistory]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        // dd($request->products);
        $request->validate([
            'products.*.product_id' => 'required|integer',
            'products.*.quantity' => 'required|integer|min:1',
        ]);


        $data = Transactions::create([
            'user_id' => Auth::user()->id,
            'status' => 'pending'
        ]);

        $transactionId = $data->id; // Get the transaction_id
        $transactionsItemsData = [];
        foreach ($request->products as $product) {
            $transactionsItemsData[] = [
                'transaction_id' => $transactionId,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'price' => $request->price,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }


        $x = TransactionsItems::insert($transactionsItemsData);
        $request->session()->forget('cart');
        return $x;
    }

    /**
     * Display the specified resource.
     */
    public function show($transaction_id)
    {

        // Step 1: Retrieve the transactions for the authenticated user
        $transaction = Transactions::where('id', $transaction_id)->where('user_id', Auth::user()->id)->first();
        // dd($transaction);
        // Step 3: Query TransactionsItems using these IDs
        $transactionHistory = TransactionsItems::where('transaction_id', '=', $transaction_id)->get();

        // Step 4: Get product information
        $productIds = $transactionHistory->pluck('product_id')->unique()->toArray();
        $products = Products::whereIn('product_id', $productIds)->get()->keyBy('product_id');

        // Step 5: Organize transaction items data
        $transactionsItemsData = [];
        foreach ($transactionHistory as $transaction_data) {
            $product = $products[$transaction_data->product_id];
            if (!isset($transactionsItemsData[$transaction_data->product_id])) {
                $transactionsItemsData[$transaction_data->product_id] = [
                    'transaction_id' => $transaction_data->transaction_id,
                    'status' => $transaction->status,
                    'product_id' => $transaction_data->product_id,
                    'quantity' => 0,
                    'product_price' => $product->price,
                    'product_name' => $product->product_name,
                    'product_brand' => $product->brand,
                    'product_image' => $product->product_image,
                    'slug' => $product->slug
                ];
            }
            $transactionsItemsData[$transaction_data->product_id]['quantity'] += $transaction_data->quantity;
        }

        $item_data = "Empty Data";
        if ($transaction->status == 'success') {
            $data = DigitalItems::where('transaction_item_id', '=', $transaction->id)->first();
            $item_data = $data->item_data;
        }

        return view('transaction.show', ['transactionsItemsData' => $transactionsItemsData, 'transaction' => $transaction, 'item_data' => $item_data]);
        // return view('transaction.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transactions $transactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transactions $transactions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transactions $transactions)
    {
        //
    }
}

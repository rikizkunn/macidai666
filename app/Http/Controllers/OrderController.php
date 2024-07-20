<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Transactions;
use App\Models\TransactionsItems;
use App\Models\DigitalItems;
use Carbon\Carbon;
use PHPUnit\Event\Tracer\Tracer;

class OrderController extends Controller
{


    public function index(Request $request)
    {

        $transactions = Transactions::orderBy('created_at', 'desc')->where('status', 'pending')->get();
        // $pendingOrders = Transactions::orderBy('created_at', 'desc')->where('status', 'success')->get();

        $transactionIds = $transactions->pluck('id')->toArray();

        // Step 3: Query TransactionsItems using these IDs
        $transactionHistory = TransactionsItems::whereIn('transaction_id', $transactionIds)->orderBy('created_at', 'desc')->get();
        
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

        return view('admin.order.index', ['transactions' => $transactions, 'transactionsItemsData' => $transactionsItemsData]);
    }

    public function detail($transactionId)
    {
        // Step 1: Retrieve the transactions for the authenticated user
        $transaction = Transactions::where('id', $transactionId)->where('id', $transactionId)->first();

        // Step 3: Query TransactionsItems using these IDs
        $transactionHistory = TransactionsItems::where('transaction_id', '=', $transactionId)->get();

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


        return view('admin.order.detail', ['transactionsItemsData' => $transactionsItemsData, 'transactions' => $transaction]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'transaction_item_id' => 'required|integer',
            'item_data' => 'required',
        ]);
        $validatedData['delivery_date'] = $current_date_time = Carbon::now()->toDateTimeString();
        DigitalItems::insert($validatedData);

        $transaction = Transactions::findOrFail($request->transaction_item_id);
        $transaction->status = 'success';
        $transaction->update();
        return redirect()->route('index_order');
    }
}

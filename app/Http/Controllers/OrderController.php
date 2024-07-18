<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Transactions;
use App\Models\TransactionsItems;


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

        dd($transactionsItemsData);

        return view('admin.order.index', ['successOrder' => $transactions]);
    }


    public function detail($transactionId)
    {
        
    }
}

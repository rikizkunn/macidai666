<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\Products;
use App\Models\Transactions;
use App\Models\TransactionsItems;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PHPUnit\Event\Tracer\Tracer;

class DashboardController extends Controller
{

    public function index()
    {
        // Step 1: Retrieve the transactions for the authenticated user
        $transactions = Transactions::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $transactionIds = $transactions->pluck('id')->toArray();

        // Step 2: Query TransactionsItems using these IDs
        $transactionHistory = TransactionsItems::whereIn('transaction_id', $transactionIds)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Step 3: Get product information
        $productIds = $transactionHistory->pluck('product_id')->unique()->toArray();
        $products = Products::whereIn('product_id', $productIds)->get()->keyBy('product_id');

        // Step 4: Organize transaction items data with statuses
        $transactionsItemsData = [];
        foreach ($transactionHistory as $transaction_data) {
            $product = $products[$transaction_data->product_id];
            if (!isset($transactionsItemsData[$transaction_data->product_id])) {
                $transactionsItemsData[$transaction_data->product_id] = [
                    'transaction_id' => $transaction_data->transaction_id,
                    'product_id' => $transaction_data->product_id,
                    'quantity' => 0,
                    'product_price' => $product->price,
                    'product_name' => $product->product_name,
                    'product_brand' => $product->brand,
                    'product_image' => $product->product_image,
                    'slug' => $product->slug,
                    'status' => $transactions->firstWhere('id', $transaction_data->transaction_id)->status // Assuming the status field is present in Transactions table
                ];
            }
            $transactionsItemsData[$transaction_data->product_id]['quantity'] += $transaction_data->quantity;
        }

        return view('dashboard', [
            'transactions' => $transactions,
            'transactionsItemsData' => $transactionsItemsData,
        ]);

        // return view('transaction.show', ['transactionsItemsData' => $transactionsItemsData, 'transaction' => $transaction]);
        // dd($transactionsItemsData);
        // $transactionId = Transactions::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->limit(4)->get();
        // $transaction = where
        // return view('dashboard', ['transactions' => $transactions, 'transactionsItemsData' => $transactionsItemsData]);
    }
}

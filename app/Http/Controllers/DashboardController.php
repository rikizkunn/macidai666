<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\Products;
use App\Models\Transactions;
use App\Models\TransactionsItems;
use App\Models\User;
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

        $statistics = null;
        $productsLatest = Products::orderBy('created_at', 'desc')->get();

        if (Auth::user()->role == 'admin') {
            $totalEarnings = TransactionsItems::sum('price');
            $productsCount = Products::count();
            $transactionsItemsCount = TransactionsItems::count();
            $transactionsSuccess = Transactions::whereIn('status', ['success'])->count();
            $transactionsPending = Transactions::whereIn('status', ['pending'])->count();
            $usersCount = User::count();
            $statistics = [
                "productsCount" => $productsCount,
                "transactionsItems" => $transactionsItemsCount,
                "pending" => $transactionsPending,
                "success" => $transactionsSuccess,
                "users" => $usersCount,
                'total_earnings' => $totalEarnings
            ];
        }

        // $usersCount = User::count();



        return view('dashboard', [
            'transactions' => $transactions,
            'transactionsItemsData' => $transactionsItemsData,
            'statistics' => $statistics,
            'products' => $productsLatest
        ]);
    }
}

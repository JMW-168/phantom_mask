<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionStatController extends Controller
{
    public function summary(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        $query = Transaction::query();

        if ($start && $end) {
            $query->whereBetween('purchased_at', [$start, $end]);
        }

        return response()->json([
            'total_transactions' => $query->count(),
            'total_quantity' => $query->sum('quantity'),
            'total_amount' => $query->sum('total_price'),
        ]);
    }
}

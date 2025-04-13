<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserStatController extends Controller
{
    public function topUsers(Request $request)
    {
        $limit = $request->input('limit', 5);
        $start = $request->input('start');
        $end = $request->input('end');

        $users = User::with(['transactions' => function ($query) use ($start, $end) {
            if ($start && $end) {
                $query->whereBetween('purchased_at', [$start, $end]);
            }
        }])
        ->get()
        ->map(function ($user) {
            $total = $user->transactions->sum('total_price');
            return [
                'name' => $user->name,
                'total' => $total,
            ];
        })
        ->sortByDesc('total')
        ->values()
        ->take($limit);

        return response()->json($users);
    }
}

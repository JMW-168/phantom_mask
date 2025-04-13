<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pharmacy;
use App\Models\Mask;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $q = $request->input('q');

        if (!$q) {
            return response()->json(['message' => 'Query keyword (q) is required.'], 400);
        }

        // 搜尋藥局
        $pharmacies = Pharmacy::where('name', 'like', "%$q%")->get(['id', 'name']);

        // 搜尋口罩 + 藥局
        $masks = Mask::with('pharmacy:id,name')
            ->where('name', 'like', "%$q%")
            ->get(['id', 'name', 'price', 'pharmacy_id']);

        return response()->json([
            'pharmacies' => $pharmacies,
            'masks' => $masks,
        ]);
    }
}

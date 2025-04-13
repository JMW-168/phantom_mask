<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pharmacy;
use App\Models\Mask;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $q = trim($request->input('q'));
    
        if (!$q) {
            return response()->json(['message' => 'Query keyword (q) is required.'], 400);
        }
    
        // 強化藥局搜尋
        $pharmacies = Pharmacy::select('id', 'name')
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%$q%")
                      ->orWhereRaw("REPLACE(name, ' ', '') LIKE ?", ["%$q%"]);
            })
            ->orderByRaw("
                CASE
                    WHEN name = ? THEN 1
                    WHEN name LIKE ? THEN 2
                    WHEN name LIKE ? THEN 3
                    ELSE 4
                END
            ", [$q, "$q%", "%$q%"])
            ->get();
    
        // 強化口罩搜尋
        $masks = Mask::select('id', 'name', 'price', 'pharmacy_id')
            ->with(['pharmacy:id,name'])
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%$q%")
                      ->orWhereRaw("REPLACE(name, ' ', '') LIKE ?", ["%$q%"]);
            })
            ->orderByRaw("
                CASE
                    WHEN name = ? THEN 1
                    WHEN name LIKE ? THEN 2
                    WHEN name LIKE ? THEN 3
                    ELSE 4
                END
            ", [$q, "$q%", "%$q%"])
            ->get();
    
        return response()->json([
            'pharmacies' => $pharmacies,
            'masks' => $masks,
        ]);
    }
    
    
}

<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PharmacyController extends Controller
{
    // ✅ 功能 1：查指定時間是否有開店
    public function getOpenPharmacies(Request $request)
    {
        $day = substr($request->input('day', Carbon::now()->format('D')), 0, 3); // e.g. Mon
        $time = $request->input('time', Carbon::now()->format('H:i'));

        $pharmacies = Pharmacy::whereHas('hours', function ($query) use ($day, $time) {
            $query->where('weekday', $day)
                  ->where('open_time', '<=', $time)
                  ->where('close_time', '>=', $time);
        })->get();

        return response()->json($pharmacies);
    }

    // ✅ 功能 2：查某藥局的所有口罩，支援排序
    public function getMasks(Request $request, $id)
    {
        $sort = $request->input('sort', 'name'); // name or price
        $sortDir = in_array($sort, ['price']) ? 'asc' : 'asc'; // 可改為動態排序

        $pharmacy = Pharmacy::with(['masks' => function ($query) use ($sort, $sortDir) {
            $query->orderBy($sort, $sortDir);
        }])->findOrFail($id);

        return response()->json([
            'pharmacy' => $pharmacy->name,
            'masks' => $pharmacy->masks,
        ]);
    }

    // ✅ 功能 3：依口罩數量篩藥局（+價格範圍）
    public function filterByMaskCount(Request $request)
    {
        $min = $request->input('min', 0);
        $max = $request->input('max', 999999);

        $pharmacies = Pharmacy::withCount(['masks' => function ($query) use ($min, $max) {
            $query->whereBetween('price', [$min, $max]);
        }])->get()
          ->filter(function ($pharmacy) use ($request) {
              $masksCount = $pharmacy->masks_count;
              if ($request->has('more_than')) {
                  return $masksCount > $request->input('more_than');
              }
              if ($request->has('less_than')) {
                  return $masksCount < $request->input('less_than');
              }
              return true;
          })
          ->values();

        return response()->json($pharmacies);
    }
}


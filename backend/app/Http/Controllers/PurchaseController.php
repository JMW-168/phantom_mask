<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pharmacy;
use App\Models\Mask;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function purchase(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'pharmacy_id' => 'required|exists:pharmacies,id',
            'mask_id' => 'required|exists:masks,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail($request->user_id);
            $pharmacy = Pharmacy::findOrFail($request->pharmacy_id);
            $mask = Mask::where('id', $request->mask_id)
                        ->where('pharmacy_id', $pharmacy->id)
                        ->firstOrFail();

            $unitPrice = $mask->price;
            $quantity = $request->quantity;
            $total = round($unitPrice * $quantity, 2);

            if ($user->cash_balance < $total) {
                throw new \Exception('User does not have enough cash.');
            }

            // 建立交易
            Transaction::create([
                'user_id' => $user->id,
                'pharmacy_id' => $pharmacy->id,
                'mask_id' => $mask->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total_price' => $total,
                'purchased_at' => now(),
            ]);

            // 扣款 / 加款
            $user->decrement('cash_balance', $total);
            $pharmacy->increment('cash_balance', $total);

            // 價格調整：+10%
            $mask->price = round($mask->price * 1.1, 2);
            $mask->save();

            DB::commit();

            return response()->json([
                'message' => 'Purchase completed successfully.',
                'new_mask_price' => $mask->price,
                'user_cash_balance' => $user->cash_balance,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Purchase failed: ' . $e->getMessage(),
            ], 400);
        }
    }
}

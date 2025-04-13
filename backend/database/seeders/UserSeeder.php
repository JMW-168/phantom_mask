<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Pharmacy;
use App\Models\Mask;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $json = file_get_contents(database_path('data/users.json'));
        $users = json_decode($json, true);

        DB::transaction(function () use ($users) {
            foreach ($users as $userData) {
                $user = User::create([
                    'name' => $userData['name'],
                    'email' => Str::slug($userData['name'], '.') . '@example.com',
                    'password' => bcrypt('password'),
                    'cash_balance' => $userData['cashBalance'],
                ]);

                foreach ($userData['purchaseHistories'] as $history) {
                    $pharmacy = Pharmacy::where('name', trim($history['pharmacyName']))->first();
                    $mask = Mask::where('name', trim($history['maskName']))->first();

                    if (!$pharmacy || !$mask) {
                        continue; // 可改 log::warning(...) 
                    }

                    Transaction::create([
                        'user_id' => $user->id,
                        'pharmacy_id' => $pharmacy->id,
                        'mask_id' => $mask->id,
                        'quantity' => 1,
                        'unit_price' => $history['transactionAmount'],  // 假設 1 份就等於總價
                        'total_price' => $history['transactionAmount'],
                        'purchased_at' => Carbon::parse($history['transactionDate']),
                    ]);
                }
            }
        });
    }
}

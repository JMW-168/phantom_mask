<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pharmacy;
use App\Models\PharmacyHour;
use App\Models\Mask;
use Illuminate\Support\Facades\DB;

class PharmacySeeder extends Seeder
{
    public function run(): void
    {
        $json = file_get_contents(database_path('data/pharmacies.json'));
        $data = json_decode($json, true);

        DB::transaction(function () use ($data) {
            foreach ($data as $pharmacyData) {
                $pharmacy = Pharmacy::create([
                    'name' => $pharmacyData['name'],
                    'cash_balance' => $pharmacyData['cashBalance'],
                ]);

                // 解析 openingHours 字串
                $hourBlocks = explode(' / ', $pharmacyData['openingHours']);
                foreach ($hourBlocks as $block) {
                    if (preg_match('/^([\w\s,-]+)\s+(\d{2}:\d{2})\s*-\s*(\d{2}:\d{2})$/', $block, $matches)) {
                        $daysPart = $matches[1];
                        $openTime = $matches[2];
                        $closeTime = $matches[3];

                        $days = $this->expandDays($daysPart);
                        foreach ($days as $day) {
                            PharmacyHour::create([
                                'pharmacy_id' => $pharmacy->id,
                                'weekday' => $day,
                                'open_time' => $openTime,
                                'close_time' => $closeTime,
                            ]);
                        }
                    }
                }

                // 寫入 masks
                foreach ($pharmacyData['masks'] as $maskData) {
                    Mask::create([
                        'pharmacy_id' => $pharmacy->id,
                        'name' => $maskData['name'],
                        'price' => $maskData['price'],
                    ]);
                }
            }
        });
    }

    private function expandDays(string $daysStr): array
    {
        // 支援類似 "Mon - Fri", "Sat, Sun", "Mon, Wed, Fri"
        $daysMap = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
        $daysStr = str_replace(['Thur', 'Thu'], 'Thu', $daysStr); // 統一

        $parts = array_map('trim', explode(',', $daysStr));
        $results = [];

        foreach ($parts as $part) {
            if (preg_match('/^(\w+)\s*-\s*(\w+)$/', $part, $match)) {
                $start = array_search(substr($match[1], 0, 3), $daysMap);
                $end = array_search(substr($match[2], 0, 3), $daysMap);
                if ($start !== false && $end !== false) {
                    $range = $start <= $end
                        ? array_slice($daysMap, $start, $end - $start + 1)
                        : array_merge(array_slice($daysMap, $start), array_slice($daysMap, 0, $end + 1));
                    $results = array_merge($results, $range);
                }
            } else {
                $results[] = substr(trim($part), 0, 3); // 確保只有 Mon 這種縮寫
            }
        }

        return array_unique($results);
    }
}


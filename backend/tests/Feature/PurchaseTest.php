<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Pharmacy;
use App\Models\Mask;
use App\Models\Transaction;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_purchase_mask_successfully()
    {
        // 建立資料
        $pharmacy = Pharmacy::factory()->create();
        $mask = Mask::factory()->create([
            'pharmacy_id' => $pharmacy->id,
            'price' => 10.00,
        ]);
        $user = User::factory()->create([
            'cash_balance' => 100.00,
        ]);

        // 模擬購買請求
        $response = $this->postJson('/api/purchase', [
            'user_id' => $user->id,
            'pharmacy_id' => $pharmacy->id,
            'mask_id' => $mask->id,
            'quantity' => 2,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Purchase completed successfully.',
        ]);

        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'mask_id' => $mask->id,
            'quantity' => 2,
        ]);
    }
}


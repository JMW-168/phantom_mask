<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Pharmacy;
use App\Models\PharmacyHour;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PharmacyControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_open_pharmacies()
    {
        $pharmacy = Pharmacy::factory()->create();
        PharmacyHour::factory()->create([
            'pharmacy_id' => $pharmacy->id,
            'weekday' => 'Mon',
            'open_time' => '09:00',
            'close_time' => '18:00',
        ]);

        $response = $this->getJson('/api/pharmacies/open?day=Mon&time=10:00');

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $pharmacy->id]);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Safeboda\Promocode;
use Safeboda\Scopes\NotExpired;
use Tests\TestCase;

class PromoCodesTest extends TestCase
{
    use DatabaseTransactions;
    use InteractsWithDatabase;

    public function testCreatePromoCodes()
    {
        $promocodes = factory(Promocode::class, 5)->make()->toArray();
        $response = $this->json('POST', 'api/promo-codes', $promocodes);

        $response
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
                'count' => count($promocodes),
            ]);
    }

    public function testListPromoCodes()
    {
        factory(Promocode::class, 5)->create();

        $response = $this->json('GET', 'api/promo-codes');

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => Promocode::all()->toArray(),
            ]);
    }

    public function testListActivePromoCodes()
    {
        factory(Promocode::class, 10)->create();
        $activePromocode = Promocode::active()->get()->toArray();
        $response = $this->json('GET', 'api/promo-codes/active');

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => $activePromocode,
            ]);
    }

    public function testCanDeactivatePromoCodes()
    {
        factory(Promocode::class, 10)->create();
        $ids = Promocode::pluck('id')->all();
        $updated = count($ids) ?? false;
        $response = $this->json('POST', 'api/promo-codes/deactivate', ['ids' => $ids]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'updated' => $updated,
            ]);
    }
}

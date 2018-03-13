<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Safeboda\Promocode;
use Safeboda\Scopes\NotExpired;
use Tests\TestCase;

class GeneratePromoCodesTest extends TestCase
{
    use DatabaseTransactions;
    use InteractsWithDatabase;

    protected $promocodes;

    public function setUp()
    {
        $this->promocodes = Promocode::withoutGlobalScope(NotExpired::class)->get();
    }

    public function testCreatePromoCode()
    {
        $promocodes = factory(Promocode::class, 5)->make();
        $response = $this->json('POST', 'api/promo-codes', $promocodes->toArray());

        $response
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);

        $this->assertDatabaseHas('promocodes', $this->promocodes->toArray());
    }

    public function testListPromoCodes()
    {
        factory(Promocode::class, 5)->create();

        $response = $this->json('GET', 'api/promo-codes');

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => $this->promocodes->toArray(),
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
}

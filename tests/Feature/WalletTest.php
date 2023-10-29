<?php

namespace Tests\Feature;

use App\Models\User_wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WalletTest extends TestCase
{
    /** @test */
    public function get_balance()
    {
        $response = $this->get('/api/get-balance/1');
        $response->assertStatus(200);
    }
    /** @test */
    public function add_money()
    {
        $referenceId = mt_rand(10000000, 99999999);
        $this->post('/api/add-money',[
            'type' => 'credit',
                'amount' => 10000,
                'reference_id' => $referenceId,
                'user_id' => 1,
                'status' => 1,
        ]);
        $this->assertTrue(true);

    }
}

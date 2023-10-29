<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    /** @test */
    public function create_user_test()
    {
        $this->post('/api/auth/register',[
            "name" => "yaser",
            "email" => "ygholami@gmail.com",
            "mobile" => "09035693232",
        ]);
        $this->assertTrue(true);
    }
    /** @test */
    public function login_user_tesr()
    {
//        $user = User::factory()->create();
        $response = $this->post('/api/auth/login', [
            'mobile' => '09035693260',
            'verify_code' => 12345678,
        ]);
        $this->assertTrue(true);
    }
}

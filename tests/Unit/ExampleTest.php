<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class AppTest extends TestCase
{
    public function test_must_enter_email_and_password()
    {
        $payload = [];
        $headers = ['Accept' => 'application/json'];
        $this->json('POST', 'api/login', $payload, $headers)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    'email' => ["The email field is required."],
                    'password' => ["The password field is required."],
                ]
            ]);
    }

    public function test_login()
    {
        $payload = ['email' => 'admin@test.dev', 'password' => 'admin@123'];
        $headers = ['Accept' => 'application/json'];

        $response = $this->json('post', 'api/login', $payload, $headers)
          ->assertStatus(200)
          ->assertJsonStructure( ["user", "token" ]);

        $this->assertAuthenticated();
    }

    public function test_loan_apply()
    {
        $user = \App\Models\User::find(3);
        $token = $user->createToken($user->email.'-'.now())->accessToken;

        $payload = ['amount' => 2000, 'term' => 1];
        $headers = ['Accept' => 'application/json', 'Authorization' => "Bearer $token"];

        $r = $this->json('post', 'api/loans/apply', $payload, $headers)
          ->assertStatus(200)
          ->assertJson([ "success" => 1 ])
          ->assertJsonStructure( ["success", "loan" ]);
    }

    public function test_loan_apply_api_should_not_accept_negative_amount()
    {
        $user = \App\Models\User::find(3);
        $token = $user->createToken($user->email.'-'.now())->accessToken;

        $payload = ['amount' => -1000, 'term' => 1];
        $headers = ['Accept' => 'application/json', 'Authorization' => "Bearer $token"];

        $r = $this->json('post', 'api/loans/apply', $payload, $headers)
          ->assertSee('The amount must be greater than 0.');
    }


    public function test_loan_approve()
    {
        $user = \App\Models\User::find(2);
        $token = $user->createToken($user->email.'-'.now())->accessToken;

        $payload = ['loan_id' => 1];
        $headers = ['Accept' => 'application/json', 'Authorization' => "Bearer $token"];

        $r = $this->actingAs($user)->json('post', 'api/loans/approve', $payload, $headers)
          ->assertStatus(200)
          ->assertJson([ "success" => 1 ])
          ->assertJsonStructure( ["success", "loan" ]);
    }


    public function test_loan_repay_loan_id_should_be_valid()
    {
        $user = \App\Models\User::find(3);
        $token = $user->createToken($user->email.'-'.now())->accessToken;

        $payload = ['loan_id' => 1];
        $headers = ['Accept' => 'application/json', 'Authorization' => "Bearer $token"];

        $r = $this->json('post', 'api/transactions/loan/repay', $payload, $headers)
          ->assertStatus(200)
          ->assertJson([ "success" => 1 ])
          ->assertJsonStructure( ["success", "amount_paid" ]);
    }

    public function test_loan_repay()
    {
        $user = \App\Models\User::find(3);
        $token = $user->createToken($user->email.'-'.now())->accessToken;

        $payload = ['loan_id' => 1];
        $headers = ['Accept' => 'application/json', 'Authorization' => "Bearer $token"];

        $r = $this->json('post', 'api/transactions/loan/repay', $payload, $headers)
          ->assertStatus(200)
          ->assertJson([ "success" => 1 ])
          ->assertJsonStructure( ["success", "amount_paid" ]);
    }


}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function success_login()
    {
        $user = $this->createUser();
        $response = $this->postJson('api/login',[
            'email' => $user['email'],
            'password' => 'Test123$$'
        ]);

        $response->assertStatus(201);
    }
    /** 
     * @test
     */
    public function a_user_can_register()
    {
        $response = $this->postJson('api/register', [
            'email' => 'rhimartbravo@mail.com',
            'password' => 'test123',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'id' => $response['user']['id'],
            'email' => 'rhimartbravo@mail.com',
        ]);
    }
    /** 
     * @test
     */
    public function user_no_password_validation()
    {
        $response = $this->postJson('api/register', [
            'email' => 'rhimartbravo@mail.com',
            // 'password' => 'Password123@@',
            // 'password_confirmation' => 'Password123@@',
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors('password');
    }
    /** 
     * @test
     */
    public function email_already_taken()
    {
        $this->postJson('api/register', [
            'email' => 'rhimartbravo@mail.com',
            'password' => 'test123',
        ]);

        $response = $this->postJson('api/register', [
            'email' => 'rhimartbravo@mail.com',
            'password' => 'test123',
        ]);

        $response->assertStatus(400);
    }
}

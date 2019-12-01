<?php

namespace Tests\Feature;

use App\Entity\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testForm(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Register');
    }

    public function testErrors(): void
    {
        $response = $this->post('/register',[
            'email' => '',
            'password '=> '',
            'password_confirmation' => '',
            'name' => ''
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['password', 'email', 'name']);
    }

    public function testWait(): void
    {
        $user = factory(User::class)->create(['status'=>User::STATUS_WAIT, 'password'=>bcrypt(11111111),'email_verified_at'=>null]);
        $response = $this->post('/register',[
            'email' => $user->email,
            'name' => $user->name,
            'password'=>11111111,
            'password_confirmation'=>11111111
        ]);

        $this->followRedirects($response)->assertSee('All Categories');
    }
}

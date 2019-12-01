<?php

namespace Tests\Feature;

use App\Entity\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testForm(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Login');
    }

    public function testErrors(): void
    {
        $response = $this->post('/login',[
            'email' => '',
            'password'=>''
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['password', 'email']);
    }

    public function testWait(): void
    {
        $password = 11111111;
        $user = factory(User::class)->create(['status'=>User::STATUS_WAIT, 'password'=>bcrypt($password),'email_verified_at'=>null]);
        $response = $this->post('/login',[
            'email'=>'rvon@example.com',
            'password'=>$password,
        ]);
       // $this->followRedirects($response)->assertSee('Verify Your Email Address');
        $response->assertRedirect('/');
    }

    public function testActive(): void
    {
        $user = factory(User::class)->create(['status'=>User::STATUS_ACTIVE,
            'password'=>bcrypt(11111111),
            'email_verified_at'=>Carbon::now()]);

        $response =  $this->actingAs($user)->get('/cabinet');

        $this->followRedirects($response)->assertSee('<li class="nav-item"><a class="nav-link " href="https://localhost:8080/cabinet/profile">Profile</a></li>');
    }

    public function testNotActive(): void
    {
        $user = factory(User::class)->create(['status'=>User::STATUS_WAIT,
            'password'=>bcrypt(11111111),
            'email_verified_at'=>null]);

        $r = $this->actingAs($user)->get('/cabinet');
        $this->followRedirects($r)->assertSee('Verify Your Email Address');

    }
}

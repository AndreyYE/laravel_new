<?php

namespace Tests\Browser;

use App\Entity\User;
use Carbon\Carbon;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
//    public function testBasicExample()
//    {
//        $password = '11111111';
//
//        $user = factory(User::class)->create([
//            'status'=>User::STATUS_ACTIVE,
//            'password'=>bcrypt($password),
//            'phone'=>'80991165787',
//            'role'=>User::ROLE_USER,
//            'phone_verify_token'=>'12345',
//            'phone_verify_token_expire'=>Carbon::now()->addMinutes(5),
//            'email_verified_at'=>Carbon::now()]);
//
//        $this->browse(function (Browser $browser) use ($password, $user){
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $text = $browser
//                           ->loginAs($user)
//             ->assertAuthenticatedAs($user)
//            ->visit('/cabinet/profile/phone')
//            ->assertSee('Token')
//            ->type('token', $user->phone_verify_token)
//            ->press('Save')
//                ->waitForLocation('/cabinet/profile')
//            ->assertPathIs('/cabinet/profile')
//            ->assertDontSee('(is not verified)')
//             ->assertSee($user->name)
//                ->assertSee($user->email)
//            ->assertSee('Off');
//            $browser->dump();
//            dd($text);
//
//        });
//
//        $user->delete();
//    }
}

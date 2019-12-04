<?php

namespace Tests\Browser\Cabinet;

use App\Entity\User;
use Carbon\Carbon;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfileTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
//    public function testVisitProfile()
//    {
//        $password = '11111111';
//
//        $user = factory(User::class)->create([
//            'status'=>User::STATUS_ACTIVE,
//            'password'=>bcrypt($password),
//            'role'=>User::ROLE_USER,
//            'email_verified_at'=>Carbon::now()]);
//
//        $this->browse(function (Browser $browser) use ($password, $user){
//            $browser
//                ->driver->manage()->deleteAllCookies();
//            $browser->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/cabinet/profile')
//                ->assertSee($user->name)
//                ->assertPathIs('/cabinet/profile')
//                ->logout();
//
//        });
//        $user->delete();
//    }
//
//    public function testClickEdit()
//    {
//        $password = '11111111';
//
//        $user = factory(User::class)->create([
//            'status'=>User::STATUS_ACTIVE,
//            'password'=>bcrypt($password),
//            'role'=>User::ROLE_USER,
//            'email_verified_at'=>Carbon::now()]);
//
//        $this->browse(function (Browser $browser) use ($password, $user){
//            $browser
//                ->driver->manage()->deleteAllCookies();
//            $browser->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/cabinet/profile')
//                ->assertSee($user->name)
//                ->assertPathIs('/cabinet/profile')
//                ->clickLink('Edit')
//                ->assertPathIs('/cabinet/profile/'.$user->id.'/edit')
//                ->logout();
//        });
//        $user->delete();
//    }
//
//    public function testSaveEdit()
//    {
//        $password = '11111111';
//
//        $user = factory(User::class)->create([
//            'status'=>User::STATUS_ACTIVE,
//            'password'=>bcrypt($password),
//            'role'=>User::ROLE_USER,
//            'email_verified_at'=>Carbon::now()]);
//
//        $this->browse(function (Browser $browser) use ($password, $user){
//            $browser
//                ->driver->manage()->deleteAllCookies();
//            $last_name = 'www';
//            $phone = '80969689934';
//            $browser->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/cabinet/profile/'.$user->id.'/edit')
//                ->assertSee($user->name)
//                ->type('last_name', $last_name)
//                ->type('phone', $phone)
//                ->press('Save')
//                ->assertPathIs('/cabinet/profile')
//                ->assertSee($last_name)
//                ->assertSee($phone)
//                ->logout();
//        });
//        $user->delete();
//    }
//
//    public function testErrorEditPhoneAlreadyExist()
//    {
//        $password = '11111111';
//        $phone ='12345678912';
//
//        $user = factory(User::class)->create([
//            'status'=>User::STATUS_ACTIVE,
//            'password'=>bcrypt($password),
//            'role'=>User::ROLE_USER,
//            'email_verified_at'=>Carbon::now()]);
//
//        $user1 = factory(User::class)->create([
//            'status'=>User::STATUS_ACTIVE,
//            'password'=>bcrypt($password),
//            'role'=>User::ROLE_USER,
//            'phone'=>$phone,
//            'email_verified_at'=>Carbon::now()]);
//
//        $this->browse(function (Browser $browser) use ($password, $user, $user1, $phone){
//            $browser
//                ->driver->manage()->deleteAllCookies();
//            $browser->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/cabinet/profile/'.$user->id.'/edit')
//                ->type('last_name', 'wwww')
//                ->type('phone', $phone)
//                ->press('Save')
//                ->assertSee('The phone has already been taken.')
//                ->logout();
//        });
//        $user->delete();
//        $user1->delete();
//    }
//
//    public function testClickVerify()
//    {
//        $password = '11111111';
//
//        $user = factory(User::class)->create([
//            'status'=>User::STATUS_ACTIVE,
//            'password'=>bcrypt($password),
//            'phone'=>'80991165777',
//            'role'=>User::ROLE_USER,
//            'email_verified_at'=>Carbon::now()]);
//
//        $this->browse(function (Browser $browser) use ($password, $user){
//            $browser
//                ->driver->manage()->deleteAllCookies();
//            $browser->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/cabinet/profile')
//                ->press('Verify')
//                ->assertPathIs('/cabinet/profile/phone')
//                ->logout();
//        });
//
//        $user->delete();
//    }
//    public function testPhoneVerify()
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
//       $this->browse(function (Browser $browser) use ($password, $user){
//           $browser
//               ->driver->manage()->deleteAllCookies();
//       $browser
//            ->loginAs($user)
//             ->assertAuthenticatedAs($user)
//            ->visit('/cabinet/profile/phone')
//            ->assertSee('Token')
//            ->type('token', $user->phone_verify_token)
//            ->press('Save')
//            ->assertPathIs('/cabinet/profile')
//            ->assertDontSee('(is not verified)')
//             ->assertSee($user->name)
//             ->assertSee($user->email)
//             ->assertSee('Off');
//        });
//
//        $user->delete();
//    }

//    public function testPhoneVerifyTokenExpired()
//    {
//        $password = '11111111';
//
//        $user = factory(User::class)->create([
//            'status'=>User::STATUS_ACTIVE,
//            'password'=>bcrypt($password),
//            'phone'=>'80991165787',
//            'role'=>User::ROLE_USER,
//            'phone_verify_token'=>'12345',
//            'phone_verify_token_expire'=>Carbon::now(),
//            'email_verified_at'=>Carbon::now()]);
//
//        $this->browse(function (Browser $browser) use ($password, $user){
//            $browser
//                ->driver->manage()->deleteAllCookies();
//            $browser
//                ->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/cabinet/profile/phone')
//                ->assertSee('Token')
//                ->type('token', $user->phone_verify_token)
//                ->press('Save')
//                ->assertSee('Token is expired.')
//                ->logout();
//        });
//
//        $user->delete();
//    }
//
//    public function testPhoneVerifyTokenIncorrect()
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
//            $browser
//                ->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/cabinet/profile/phone')
//                ->assertSee('Token')
//                ->type('token', $user->phone_verify_token.'1')
//                ->press('Save')
//                ->assertSee('Incorrect verify token.')
//                ->logout();
//        });
//
//        $user->delete();
//    }
//    public function testTwoFactorAuth()
//    {
//                $password = '11111111';
//
//        $user = factory(User::class)->create([
//            'status'=>User::STATUS_ACTIVE,
//            'password'=>bcrypt($password),
//            'phone'=>'80991165787',
//            'role'=>User::ROLE_USER,
//            'phone_verified'=>'1',
//            'email_verified_at'=>Carbon::now()]);
//
//        $this->browse(function (Browser $browser) use ($password, $user){
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser
//                ->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/cabinet/profile')
//                ->press('Off')
//                ->assertSee('On')
//                ->logout();
//        });
//
//        $user->delete();
//    }
}

<?php

namespace Tests\Browser\Cabinet;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Advert\Dialog\Dialog;
use App\Entity\Adverts\Advert\Photo;
use App\Entity\Adverts\Category;
use App\Entity\Region;
use App\Entity\User;
use Carbon\Carbon;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MessagesTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
//    public function testDeleteDialog()
//    {
//        $password = '11111111';
//
//        $user = factory(User::class)->create([
//            'status'=>User::STATUS_ACTIVE,
//            'password'=>bcrypt($password),
//            'phone'=>'80991165787',
//            'role'=>User::ROLE_USER,
//            'phone_verified'=>'1',
//            'email_verified_at'=>Carbon::now()]);
//        $user1 = factory(User::class)->create([
//            'status'=>User::STATUS_ACTIVE,
//            'password'=>bcrypt($password),
//            'phone'=>'80991165787',
//            'role'=>User::ROLE_USER,
//            'phone_verified'=>'1',
//            'email_verified_at'=>Carbon::now()]);
//        $category = factory(Category::class)->create();
//        $region = factory(Region::class)->create();
//        $advert = factory(Advert::class)->create([
//            'region_id'=>$region->id,
//            'category_id'=>$category->id,
//            'user_id'=>$user1->id,
//            'address'=>$region->name,
//            'status'=>'active',
//        ]);
//        $photo = new Photo();
//        $photo->advert_id = $advert->id;
//        $photo->file = 'images/adverts/test.png';
//        $photo->save();
//
//
//
//        $this->browse(function (Browser $browser) use($category, $region, $user,$user1, $advert){
//            $message = 'Test Message';
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser
//                ->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/adverts/show/'.$advert->id)
//                ->scrollTo('.phone-button')
//                ->clickLink('Send Message')
//                ->assertSee('Put your content in this area')
//                ->type('.note-editable.card-block',$message)
//                ->press('Send')
//                ->waitForLocation('/adverts/show/'.$advert->id)
//                ->assertPathIs('/adverts/show/'.$advert->id)
//                ->visit('/cabinet/messages')
//                ->assertSee($advert->title)
//                ->assertSee($user->name)
//                ->click("@delete-dialog")
//                ->pause(3000)
//                ->assertSee('All your dialog')
//                ->assertDontSee($advert->title);
//
//            $category->delete();
//            $region->delete();
//            $user->delete();
//            $user1->delete();
//        });
//    }
//    public function testShowAllMessages()
//    {
//        $password = '11111111';
//
//        $user = factory(User::class)->create([
//            'status'=>User::STATUS_ACTIVE,
//            'password'=>bcrypt($password),
//            'phone'=>'80991165787',
//            'role'=>User::ROLE_USER,
//            'phone_verified'=>'1',
//            'email_verified_at'=>Carbon::now()]);
//
//        $user1 = factory(User::class)->create([
//            'status'=>User::STATUS_ACTIVE,
//            'password'=>bcrypt($password),
//            'phone'=>'80991165787',
//            'role'=>User::ROLE_USER,
//            'phone_verified'=>'1',
//            'email_verified_at'=>Carbon::now()]);
//
//        $category = factory(Category::class)->create();
//        $region = factory(Region::class)->create();
//        $advert = factory(Advert::class)->create([
//            'region_id'=>$region->id,
//            'category_id'=>$category->id,
//            'user_id'=>$user1->id,
//            'address'=>$region->name,
//            'status'=>'active',
//        ]);
//        $photo = new Photo();
//        $photo->advert_id = $advert->id;
//        $photo->file = 'images/adverts/test.png';
//        $photo->save();
//
//
//
//        $this->browse(function (Browser $browser, Browser $browser1) use($category, $region, $user,$user1, $advert){
//            $message = 'Test Message';
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser
//                ->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/adverts/show/'.$advert->id)
//                ->scrollTo('.phone-button')
//                ->clickLink('Send Message')
//                ->assertSee('Put your content in this area')
//                ->type('.note-editable.card-block',$message)
//                ->press('Send')
//                ->waitForLocation('/adverts/show/'.$advert->id)
//                ->assertPathIs('/adverts/show/'.$advert->id)
//                ->visit('/cabinet/messages')
//                ->assertSee($advert->title)
//                ->assertSee($user->name);
//
//            $browser1
//                ->loginAs($user1)
//                ->assertAuthenticatedAs($user1)
//                ->visit('/cabinet/messages')
//                ->assertSee('You have 1 missed message')
//                ->assertSee($advert->title)
//                ->assertSee($user->name)
//                ->clickLink("You have 1 missed message")
//                ->assertSee($message);
//
//             $browser1
//                 ->driver->manage()->deleteAllCookies();
//
//            $category->delete();
//            $region->delete();
//            $user->delete();
//            $user1->delete();
//        });
//    }
//    public function testChat()
//    {
//        $password = '11111111';
//
//        $user = factory(User::class)->create([
//            'status'=>User::STATUS_ACTIVE,
//            'password'=>bcrypt($password),
//            'phone'=>'80991165787',
//            'role'=>User::ROLE_USER,
//            'phone_verified'=>'1',
//            'email_verified_at'=>Carbon::now()]);
//
//        $user1 = factory(User::class)->create([
//            'status'=>User::STATUS_ACTIVE,
//            'password'=>bcrypt($password),
//            'phone'=>'80991165787',
//            'role'=>User::ROLE_USER,
//            'phone_verified'=>'1',
//            'email_verified_at'=>Carbon::now()]);
//
//        $category = factory(Category::class)->create();
//
//        $region = factory(Region::class)->create();
//
//        $advert = factory(Advert::class)->create([
//            'region_id'=>$region->id,
//            'category_id'=>$category->id,
//            'user_id'=>$user1->id,
//            'address'=>$region->name,
//            'status'=>'active',
//        ]);
//
//        $photo = new Photo();
//        $photo->advert_id = $advert->id;
//        $photo->file = 'images/adverts/test.png';
//        $photo->save();
//
//        $dialog = new Dialog();
//        $dialog->advert_id = $advert->id;
//        $dialog->user_id = $user1->id;
//        $dialog->client_id = $user->id;
//        $dialog->user_new_messages = 0;
//        $dialog->client_new_messages = 0;
//        $dialog->created_at = Carbon::now();
//        $dialog->updated_at = Carbon::now();
//        $dialog->save();
//
//        $this->browse(function (Browser $browser) use($category, $region, $user,$user1, $advert){
//            $message = 'Test Message';
//            $message1 = 'Answer';
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser
//                ->loginAs($user1)
//                ->assertAuthenticatedAs($user1)
//                ->visit('/cabinet/messages')
//                ->assertSee($advert->title)
//                ->assertSee($user->name)
//                ->clickLink("You have 0 missed message")
//                ->type('.note-editable',$message)
//                ->scrollTo('.btn')
//                ->press('Send');
//
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser
//                ->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/cabinet/messages')
//                ->assertSee($advert->title)
//                ->assertSee($user->name)
//                ->clickLink("You have 1 missed message")
//                ->assertSee($message)
//                ->type('.note-editable',$message1)
//                ->scrollTo('.btn')
//                ->press('Send');
//
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser
//                ->loginAs($user1)
//                ->assertAuthenticatedAs($user1)
//                ->visit('/cabinet/messages')
//                ->assertSee($advert->title)
//                ->assertSee($user->name)
//                ->clickLink("You have 1 missed message")
//                ->assertSee($message1);
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $category->delete();
//            $region->delete();
//            $user->delete();
//            $user1->delete();
//        });
//    }
}

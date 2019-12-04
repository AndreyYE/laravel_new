<?php

namespace Tests\Browser\Cabinet;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Advert\Dialog\Dialog;
use App\Entity\Adverts\Advert\Photo;
use App\Entity\Adverts\Advert\Value;
use App\Entity\Adverts\Attribute;
use App\Entity\Adverts\Category;
use App\Entity\Region;
use App\Entity\User;
use Carbon\Carbon;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdvertTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
//    public function testChoseCategoryAndRegion()
//    {
//        $password = '11111111';
//
//        $user = factory(User::class)->create([
//            'status'=>User::STATUS_ACTIVE,
//            'password'=>bcrypt($password),
//            'phone'=>'80991165787',
//            'role'=>User::ROLE_ADMIN,
//            'phone_verified'=>'1',
//            'email_verified_at'=>Carbon::now()]);
//        $category = factory(Category::class)->create();
//        $region = factory(Region::class)->create();
//
//        $this->browse(function (Browser $browser) use($user, $category, $region){
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser
//                ->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/cabinet/adverts')
//                ->clickLink('Create Advert')
//                ->waitForLocation('/cabinet/adverts/create')
//                ->assertPathIs('/cabinet/adverts/create')
//                ->clickLink($category->name)
//                ->waitForLocation('/cabinet/adverts/create/region/'.$category->id)
//                ->assertPathIs('/cabinet/adverts/create/region/'.$category->id)
//                ->clickLink($region->name)
//                ->waitForLocation('/cabinet/adverts/create/region/'.$category->id.'/'.$region->id)
//                ->assertPathIs('/cabinet/adverts/create/region/'.$category->id.'/'.$region->id)
//                ->clickLink('Add Advert for '.$region->name)
//                ->waitForLocation('/cabinet/adverts/create/advert/'.$category->id.'/'.$region->id)
//                ->assertSee('Add_Advert');
//            $category->delete();
//            $region->delete();
//            $user->delete();
//        });
//    }
//    public function testSeeForm()
//    {
//        $password = '11111111';
//
//        $user = factory(User::class)->create([
//            'status'=>User::STATUS_ACTIVE,
//            'password'=>bcrypt($password),
//            'phone'=>'80991165787',
//            'role'=>User::ROLE_ADMIN,
//            'phone_verified'=>'1',
//            'email_verified_at'=>Carbon::now()]);
//        $category = factory(Category::class)->create();
//        $region = factory(Region::class)->create();
//
//        $this->browse(function (Browser $browser) use($user, $category, $region){
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser
//                ->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/cabinet/adverts/create/advert/'.$category->id.'/'.$region->id)
//                ->assertSee('Add_Advert');
//            $category->delete();
//            $region->delete();
//            $user->delete();
//        });
//    }
//    public function testStoreSuccess()
//    {
//        $password = '11111111';
//
//        $user = factory(User::class)->create([
//            'status'=>User::STATUS_ACTIVE,
//            'password'=>bcrypt($password),
//            'phone'=>'80991165787',
//            'role'=>User::ROLE_ADMIN,
//            'phone_verified'=>'1',
//            'email_verified_at'=>Carbon::now()]);
//        $category = factory(Category::class)->create();
//        $region = factory(Region::class)->create();
//
//        $attribute_string = new Attribute();
//        $attribute_string->name = 'test_string';
//        $attribute_string->type = 'string';
//        $attribute_string->category_id = $category->id;
//        $attribute_string->required = 1;
//        $attribute_string->variants = 0;
//        $attribute_string->sort = 1;
//        $attribute_string->save();
//
//        $attribute_select = new Attribute();
//        $attribute_select->name = 'test_select';
//        $attribute_select->type = 'integer';
//        $attribute_select->category_id = $category->id;
//        $attribute_select->required = 1;
//        $attribute_select->variants = [1,2,3,4,5];
//        $attribute_select->sort = 2;
//        $attribute_select->save();
//
//        $attribute_number = new Attribute();
//        $attribute_number->name = 'test_number';
//        $attribute_number->type = 'integer';
//        $attribute_number->category_id = $category->id;
//        $attribute_number->required = 1;
//        $attribute_number->variants = 0;
//        $attribute_number->sort = 3;
//        $attribute_number->save();
//
//        $attribute_slider = new Attribute();
//        $attribute_slider->name = 'test_slider';
//        $attribute_slider->type = 'slider';
//        $attribute_slider->category_id = $category->id;
//        $attribute_slider->required = 1;
//        $attribute_slider->variants = [1,100];
//        $attribute_slider->sort = 4;
//        $attribute_slider->save();
//
//
//        $this->browse(function (Browser $browser) use($user, $category, $region, $attribute_string,
//            $attribute_select, $attribute_number, $attribute_slider){
//
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser
//                ->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/cabinet/adverts/create/advert/'.$category->id.'/'.$region->id)
//                ->assertSee('Add_Advert')
//                ->type('title','test_title')
//                ->type('price',100)
//                ->type('content','test_content')
//                ->type('attributes['.$attribute_string->id.']','test_string_attribute')
//                ->type('attributes['.$attribute_number->id.']',11)
//                ->select('attributes['.$attribute_select->id.']',$attribute_select->variants[0])
//                ->dragRight('.irs-handle.single',20)
//                ->scrollTo('.btn')
//                ->press('Save')
//                ->assertSee('Описание');
//
//            $category->delete();
//            $region->delete();
//            $user->delete();
//
//        });
//    }
//
//    public function testListAllAdverts()
//    {
//        $password = '11111111';
//
//        $user = factory(User::class)->create([
//            'status'=>User::STATUS_ACTIVE,
//            'password'=>bcrypt($password),
//            'phone'=>'80991165787',
//            'role'=>User::ROLE_ADMIN,
//            'phone_verified'=>'1',
//            'email_verified_at'=>Carbon::now()]);
//        $category = factory(Category::class)->create();
//        $region = factory(Region::class)->create();
//        $advert = factory(Advert::class)->create([
//            'region_id'=>$region->id,
//            'category_id'=>$category->id,
//            'user_id'=>$user->id,
//            'address'=>$region->name
//        ]);
//
//
//        $this->browse(function (Browser $browser) use($user,$advert){
//
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser
//                ->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/cabinet/adverts')
//                ->assertSee('Create Advert')
//                ->assertSee($advert->title);
//        });
//        $category->delete();
//        $region->delete();
//        $user->delete();
//    }
//
//    public function testShowAdvert()
//    {
//        $password = '11111111';
//
//        $user = factory(User::class)->create([
//            'status'=>User::STATUS_ACTIVE,
//            'password'=>bcrypt($password),
//            'phone'=>'80991165787',
//            'role'=>User::ROLE_ADMIN,
//            'phone_verified'=>'1',
//            'email_verified_at'=>Carbon::now()]);
//        $category = factory(Category::class)->create();
//        $region = factory(Region::class)->create();
//        $advert = factory(Advert::class)->create([
//            'region_id'=>$region->id,
//            'category_id'=>$category->id,
//            'user_id'=>$user->id,
//            'address'=>$region->name
//        ]);
//
//
//        $this->browse(function (Browser $browser) use($user,$advert){
//
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser
//                ->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/adverts/show/'.$advert->id)
//                ->assertSee('It is a draft.');
//        });
//        $category->delete();
//        $region->delete();
//        $user->delete();
//    }
//    public function testAddPhoto()
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
//        $category = factory(Category::class)->create();
//        $region = factory(Region::class)->create();
//        $advert = factory(Advert::class)->create([
//            'region_id'=>$region->id,
//            'category_id'=>$category->id,
//            'user_id'=>$user->id,
//            'address'=>$region->name
//        ]);
//
//
//        $this->browse(function (Browser $browser) use($user,$advert){
//
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser
//                ->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/adverts/show/'.$advert->id)
//                ->assertSee('It is a draft.')
//                ->clickLink('Photos')
//                ->waitForLocation('/cabinet/adverts/'.$advert->id.'/photos')
//                ->assertPathIs('/cabinet/adverts/'.$advert->id.'/photos')
//                ->assertSee('Add Photo- '.$advert->title)
//                ->attach('input.form-control', storage_path('app/test/test.png'))
//                ->press('Upload');
//                $this->assertIsString($advert->photos()->first()->file);
//        });
//        $category->delete();
//        $region->delete();
//        $user->delete();
//    }
//    public function testPublishSuccess()
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
//        $category = factory(Category::class)->create();
//        $region = factory(Region::class)->create();
//        $advert = factory(Advert::class)->create([
//            'region_id'=>$region->id,
//            'category_id'=>$category->id,
//            'user_id'=>$user->id,
//            'address'=>$region->name
//        ]);
//        $photo = new Photo();
//        $photo->advert_id = $advert->id;
//        $photo->file = 'images/adverts/test.png';
//        $photo->save();
//
//        $this->browse(function (Browser $browser) use($user,$advert, $photo){
//
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser
//                ->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/adverts/show/'.$advert->id)
//                ->assertSee('It is a draft.')
//                ->press('Publish')
//                ->assertSee('It is a moderation.');
//        });
//        $category->delete();
//        $region->delete();
//        $user->delete();
//    }
//    public function testPublishError()
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
//        $category = factory(Category::class)->create();
//        $region = factory(Region::class)->create();
//        $advert = factory(Advert::class)->create([
//            'region_id'=>$region->id,
//            'category_id'=>$category->id,
//            'user_id'=>$user->id,
//            'address'=>$region->name
//        ]);
//
//        $this->browse(function (Browser $browser) use($user,$advert){
//
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser
//                ->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/adverts/show/'.$advert->id)
//                ->assertSee('It is a draft.')
//                ->press('Publish')
//                ->assertSee('Upload photos.');
//        });
//        $category->delete();
//        $region->delete();
//        $user->delete();
//    }
//    public function testEditAdvert()
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
//        $category = factory(Category::class)->create();
//        $region = factory(Region::class)->create();
//        $advert = factory(Advert::class)->create([
//            'region_id'=>$region->id,
//            'category_id'=>$category->id,
//            'user_id'=>$user->id,
//            'address'=>$region->name
//        ]);
//
//        $this->browse(function (Browser $browser) use($user,$advert){
//
//            $edit_title = 'title-test-edit';
//            $edit_price = 1000000;
//            $edit_content = 'content_edit_test';
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser
//                ->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/adverts/show/'.$advert->id)
//                ->assertSee('It is a draft.')
//                ->clickLink('Edit')
//                ->waitForLocation('/cabinet/adverts/'.$advert->id.'/edit')
//                ->assertPathIs('/cabinet/adverts/'.$advert->id.'/edit')
//                ->type('title', $edit_title)
//                ->type('price', $edit_price)
//                ->type('content', $edit_content)
//                ->press('Save')
//                ->waitForLocation('/adverts/show/'.$advert->id)
//                ->assertPathIs('/adverts/show/'.$advert->id)
//                ->assertSee($edit_title)
//                ->assertSee($edit_price)
//                ->assertSee($edit_content);
//
//        });
//        $category->delete();
//        $region->delete();
//        $user->delete();
//    }
//
//    public function testDeleteAdvert()
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
//        $category = factory(Category::class)->create();
//        $region = factory(Region::class)->create();
//        $advert = factory(Advert::class)->create([
//            'region_id'=>$region->id,
//            'category_id'=>$category->id,
//            'user_id'=>$user->id,
//            'address'=>$region->name
//        ]);
//
//        $this->browse(function (Browser $browser) use($user,$advert){
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser
//                ->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/adverts/show/'.$advert->id)
//                ->assertSee('It is a draft.')
//                ->press('Delete')
//                ->waitForLocation('/cabinet/adverts')
//                ->assertPathIs('/cabinet/adverts')
//                ->assertDontSee($advert->title);
//
//        });
//        $category->delete();
//        $region->delete();
//        $user->delete();
//    }
//    public function testEditAttributes()
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
//        $category = factory(Category::class)->create();
//        $region = factory(Region::class)->create();
//        $advert = factory(Advert::class)->create([
//            'region_id'=>$region->id,
//            'category_id'=>$category->id,
//            'user_id'=>$user->id,
//            'address'=>$region->name
//        ]);
//
//        $attribute_string = new Attribute();
//        $attribute_string->name = 'test_string';
//        $attribute_string->type = 'string';
//        $attribute_string->category_id = $category->id;
//        $attribute_string->required = 1;
//        $attribute_string->variants = 0;
//        $attribute_string->sort = 1;
//        $attribute_string->save();
//
//        $attribute_select = new Attribute();
//        $attribute_select->name = 'test_select';
//        $attribute_select->type = 'integer';
//        $attribute_select->category_id = $category->id;
//        $attribute_select->required = 1;
//        $attribute_select->variants = [1,2,3,4,5];
//        $attribute_select->sort = 2;
//        $attribute_select->save();
//
//        $attribute_number = new Attribute();
//        $attribute_number->name = 'test_number';
//        $attribute_number->type = 'integer';
//        $attribute_number->category_id = $category->id;
//        $attribute_number->required = 1;
//        $attribute_number->variants = 0;
//        $attribute_number->sort = 3;
//        $attribute_number->save();
//
//        $attribute_slider = new Attribute();
//        $attribute_slider->name = 'test_slider';
//        $attribute_slider->type = 'slider';
//        $attribute_slider->category_id = $category->id;
//        $attribute_slider->required = 1;
//        $attribute_slider->variants = [1,100];
//        $attribute_slider->sort = 4;
//        $attribute_slider->save();
//
//        $value_string = new Value();
//        $value_string->advert_id = $advert->id;
//        $value_string->attribute_id = $attribute_string->id;
//        $value_string->value = 'test_string';
//        $value_string->save();
//
//        $value_select = new Value();
//        $value_select->advert_id = $advert->id;
//        $value_select->attribute_id = $attribute_select->id;
//        $value_select->value = $attribute_select->variants[1];
//        $value_select->save();
//
//        $value_number = new Value();
//        $value_number->advert_id = $advert->id;
//        $value_number->attribute_id = $attribute_number->id;
//        $value_number->value = 102;
//        $value_number->save();
//
//        $value_slider = new Value();
//        $value_slider->advert_id = $advert->id;
//        $value_slider->attribute_id = $attribute_slider->id;
//        $value_slider->value = rand($attribute_slider->variants[0], $attribute_slider->variants[1]);
//        $value_slider->save();
//
//
//        $this->browse(function (Browser $browser) use($user,$advert,$value_string
//            ,$value_select,$value_number,$attribute_select
//        ){
//            $new_string = 'editor_string_test';
//            $new_number = 202;
//            $new_select = $attribute_select->variants[3];
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser
//                ->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/adverts/show/'.$advert->id)
//                ->assertSee('It is a draft.')
//                ->clickLink('Edit Attributes')
//                ->waitForLocation('/cabinet/adverts/'.$advert->id.'/attributes')
//                ->assertPathIs('/cabinet/adverts/'.$advert->id.'/attributes')
//                ->assertInputValue('#attribute_'.$value_number->attribute_id,$value_number->value)
//                ->assertSee($value_string->value)
//                ->assertSee($value_select->value)
//                ->type('attributes['.$value_string->attribute_id.']',$new_string)
//                ->type('attributes['.$value_number->attribute_id.']',$new_number)
//                ->select('attributes['.$value_select->attribute_id.']',$new_select)
//                ->press('Save')
//                ->visit('/adverts/show/'.$advert->id)
//                ->waitForLocation('/adverts/show/'.$advert->id)
//                ->assertPathIs('/adverts/show/'.$advert->id)
//                ->assertSee($new_string)
//                ->assertSee($new_number)
//                ->assertSee($new_select)
//            ;
//
//        });
//        $category->delete();
//        $region->delete();
//        $user->delete();
//    }
//    public function testSendMessage()
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
//        $this->browse(function (Browser $browser) use($user,$user1, $advert){
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
//                ->assertPathIs('/adverts/show/'.$advert->id);
//
//            $dialog = Dialog::where('user_id', $user1->id)->where('client_id',$user->id)->where('advert_id',$advert->id)->first();
//            $messageInDB = \App\Entity\Adverts\Advert\Dialog\Message::where('dialog_id',$dialog->id)->first()->message;
//            $this->assertEquals($message, $messageInDB);
//
//        });
//        $category->delete();
//        $region->delete();
//        $user->delete();
//        $user1->delete();
//    }
//    public function testShowPhoneNumber()
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
//        $this->browse(function (Browser $browser) use($user,$user1, $advert){
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $text = $browser
//                ->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/adverts/show/'.$advert->id)
//                ->scrollTo('.phone-button')
//                ->click('.phone-button')
//                ->pause(2000)
//                ->text('.number');
//
//                $this->assertEquals($text, $user1->phone);
//        });
//        $category->delete();
//        $region->delete();
//        $user->delete();
//        $user1->delete();
//    }
//    public function testAddFavorite()
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
//        $this->browse(function (Browser $browser) use($user,$user1, $advert){
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser
//                ->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/adverts/show/'.$advert->id)
//                ->scrollTo('.phone-button')
//                ->press('Add to Favorites')
//                ->assertSee('Advert is added to your favorites.');
//
//        });
//        $category->delete();
//        $region->delete();
//        $user->delete();
//        $user1->delete();
//    }
//    public function testRemoveFavorite()
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
//        $user->favorites()->attach($advert->id);
//
//
//
//        $this->browse(function (Browser $browser) use($user,$user1, $advert){
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser
//                ->loginAs($user)
//                ->assertAuthenticatedAs($user)
//                ->visit('/adverts/show/'.$advert->id)
//                ->scrollTo('.phone-button')
//                ->press('Remove from Favorites')
//                ->assertSee('Add to Favorites');
//
//        });
//        $category->delete();
//        $region->delete();
//        $user->delete();
//        $user1->delete();
//    }
}

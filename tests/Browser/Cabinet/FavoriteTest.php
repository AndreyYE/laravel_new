<?php

namespace Tests\Browser\Cabinet;


use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Advert\Photo;
use App\Entity\Adverts\Category;
use App\Entity\Region;
use App\Entity\User;
use Carbon\Carbon;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoriteTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
//    public function testDeleteFavoriteAdvert()
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
//                ->assertSee('Advert is added to your favorites.')
//                ->visit('/cabinet/favorites')
//                ->assertSee($advert->title)
//                ->press('Remove')
//                ->assertDontSee($advert->title);
//
//        });
//        $category->delete();
//        $region->delete();
//        $user->delete();
//        $user1->delete();
//    }
}

<?php

use App\Entity\Adverts\Advert\Dialog\Dialog;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use App\Entity\User;
use App\Entity\Region;
use App\Entity\Adverts\Category;
use App\Entity\Adverts\Attribute;
use Illuminate\Http\Request;
use App\Http\Router\AdvertsPath;
use Illuminate\Support\Facades\Cache;
use App\Entity\Page;
use App\Entity\Adverts\Advert\Advert;


Breadcrumbs::for('slider', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->push('Home', route('home'));
});


// Home
Breadcrumbs::for('home', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->push('Home', route('home'));
});

// Home > Login
Breadcrumbs::for('login', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Login', route('login'));
});

// Home > Register
Breadcrumbs::for('register', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Register', route('register'));
});

// Home > Login > Password_reset
Breadcrumbs::for('password.request', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('login');
    $crumbs->push('Password_Reset', route('password.request'));
});

// Home > Login > Password_reset > Change
Breadcrumbs::for('password.reset', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('password.request');
    $crumbs->push('Change', route('password.reset'));
});


Breadcrumbs::for('page', function (BreadcrumbsGenerator $crumbs) {
    $page =  Page::where('id',\request()->input('id'))->with('ancestors')->get();
    $crumbs->parent('home');
    if($page[0]->ancestors->count()){
        foreach ($page[0]->ancestors as $value){
         $crumbs->push($value->title, route('page',['id'=>$value->id]));
            var_dump($value->title);
        }
    }
    $crumbs->push($page[0]->title, route('page'));
});

//Message
Breadcrumbs::for('adverts.form.send.message', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('adverts.show', Advert::findOrFail(  \request()->input('advert')));
    $crumbs->push('Send Message', route('adverts.form.send.message', \request()->input('advert')));
});
// Home > Cabinet
Breadcrumbs::for('cabinet', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Cabinet', route('cabinet'));
});

// Home > email_verify
Breadcrumbs::for('verification.notice', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Verify_Email', route('verification.notice'));
});

// Home > email_verify
Breadcrumbs::for('valid.notice', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Valid_Notice', route('valid.notice'));
});

// Home > Admin Panel
Breadcrumbs::for('admin.home', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Admin_Panel', route('admin.home'));
});

// Users
Breadcrumbs::register('admin.users.index', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Users', route('admin.users.index'));
});
Breadcrumbs::register('admin.users.create', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('admin.users.index');
    $crumbs->push('Create', route('admin.users.create'));
});
Breadcrumbs::register('admin.users.show', function (BreadcrumbsGenerator $crumbs, User $user) {
    $crumbs->parent('admin.users.index');
    $crumbs->push($user->name, route('admin.users.show', $user));
});
Breadcrumbs::register('admin.users.edit', function (BreadcrumbsGenerator $crumbs, User $user) {
    $crumbs->parent('admin.users.show', $user);
    $crumbs->push('Edit', route('admin.users.edit', $user));
});
Breadcrumbs::register('admin.advert.adverts.index', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Admin Advert', route('admin.advert.adverts.index'));
});

// Regions
Breadcrumbs::register('admin.regions.index', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Regions', route('admin.regions.index'));
});
Breadcrumbs::register('admin.regions.create', function (BreadcrumbsGenerator $crumbs) {
    if(isset($_GET['parent'])){
        $region = (new Region())->find($_GET['parent']);
        $crumbs->parent('admin.regions.show', $region);
    }else{
        $crumbs->parent('admin.regions.index');
    }
    $crumbs->push('Create', route('admin.regions.create'));
});
Breadcrumbs::register('admin.regions.show', function (BreadcrumbsGenerator $crumbs, Region $region) {
    if($region->parent){
        $crumbs->parent('admin.regions.show', $region->parent);
    }else{
        $crumbs->parent('admin.regions.index');
    }
    $crumbs->push($region->name, route('admin.regions.show', $region));
});
Breadcrumbs::register('admin.regions.edit', function (BreadcrumbsGenerator $crumbs, Region $region) {
    if($region->parent){
        $crumbs->parent('admin.regions.show', $region->parent);
    }else{
        $crumbs->parent('admin.regions.show', $region);
    }
    $crumbs->push('Edit', route('admin.regions.edit', $region));
});

// Categories
Breadcrumbs::register('admin.advert.categories.index', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Categories', route('admin.advert.categories.index'));
});
Breadcrumbs::register('admin.advert.categories.create', function (BreadcrumbsGenerator $crumbs) {
    if(isset($_GET['parent'])){
        $region = (new \App\Entity\Adverts\Category())->find($_GET['parent']);
        $crumbs->parent('admin.advert.categories.show', $region);
    }else{
        $crumbs->parent('admin.advert.categories.index');
    }
    $crumbs->push('Create', route('admin.advert.categories.create'));
});
Breadcrumbs::register('admin.advert.categories.show', function (BreadcrumbsGenerator $crumbs, Category $category) {
    if($category->parent_id){
        $crumbs->parent('admin.advert.categories.show', $category->find($category->parent_id));
    }else{
        $crumbs->parent('admin.advert.categories.index');
    }
    $crumbs->push($category->name, route('admin.advert.categories.show', $category));
});
Breadcrumbs::register('admin.advert.categories.edit', function (BreadcrumbsGenerator $crumbs, Category $category) {
    if($category->parent_id){
        $crumbs->parent('admin.advert.categories.show', $category->find($category->parent_id));
    }else{
        $crumbs->parent('admin.advert.categories.show', $category);
    }
    $crumbs->push('Edit', route('admin.advert.categories.edit', $category));
});

// Attributes
Breadcrumbs::register('admin.advert.categories.attributes.create', function (BreadcrumbsGenerator $crumbs, Category $category) {
    $crumbs->parent('admin.advert.categories.show', $category);
    $crumbs->push('Create', route('admin.advert.categories.attributes.create',$category));
});
Breadcrumbs::register('admin.advert.categories.attributes.show', function (BreadcrumbsGenerator $crumbs, Category $category, Attribute $attribute) {
    if($category){
        $crumbs->parent('admin.advert.categories.show', $category);
    }else{
        $crumbs->parent('admin.advert.categories.index');
    }
    $crumbs->push($attribute->name, route('admin.advert.categories.attributes.show', [$category,$attribute]));
});
Breadcrumbs::register('admin.advert.categories.attributes.edit', function (BreadcrumbsGenerator $crumbs, Category $category, Attribute $attribute) {

    $crumbs->parent('admin.advert.categories.show', $category);
    $crumbs->push('Edit', route('admin.advert.categories.attributes.edit', [$category, $attribute]));
});
Breadcrumbs::register('admin.advert.adverts.attributes', function (BreadcrumbsGenerator $crumbs, Advert $advert) {

    $crumbs->parent('adverts.show', $advert);
    $crumbs->push('Edit Attributes', route('admin.advert.adverts.attributes', $advert));
});

//Pages
Breadcrumbs::register('admin.pages.index', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Pages', route('admin.pages.index'));
});
Breadcrumbs::register('admin.pages.create', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Create Page', route('admin.pages.create'));
});
Breadcrumbs::register('admin.pages.show', function (BreadcrumbsGenerator $crumbs, Page $page) {
    $crumbs->parent('admin.home');
    $crumbs->push('Show Page', route('admin.pages.show',$page));
});
Breadcrumbs::register('admin.pages.edit', function (BreadcrumbsGenerator $crumbs, Page $page) {
    $crumbs->parent('admin.home');
    $crumbs->push('Edit Page', route('admin.pages.edit',$page));
});
// Admin -> Promo
Breadcrumbs::for('admin.promo.index', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Promoted adverts', route('admin.promo.index'));
});
Breadcrumbs::for('admin.promo.edit', function (BreadcrumbsGenerator $crumbs, Advert $advert) {
    $crumbs->parent('admin.promo.index');
    $crumbs->push('Edit promo advert', route('admin.promo.edit',$advert));
});
Breadcrumbs::for('admin.promo.create', function (BreadcrumbsGenerator $crumbs, Advert $advert) {
    $crumbs->parent('admin.promo.index');
    $crumbs->push('Create promo - '.$advert->title, route('admin.promo.create',$advert));
});

// Cabinet
Breadcrumbs::register('cabinet.home', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->push('Home', route('home'));
});
Breadcrumbs::register('cabinet.profile.index', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('cabinet.home');
    $crumbs->push('Profile', route('cabinet.profile.index'));
});
Breadcrumbs::register('cabinet.profile.edit', function (BreadcrumbsGenerator $crumbs,  $user) {
    $crumbs->parent('cabinet.profile.index');
    $crumbs->push('Edit', route('cabinet.profile.edit', $user));
});
Breadcrumbs::register('cabinet.profile.phone', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('cabinet.profile.index');
    $crumbs->push('Phone Verify', route('cabinet.profile.phone'));
});
Breadcrumbs::register('cabinet.messages.index', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('cabinet.home');
    $crumbs->push('All your dialog', route('cabinet.messages.index'));
});
Breadcrumbs::register('cabinet.messages.all', function (BreadcrumbsGenerator $crumbs) {
    $user = Auth::id();
    $allDialogs = Dialog::where('user_id',$user)->orWhere('client_id',$user)->with(['client','messages','advert'])->get();
    $crumbs->parent('cabinet.messages.index',compact('allDialogs'));
    $crumbs->push('Your correspondence', route('cabinet.messages.all',['dialog'=>\request()->input('dialog')]));
});
Breadcrumbs::register('cabinet.promo.index', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('cabinet.home');
    $crumbs->push('All Promotion', route('cabinet.promo.index'));
});
Breadcrumbs::register('cabinet.promo.create', function (BreadcrumbsGenerator $crumbs,  Advert $advert) {
    $crumbs->parent('cabinet.adverts.index');
    $crumbs->push('Create Promotion - '.$advert->title, route('cabinet.promo.create', $advert));
});

//Advert Cabinet
Breadcrumbs::register('cabinet.profile.adverts.index', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('cabinet.home');
    $crumbs->push('Advert', route('cabinet.profile.adverts.index'));
});
Breadcrumbs::register('cabinet.adverts.edit', function (BreadcrumbsGenerator $crumbs, \App\Entity\Adverts\Advert\Advert $advert) {
    $crumbs->parent('adverts.show', $advert);
    $crumbs->push('Edit- '.$advert->title, route('cabinet.adverts.edit', $advert));
});
Breadcrumbs::register('cabinet.adverts.photos', function (BreadcrumbsGenerator $crumbs, \App\Entity\Adverts\Advert\Advert $advert) {
    $crumbs->parent('adverts.show', $advert);
    $crumbs->push('Add Photo- '.$advert->title, route('cabinet.adverts.photos', $advert));
});
Breadcrumbs::register('cabinet.adverts.index', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('cabinet.home');
    $crumbs->push('Advert', route('cabinet.adverts.index'));
});
Breadcrumbs::register('cabinet.favorites.index', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('cabinet.home');
    $crumbs->push('Favorites', route('cabinet.favorites.index'));
});
// Cabinet_Create_Advert

Breadcrumbs::register('cabinet.adverts.create', function (BreadcrumbsGenerator $crumbs) {
    $crumbs->parent('cabinet.home');
    $crumbs->push('Choose_Category', route('cabinet.adverts.create'));
});
Breadcrumbs::register('cabinet.adverts.create.region', function (BreadcrumbsGenerator $crumbs, Category $category, Region $region=null) {

//    if($region){
//        $crumbs->parent('cabinet.adverts.create.region',$category, $region);
//    }else{
        $crumbs->parent('cabinet.adverts.create');
//    }

    $crumbs->push($region ? $region->name : 'Choose_Region', route('cabinet.adverts.create.region',[$category, $region]));
});
Breadcrumbs::register('cabinet.adverts.create.advert', function (BreadcrumbsGenerator $crumbs, Category $category, Region $region=null) {

    $crumbs->parent('cabinet.adverts.create.region', $category, $region);
    $crumbs->push('Add_Advert', route('cabinet.adverts.create.advert',$category, $region));
});
//Breadcrumbs::register('cabinet.profile.phone', function (BreadcrumbsGenerator $crumbs) {
//    $crumbs->parent('cabinet.profile.index');
//    $crumbs->push('Phone Verify', route('cabinet.profile.phone'));
//});

//Advert
Breadcrumbs::register('adverts.inner_region', function (BreadcrumbsGenerator $crumbs, AdvertsPath $path) {
    if ($path->region && $parent = $path->region->parent) {
        $crumbs->parent('adverts.inner_region', $path->withRegion($parent));
    } else {
        $crumbs->parent('home');
        $crumbs->push('Adverts', route('adverts.index'));
    }
    if ($path->region) {
        $crumbs->push($path->region->name, route('adverts.index', $path));
    }
});
Breadcrumbs::register('adverts.inner_category', function (BreadcrumbsGenerator $crumbs, AdvertsPath $path, AdvertsPath $orig) {
    if ($path->category && $parent = $path->category->parent) {
        $crumbs->parent('adverts.inner_category', $path->withCategory($parent), $orig);
    } else {
        $crumbs->parent('adverts.inner_region', $orig);
    }
    if ($path->category) {
        $crumbs->push($path->category->name, route('adverts.index', $path));
    }
});
Breadcrumbs::register('adverts.index', function (BreadcrumbsGenerator $crumbs, AdvertsPath $path = null) {
    $path = $path ?: adverts_path(null, null);
    $crumbs->parent('adverts.inner_category', $path, $path);
});
Breadcrumbs::register('adverts.show', function (BreadcrumbsGenerator $crumbs, \App\Entity\Adverts\Advert\Advert $advert) {
    $crumbs->parent('cabinet.home');
    $crumbs->push($advert->title, route('adverts.show', $advert));
});
Breadcrumbs::register('adverts.my_advert', function (BreadcrumbsGenerator $crumbs, $category, $region) {
    $crumbs->parent('home');
    $cat = Cache::tags(['CategoryAncestors'])->rememberForever('CategoryAncestors_'.$category,function() use ($category){
        return Category::findOrFail($category)->ancestors()->get()->toArray();
    });
    if($region === 'allRegions'){
        foreach ($cat as $val){
            $crumbs->push($val['name'], route('adverts.my_advert', ['category'=>$val?$val['id']:'allCategories','region'=>$region!=='allRegions'?$region:'allRegions']));
        }
    }
    if($region !== 'allRegions'){
        $reg = Cache::tags(['RegionAncestors'])->rememberForever('RegionAncestors_'.$region, function() use($region) {
            $regions = Region::findOrFail($region)->getAllParent();
            return $regions;
        });
        $allRegions = explode(",", $reg);
        array_shift($allRegions);
        foreach ($allRegions as $val1){
            $regio = Region::findOrFail($val1);
            $crumbs->push($regio['name'], route('adverts.my_advert', ['category'=>$category ? $category:'allCategories','region'=>$val1 ? $regio['id'] : 'allRegions']));
        }
        foreach ($cat as $val){
            $crumbs->push($val['name'], route('adverts.my_advert', ['category'=>$val?$val['id']:'allCategories','region'=>$region!=='allRegions'?$region:'allRegions']));
        }
    }
    $crumbs->push(Category::findOrFail($category)->name, route('adverts.my_advert', ['category'=>$category?$category:'allCategories','region'=>$region!=='allRegions'?$region:'allRegions']));
});

//Admin-Advert
Breadcrumbs::register('admin.advert.adverts.edit', function (BreadcrumbsGenerator $crumbs, \App\Entity\Adverts\Advert\Advert $advert) {
    $crumbs->parent('adverts.show', $advert);
    $crumbs->push('Admin Edit- '.$advert->title, route('admin.advert.adverts.edit', $advert));
});
Breadcrumbs::register('admin.advert.adverts.photos', function (BreadcrumbsGenerator $crumbs, \App\Entity\Adverts\Advert\Advert $advert) {
    $crumbs->parent('adverts.show', $advert);
    $crumbs->push('Admin Photo- '.$advert->title, route('admin.advert.adverts.photos', $advert));
});
Breadcrumbs::register('admin.advert.adverts.reject', function (BreadcrumbsGenerator $crumbs, \App\Entity\Adverts\Advert\Advert $advert) {
    $crumbs->parent('adverts.show', $advert);
    $crumbs->push('Reject- '.$advert->title, route('admin.advert.adverts.reject', $advert));
});
Breadcrumbs::register('cabinet.adverts.attributes', function (BreadcrumbsGenerator $crumbs, \App\Entity\Adverts\Advert\Advert $advert) {
    $crumbs->parent('adverts.show', $advert);
    $crumbs->push('Edit Attributes- '.$advert->title, route('cabinet.adverts.attributes', $advert));
});

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');

Auth::routes(['verify' => true]);
/*Socialite*/
Route::get('login/facebook', 'Auth\Services\FacebookController@redirectToProvider')->name('network.facebook');
Route::get('login/facebook/callback', 'Auth\Services\FacebookController@handleProviderCallback');

Route::get('/elastic', 'Adverts\AdvertController@elastic');
Route::get('/slider', function (){
    return view('slider');
})->name('slider');

//Adverts
Route::group([
    'prefix' => 'adverts',
    'as' => 'adverts.',
    'namespace' => 'Adverts',
], function () {
    Route::get('/show/{advert}', 'AdvertController@show')->name('show');
    Route::get('/{category}/{region}', 'AdvertController@index')->name('my_advert');
    Route::post('/changeCategory', 'AdvertController@changeCategory')->name('changeCategory');
    Route::post('/search', 'AdvertController@search')->name('my_advert.search');
    Route::post('/clickAdvert/{advert}','AdvertController@clickAdvert')->name('clickAdvert');
    Route::post('/ajax/view/{advert}', 'AdvertController@view')->name('view');
    Route::post('ajax/setFlashMessage','AdvertController@flashMessage')->name('setFlashMessage');
    Route::group(['middleware' => ['auth']],function(){
        Route::get('/send_message','MessageController@form')->name('form.send.message');
        Route::post('/send_message/{advert}','MessageController@send')->name('send.message');

        Route::get('/show/{advert}/phone', 'AdvertController@phone')->name('phone');
        Route::post('/show/{advert}/favorites', 'FavoriteController@add')->name('favorites');
        Route::delete('/show/{advert}/favorites', 'FavoriteController@remove');
    });
});

// Cabinet
Route::group([
    'prefix' => 'cabinet',
    'as' => 'cabinet.',
    'middleware' => ['verified'],
    'namespace' => 'Cabinet'
],function(){
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('/profile', 'ProfileController')->except(['destroy','show','create','store']);
    Route::get('favorites', 'FavoriteController@index')->name('favorites.index');
    Route::delete('favorites/{advert}', 'FavoriteController@remove')->name('favorites.remove');
    Route::get('/messages','MessageController@index')->name('messages.index');
    Route::get('/delete','MessageController@delete')->name('messages.delete');
    Route::get('/showAllMessages','MessageController@showAllMessages')->name('messages.all');
    Route::post('/send_message/{dialog}','MessageController@send')->name('send.message');
    // Cabinet/Advert
    Route::group([
        'prefix' => 'adverts',
        'as' => 'adverts.',
        'namespace' => 'Adverts',
        'middleware' => ['verified'],
    ], function () {
        Route::get('/', 'AdvertController@index')->name('index');

        Route::get('/create', 'CreateController@category')->name('create');
        Route::get('/create/region/{category}/{region?}', 'CreateController@region')->name('create.region');
        Route::get('/create/advert/{category}/{region?}', 'CreateController@advert')->name('create.advert');
        Route::post('/create/advert/{category}/{region?}', 'CreateController@store')->name('create.advert.store');

        Route::get('/{advert}/edit', 'ManageController@editForm')->name('edit');
        Route::put('/{advert}/edit', 'ManageController@edit');
        Route::get('/{advert}/photos', 'ManageController@photosForm')->name('photos');
        Route::post('/{advert}/photos', 'ManageController@photos');
        Route::get('/{advert}/attributes', 'ManageController@attributesForm')->name('attributes');
        Route::post('/{advert}/attributes', 'ManageController@attributes');
        Route::post('/{advert}/send', 'ManageController@send')->name('send');
        Route::post('/{advert}/close', 'ManageController@close')->name('close');
        Route::delete('/{advert}/destroy', 'ManageController@destroy')->name('destroy');
    });
    //Cabinet/Promotion
    Route::group([
        'prefix' => 'promo',
        'as' => 'promo.',
        'namespace' => 'Promo',
        'middleware' => ['verified'],
    ], function () {
        Route::get('/', 'CreateController@index')->name('index');
        Route::get('/create/{advert}', 'CreateController@create')->name('create');
        Route::get('/pay/{advert}', 'CreateController@pay')->name('pay');

    });
    // Cabinet/Profile
    Route::group([
        'prefix' => 'profile',
        'as' => 'profile.',
    ],function (){
        Route::post('/verify', 'PhoneController@verify')->name('phone.verify');
        Route::post('/phone','PhoneController@request')->name('post');
        Route::get('/phone','PhoneController@form')->name('phone');
        Route::post('/phone/auth','PhoneController@auth')->name('phone.auth');
    });
});

Route::get('/mail','ExController@index')->name('mail');

//AdminPanel
Route::group(
    [
        'prefix'=>'admin',
        'middleware'=>['verified', 'can:admin-panel'],
        'namespace'=>'Admin',
        'as'=>'admin.'
    ]
    ,function(){
    Route::post('/ajax/upload/image', 'UploadController@image')->name('ajax.upload.image');
    Route::post('/ajax/delete/image', 'PageController@deleteImages')->name('ajax.delete.image');
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('users/drop', 'UsersController@drop')->name('users.drop');
    Route::resource('users', 'UsersController');
    Route::post('/users/{user}/verify', 'UsersController@verify')->name('users.verify');

    Route::resource('/regions', 'RegionController');

    Route::resource('pages', 'PageController');

    Route::group([
        'prefix' => 'promo',
        'as' => 'promo.',
        'namespace' => 'Promo'
    ], function () {
        Route::get('/', 'PromoController@index')->name('index');
        Route::get('/close/{advert}', 'PromoController@close')->name('close');
        Route::get('/edit/{advert}', 'PromoController@edit')->name('edit');
        Route::post('/edit/{advert}', 'PromoController@saveEdit')->name('save.edit');
        Route::get('/create/{advert}', 'PromoController@create')->name('create');
        Route::post('/store/{advert}', 'PromoController@store')->name('store');
    });

    Route::group(['prefix' => 'pages/{page}', 'as' => 'pages.'], function () {
        Route::post('/first', 'PageController@first')->name('first');
        Route::post('/up', 'PageController@up')->name('up');
        Route::post('/down', 'PageController@down')->name('down');
        Route::post('/last', 'PageController@last')->name('last');
    });

    Route::group(
        [
            'prefix'=>'advert',
            'middleware'=>['verified', 'can:admin-panel'],
            'namespace'=>'Adverts',
            'as'=>'advert.'
        ],function(){
        Route::resource('/categories', 'CategoryController');
        Route::group(
            [
                'prefix'=>'categories/{category}',
                'middleware'=>['verified', 'can:admin-panel'],
                'as'=>'categories.'
            ],
        function(){
                    Route::resource('/attributes','AttributeController')->except('index');
                    Route::post('first', 'CategoryController@first')->name('first');
                    Route::post('/up', 'CategoryController@up')->name('up');
                    Route::post('/down', 'CategoryController@down')->name('down');
                    Route::post('/last', 'CategoryController@last')->name('last');
            }
        );
        Route::group(['prefix' => 'adverts', 'as' => 'adverts.'], function () {
            Route::get('/', 'AdvertController@index')->name('index');
            Route::get('/{advert}/edit', 'AdvertController@editForm')->name('edit');
            Route::put('/{advert}/edit', 'AdvertController@edit');
            Route::get('/{advert}/photos', 'AdvertController@photosForm')->name('photos');
            Route::post('/{advert}/photos', 'AdvertController@photos');
            Route::get('/{advert}/attributes', 'AdvertController@attributesForm')->name('attributes');
            Route::post('/{advert}/attributes', 'AdvertController@attributes');
            Route::post('/{advert}/moderate', 'AdvertController@moderate')->name('moderate');
            Route::get('/{advert}/reject', 'AdvertController@rejectForm')->name('reject');
            Route::post('/{advert}/reject', 'AdvertController@reject');
            Route::delete('/{advert}/destroy', 'AdvertController@destroy')->name('destroy');
        });
    }
    );
});

Route::get('page', 'Page\PageController@show')->name('page');

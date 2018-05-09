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

Route::get('/', function () {
    return view('welcome');
});

Route::get('mow/{userId}', 'EatingsManager@mow');

Route::get('mfd/{id}/{day}', 'EatingsManager@mfd');

Route::get('eat/{id}/{userId}', 'EatingsManager@getEatingByID');

Route::get('random/{type}/{key}', 'EatingsManager@random');

Route::get('option/{type}', 'EatingsManager@option');

Route::get('mat', 'EatingsManager@mat');

Route::get('et', 'EatingsManager@et');

Route::get('es/{type}', 'EatingsManager@es');

Route::get('fav/{type}', 'EatingsManager@fav');




//---------------------------

Route::get('login/{username}/{password}', 'AccountManager@login');

Route::get('register/{username}/{password}/{fullname}', 'AccountManager@register');

Route::get('changefullname/{username}/{fullname}', 'AccountManager@changeFullname');

Route::get('changepassword/{username}/{password}', 'AccountManager@changePassword');

//---

Route::get('notify/{userId}', 'Notification@notify');

//---

Route::get('eatings/{id}/{idUser}', 'EatingManager@getEatingByID');

Route::get('eatingrandom/{type}/{key}', 'EatingManager@getEatingRandom');

Route::get('eatingsoption/{type}', 'EatingManager@getEatingsOption');

Route::get('eatingbytype/{type}', 'EatingManager@getEatingByType');

Route::get('eatingbytype/{type}/{limit}', 'EatingManager@getEatingByTypeLimit100');

Route::get('eatingtype', 'EatingManager@getEatingsType');

Route::get('addmenu/{name}/{info}/{days}/{meals}/{idCreator}/{ids}', 'EatingManager@addMenu');

Route::get('editmenu/{id}/{day}/{meals}/{ids}', 'EatingManager@editMenu');

Route::get('menuofweek/{idUser}', 'EatingManager@getMenuofWeek');

Route::get('material', 'EatingManager@getMaterial');

Route::get('listmenu/{id}', 'EatingManager@getMenubyUserID');

Route::get('listmenu1/{id}', 'EatingManager@getMenuRatedbyUserID');

Route::get('menu/{id}', 'EatingManager@getMenubyID');

Route::get('listeating/{id}', 'EatingManager@getEatingbyUserID');

Route::get('listeating1/{id}', 'EatingManager@getEatingRatedbyUserID');

Route::get('news', 'News@getNews');

Route::get('news/{id}', 'News@getNewsbyID');

Route::get('adddevice/{device}', 'Notification@addDevice');

Route::get('sendmessage/{type}', 'Notification@sendMessage');

Route::get('addnotifyforuser/{idN}/{idU}/{mId}/{day}/{meal}', 'Notification@addNotifyforUser');

Route::get('materialformeal/{menuId}/{day}/{meal}', 'Notification@getMaterialforMeal');


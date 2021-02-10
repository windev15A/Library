<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//
Route::middleware('auth:api')->get('getAuthUser', 'API\UsersController@getAuthUser');


Route::apiResources([
    'user'     => 'API\UsersController',
    'livres'     => 'API\LivreController',
    'categories' => 'API\CategorieController',
    'auteurs'    => 'API\AuteurController',
    'adherents'  => 'API\AdherentController',
    'adherentLivre' => 'API\EmpruntController'
]);

Route::middleware('auth:api')->group(function () {
    Route::get('getArchives/{id}', 'API\EmpruntController@getArchives');
    Route::get('getStatistic', 'API\DashboardController@getStatistic');
    Route::get('searchLivre', 'API\SearchController@searchLivre');
    Route::get('searchAdherent', 'API\SearchController@searchAdherent');
    Route::get('getCategories', 'API\SearchController@getCategories');
    Route::get('getAuteurs', 'API\SearchController@getAuteurs');
    Route::get('getLivreByCat', 'API\SearchController@getLivreByCat');
    Route::get('getLivreByAuteur', 'API\SearchController@getLivreByAuteur');
});

Route::post('doPayment', 'API\PaymentController@doPayment');
// ---------- Api pour une application react native -----------------//
Route::prefix('v1')->group(function(){
    Route::post('login', 'API\MemberController@login');
    Route::post('register', 'API\MemberController@register');


    Route::group(['middleware' => 'auth:adherent-api'], function(){
        Route::get('getAdherent', 'API\MemberController@getMember');
        Route::post('logout', 'API\MemberController@logout');
        Route::put( "update/{id}",  'API\AdherentController@update');
    });
});

<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
    return redirect()->route('dashboard');
});


Route::group(['prefix' => 'addresses', 'namespace' => 'Addresses'], function(){
    Route::get('countries', 'AddressController@getCountries')->name('addresses::countries');
    Route::get('cities', 'AddressController@getCities')->name('addresses::cities');
    Route::get('municipalites', 'AddressController@getMunicipalites')->name('addresses::municipalites');
    Route::get('neighborhoodes', 'AddressController@getNeighborhoodes')->name('addresses::neighborhoodes');
});

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => 'locale'], function() {

    Route::group(['middleware' => 'web', 'namespace' => 'Auth'], function(){
        Route::get('login', 'RegistrationController@form')->name('login');
        Route::post('login', 'RegistrationController@login');
        Route::post('logout', 'RegistrationController@logout')->name('logout');
    });

    Route::group(['prefix' => 'admin', 'middleware' => 'web'], function(){
        Route::get('/', 'BaseController@index')->name('dashboard');
        Route::group(['prefix' => 'users', 'namespace' => 'Users'], function(){
            Route::get('u/{type}', 'UsersController@index')->name('users');
            Route::get('users_data', 'UsersController@data')->name('users::data');
            Route::get('create/{type}', 'UsersController@create')->name('users::create');
            Route::post('store/{type}', 'UsersController@store')->name('users::store');
            Route::get('edit/{id}/{type}', 'UsersController@show')->name('users::edit');
            Route::post('e/store', 'UsersController@update')->name('users::e-store');
            Route::post('soft_delete/{id}', 'UsersController@softDelete')->name('users::soft_delete');
            Route::post('delete/{id}', 'UsersController@delete')->name('users::delete');
            Route::post('restore/{id}', 'UsersController@restore')->name('users::restore');
        });

        Route::group(['prefix' => 'actions', 'namespace' => 'Categories'], function(){
            Route::get('', 'CategoriesController@index')->name('actions');
            Route::get('generateCode', 'CategoriesController@generateCode')->name('categories::generateCode');
            Route::get('categories_data', 'CategoriesController@data')->name('categories::data');
            Route::get('create', 'CategoriesController@create')->name('categories::create');
            Route::post('store', 'CategoriesController@store')->name('categories::store');
            Route::get('edit/{id}', 'CategoriesController@show')->name('categories::edit');
            Route::post('e/store', 'CategoriesController@update')->name('categories::e-store');
            Route::post('soft_delete/{id}', 'CategoriesController@softDelete')->name('categories::soft_delete');
            Route::post('delete/{id}', 'CategoriesController@delete')->name('categories::delete');
            Route::post('restore/{id}', 'CategoriesController@restore')->name('categories::restore');
        });

        Route::group(['prefix' => 'categories', 'namespace' => 'Categories'], function(){
            Route::get('', 'CategoriesController@index')->name('categories');
            Route::get('generateCode', 'CategoriesController@generateCode')->name('categories::generateCode');
            Route::get('categories_data', 'CategoriesController@data')->name('categories::data');
            Route::get('create', 'CategoriesController@create')->name('categories::create');
            Route::post('store', 'CategoriesController@store')->name('categories::store');
            Route::get('edit/{id}', 'CategoriesController@show')->name('categories::edit');
            Route::post('e/store', 'CategoriesController@update')->name('categories::e-store');
            Route::post('soft_delete/{id}', 'CategoriesController@softDelete')->name('categories::soft_delete');
            Route::post('delete/{id}', 'CategoriesController@delete')->name('categories::delete');
            Route::post('restore/{id}', 'CategoriesController@restore')->name('categories::restore');
        });

        Route::group(['prefix' => 'units', 'namespace' => 'Units'], function(){
            Route::get('', 'UnitsController@index')->name('units');
            Route::get('generateCode', 'UnitsController@generateCode')->name('units::generateCode');
            Route::get('getCategory', 'UnitsController@getCategory')->name('units::getCategory');
            Route::get('units_data', 'UnitsController@data')->name('units::data');
            Route::get('create', 'UnitsController@create')->name('units::create');
            Route::post('store', 'UnitsController@store')->name('units::store');
            Route::get('edit/{id}', 'UnitsController@show')->name('units::edit');
            Route::post('e/store', 'UnitsController@update')->name('units::e-store');
            Route::post('soft_delete/{id}', 'UnitsController@softDelete')->name('units::soft_delete');
            Route::post('delete/{id}', 'UnitsController@delete')->name('units::delete');
            Route::post('restore/{id}', 'UnitsController@restore')->name('units::restore');
        });
    });

});

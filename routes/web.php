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

            Route::get('show-order', 'UsersController@showOrder')->name('show_order');
            Route::get('packing-order', 'UsersController@PackingOrder')->name('users::packing_order');

            Route::get('units-history', 'UsersController@UnitsHistory')->name('units_history');
            Route::get('units-history-data', 'UsersController@UnitsHistoryData')->name('users::units_history');

            Route::get('money-history', 'UsersController@MoneyHistory')->name('money_history');
            Route::get('money-history-data', 'UsersController@MoneyHistoryData')->name('users::money_history');

            Route::get('unit-movement', 'UsersController@UnitsMovement')->name('unit_movement');
            Route::get('unit-movement-data', 'UsersController@UnitsMovementDate')->name('users::unit_movement');

            Route::get('check_order', 'UsersController@CheckOrder')->name('check_order');
            Route::get('refresh_data', 'UsersController@RefreshData')->name('refresh_data');
        });

        Route::group(['prefix' => 'actions', 'namespace' => 'Actions'], function(){
            Route::get('{type}', 'ActionsController@index')->name('actions');
            Route::post('make-operations', 'ActionsController@make_operations')->name('make_operations');
        });

        Route::group(['prefix' => 'categories', 'namespace' => 'Categories'], function(){
            Route::get('', 'CategoriesController@index')->name('categories');
            Route::get('categories_data', 'CategoriesController@data')->name('categories::data');
            Route::get('create', 'CategoriesController@create')->name('categories::create');
            Route::post('store', 'CategoriesController@store')->name('categories::store');
            Route::get('edit/{id}', 'CategoriesController@edit')->name('categories::edit');
            Route::post('e/store', 'CategoriesController@update')->name('categories::e-store');
            Route::post('soft_delete/{id}', 'CategoriesController@softDelete')->name('categories::soft_delete');
            Route::post('delete/{id}', 'CategoriesController@delete')->name('categories::delete');
            Route::post('restore/{id}', 'CategoriesController@restore')->name('categories::restore');
        });


        Route::group(['prefix' => 'configurations', 'namespace' => 'Configurations'], function(){

            Route::get('categories_config_trans/{lang}', 'ConfigurationsController@config')->name('configurations::config::trans');

            Route::get('index/{type}', 'ConfigurationsController@index')->name('configurations');
            Route::get('configurations_data', 'ConfigurationsController@data')->name('configurations::data');
            Route::post('create', 'ConfigurationsController@create')->name('configurations::create');
            Route::post('delete', 'ConfigurationsController@delete')->name('configurations::delete');

            Route::get('global/{type}', 'ConfigurationsController@global')->name('global');
            Route::get('global_data', 'ConfigurationsController@GlobalData')->name('global::data');
            Route::post('global_create', 'ConfigurationsController@GlobalCreate')->name('global::create');
            Route::post('global_delete', 'ConfigurationsController@GlobalDelete')->name('global::delete');

            Route::get('get_flag', 'ConfigurationsController@get_flag')->name('global::get_flag');
        });
    });

});

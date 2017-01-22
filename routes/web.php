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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::group(/*['middleware'=>'web'],*/[], function() {

    Route::match(['get', 'post'], '/', 'IndexController@execute')->name('home');
    Route::get('/page/{alias}', 'PageController@execute')->name('page');

    Route::auth();

});

Route::group(['prefix'=>'admin', 'middleware'=>'auth'], function () {

    Route::get('/', function () {

        if (view()->exists('admin.index')) {
            $data = ['title'=>'Панель администратора'];

            return view('admin.index', $data);


        }

    });

    //admin/pages
    Route::group(['prefix'=>'pages'], function () {

        //admin/pages
        Route::get('/', 'PagesController@execute')->name('pages');

        //admin/pages/add
        Route::match(['get', 'post'], '/add', 'PagesAddController@execute')
            ->name('pagesAdd');

        //admin/pages/edit/2
        Route::match(['get', 'post', 'delete'], '/edit/{page}','PagesEditController@execute')
        ->name('pagesEdit');
    });

    Route::group(['prefix'=>'portfolios'], function () {


        Route::get('/', 'PortfolioController@execute')->name('portfolio');


        Route::match(['get', 'post'], '/add', 'PortfolioAddController@execute')
            ->name('portfolioAdd');


        Route::match(['get', 'post', 'delete'], '/edit/{portfolio}','PortfolioEditController@execute')
            ->name('portfolioEdit');
    });

    Route::group(['prefix'=>'services'], function () {


        Route::get('/', 'ServicesController@execute')->name('services');


        Route::match(['get', 'post'], '/add', 'ServicesAddController@execute')
            ->name('servicesAdd');


        Route::match(['get', 'post', 'delete'], '/edit/{service}', 'ServicesEditController@execute')
            ->name('servicesEdit');
    });
});
Auth::routes();

Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');

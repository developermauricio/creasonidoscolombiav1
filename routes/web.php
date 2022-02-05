<?php

use Illuminate\Support\Facades\Route;

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
    return redirect('/cuenta');
});

Route::get('/cuenta', function () {
    return view('aspirant.account');
});

Route::get('/email', function () {
    return new \App\Mail\Aspirant\AccountCreate('Mauricio', 'Gutierrez', 'oansoasd3hujndsk', 'silviotista93@gmail.com');
});

//Route::post('/aspirant/account-create', 'Aspirant\AccountController@createAccount')->name('aspirant.create.account');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*=============================================
RUTAS DE LOS ASPIRANTES
=============================================*/
Route::group(['middleware' => 'auth', 'namespace' => 'Aspirant'], function () {
    Route::get('/registro', 'RegisterController@index')->name('aspirant.register.page');
    Route::get('/perfil', 'ProfileController@index')->name('aspirant.profile.page');
});

/*=============================================
RUTAS DE LOS CURADORES
=============================================*/
Route::group(['middleware' => 'auth', 'namespace' => 'Curador'], function () {
    Route::get('/curador', 'ProjectsController@index')->name('curador.projects.page');
});

/*=============================================
RUTAS PARA LOS REPORTES
=============================================*/
Route::group(['middleware' => 'auth', 'namespace' => 'Reports'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('reports.dashboard.page');
});

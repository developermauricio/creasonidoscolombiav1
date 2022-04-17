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
})->middleware('midd_aspirant_account');

Route::get('/pruebas', function (){
    \PhpMqtt\Client\Facades\MQTT::publish('subsanador_project', 'Nuevo proyecto en la badeja');
});

Route::get('/email', function () {
    return new \App\Mail\Aspirant\RegisterProject('silviotista93@gmail.com', 'Mauricio', 'Gutierrez', 'Amores como el nuestro', 'Salsa');
});

//Route::post('/aspirant/account-create', 'Aspirant\AccountController@createAccount')->name('aspirant.create.account');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*=============================================
RUTAS DE LOS ASPIRANTES
=============================================*/
Route::group(['middleware' => 'auth', 'namespace' => 'Aspirant'], function () {
    Route::get('/registro', 'RegisterController@index')->name('aspirant.register.page')->middleware('midd_aspirant_register');
    Route::get('/perfil', 'ProfileController@index')->name('aspirant.profile.page')->middleware('midd_aspirant_profile');
});

/*=============================================
RUTAS DE LOS CURADORES
=============================================*/
Route::group(['middleware' => 'auth', 'namespace' => 'Curador'], function () {
    Route::get('/curador', 'ProjectsController@index')->name('curador.projects.page');
});

/*=============================================
RUTAS DE LOS SUBSANADORES
=============================================*/
Route::group(['middleware' => 'auth', 'namespace' => 'Subsanador'], function () {
    Route::get('/subsanador', 'ProjectsController@index')->name('subsanador.projects.page');
});

/*=============================================
RUTAS PARA LOS REPORTES
=============================================*/
Route::group(['middleware' => 'auth', 'namespace' => 'Reports'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('reports.dashboard.page');
    Route::get('/usuarios', 'UserController@index')->name('user.page');
});
/*=============================================
RUTAS PARA LOS USUARIOS
=============================================*/
Route::group(['middleware' => 'auth', 'namespace' => 'User'], function () {
    Route::get('/usuarios', 'UserController@index')->name('user.page');
});

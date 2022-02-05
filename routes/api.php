<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/aspirant/account-create', 'Aspirant\AccountController@createAccount')->name('aspirant.create.account');

Route::group(['middleware' => 'auth:api'], function () {

});
Route::get('/curador/projects/{id}', 'Curador\ProjectsController@getProjects')->name('curador.get.projects');
Route::get('/curador/get-qualifications', 'Curador\ProjectsController@getQualifications')->name('curador.get.qualifications');


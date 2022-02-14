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
Route::get('/get-aspirant-types', 'Aspirant\RegisterController@getAspirantType')->name('aspirant.get.aspirant.type');
Route::post('/upload-archive-aspirant', 'Aspirant\RegisterController@uploadArchiveAspirant')->name('api.upload.archive.aspirant');
Route::post('/upload-archive-minor', 'Aspirant\RegisterController@uploadArchiveMinor')->name('api.upload.archive.minor');
Route::post('/removed-archive-minor', 'Aspirant\RegisterController@removedArchiveMinor')->name('api.removed.archive.minor');
Route::post('/upload-archive-music-principal', 'Aspirant\RegisterController@uploadArchiveMusic')->name('api.upload.archive.music.aspirant');
Route::post('/removed-archive-music-principal', 'Aspirant\RegisterController@removedArchiveMusicPrincipal')->name('api.remove.archive.music.principal');
Route::post('/upload-archive-music-opcional', 'Aspirant\RegisterController@uploadArchiveMusicOpcional')->name('api.upload.archive.music.aspirant');
Route::post('/removed-archive-music-opcional', 'Aspirant\RegisterController@removedArchiveMusicOpcional')->name('api.remove.archive.music.opcional');
Route::post('/create-register', 'Aspirant\RegisterController@createRegister')->name('api.create.register.aspirant');

Route::post('/update-project-endtime/{id}', 'Aspirant\ProfileController@udpateStateProject')->name('api.update.state.project');
Route::post('/update-profile-register', 'Aspirant\ProfileController@editProfile')->name('api.update.profile.aspirant');




Route::get('/get-genders', 'Controller@getGenders')->name('get.genders');
Route::get('/get-cities/{id}', 'Controller@getCities')->name('get.cities');
Route::get('/get-departaments', 'Controller@getDepartaments')->name('get.departaments');
Route::get('/verify-email-user/{email}', 'Controller@validateEmail')->name('api.validate.email');
Route::get('/get-project-categories', 'Controller@getProjectCategories')->name('get.categories.project');

Route::group(['middleware' => 'auth:api'], function () {

});
Route::get('/curador/projects/{id}', 'Curador\ProjectsController@getProjects')->name('curador.get.projects');
Route::get('/curador/get-qualifications', 'Curador\ProjectsController@getQualifications')->name('curador.get.qualifications');

/* consultas para los reportes. */
Route::get('/get-all-aspirants-registers', 'Aspirant\AccountController@getAllAspirantsRegisters');
Route::get('/get-all-aspirants', 'Aspirant\AccountController@getAllAspirants');
Route::get('/get-all-aspirants-location', 'Aspirant\AccountController@getAllAspirantsLocation');

Route::get('/get-all-curadors', 'Aspirant\AccountController@getAllCuradors');

Route::get('/get-all-projects', 'Aspirant\AccountController@getAllProjects');

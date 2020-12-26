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

// Route::get('/', function () {
//     return view('welcome');
// });
use App\Helpers\Sideveloper;
Route::get('/',function(){
	return redirect('/index');
});
// Route::get('/', 'IndexController@getIndex');

Sideveloper::routeController('/login','Auth\LoginController');
Route::post('login', [ 'as' => 'login', 'uses' => 'LoginController@getIndex']);
Sideveloper::routeController('/index','IndexController');
Route::post('index', [ 'as' => 'index', 'uses' => 'IndexController@getIndex']);

Route::middleware(['auth','access'])->group(function () {
	Sideveloper::routeController('/home','HomeController');
	Sideveloper::routeController('/penilaian','PenilaianController');
	Sideveloper::routeController('/master','MasterController');
});
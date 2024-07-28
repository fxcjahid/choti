<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthController;

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


/*
|--------------------------------------------------------------------------
| Admin Public Routes
|--------------------------------------------------------------------------
*/

Route::prefix('blanee:admin')
	->name('admin.')
	->controller(AuthController::class)
	->group(
		function () {

			Route::get('login', 'getLogin')->name('login');

			Route::post('login', 'postLogin')->name('login.post');

			Route::get('logout', 'signOut')->name('logout');
		}
	); 

//Route::post('custom-registration', [AuthController::class, 'customRegistration'])->name('register.custom');
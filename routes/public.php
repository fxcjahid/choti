<?php

use App\Models\City;
use App\Models\Post;
use App\Models\Categories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\CityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategorydController;
use App\Http\Controllers\ComplainStoryController;
use App\Http\Controllers\WriteNewStoryController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

/**
 * Page Controller
 */
Route::controller(PageController::class)
    ->prefix('service')
    ->group(function () {
        Route::view('mice-control', 'public.page.service.mice-control')->name('mice');
    });

Route::controller(PageController::class)
    ->group(function () {
        //Route::get('prix', 'prix')->name('prix');
        Route::get('qui-sommes-nous', 'AboutUs')->name('about-us');
        Route::get('guides-nuisibles', 'guidesNuisibles')->name('guides-nuisibles');
        Route::get('nos-conditions-generales-utilisation-mentions-legales', 'PolitiqueConfidentialite')->name('privacy-policy');
        // Service Page 
        //Route::get('{page}', 'servicePage')->name('service-page'); 
    });

Route::controller(ServiceController::class)
    ->prefix('service')
    ->name('service.')
    ->group(function () {
        Route::get('{service}/couverture', 'coverage')->name('coverage');
        Route::get('{service}/{city}', 'page')->name('page');
    });


Route::get('guides-nuisibles/{category}', [CategorydController::class, 'postByCategory'])
    ->where(['category' => '[A-Za-z-_]+'])
    ->name('category');

Route::get('tags/{tag}', [TagController::class, 'postBytag'])
    ->where(['tag' => '[A-Za-z-_]+'])
    ->name('tag');



Route::get('{category}/{slug}', [PostController::class, 'show'])
    ->where(['category' => '[A-Za-z-_]+', 'slug' => '[A-Za-z-_0-9]+'])
    ->name('post.show');


Route::get('sitemap:generate:blanee', function () {
    if (Auth()->check()) {
        return Artisan::call('sitemap:generate');
    } else {
        return abort(404);
    }
});

Route::get('/submit-new-story', [WriteNewStoryController::class, 'index'])->name('submit.story');
Route::get('/complain-story', [ComplainStoryController::class, 'index'])->name('complain.story');

Route::prefix('contact')
    ->name('contact.')
    ->group(function () {
        Route::get('/', [ContactController::class, 'view'])->name('index');
        Route::post('/', [ContactController::class, 'store'])->name('store');
    });
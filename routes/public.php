<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MyStoryController;
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

Route::prefix('account')
    ->middleware('auth')
    ->name('public.account.')
    ->group(function () {

        Route::get('', [AccountController::class, 'posts'])->name('index');
        Route::get('posts', [AccountController::class, 'posts'])->name('posts');

        Route::get('profile', function () {
            return view('public.account.page.profile');
        })->name('profile');

        Route::get('password', function () {
            return view('public.account.page.password');
        })->name('password');

        Route::view('create-story', 'public.account.page.create-story')
            ->name('create-story');
    });

Route::get('category/{category}', [CategorydController::class, 'postByCategory'])
    ->where(['category' => '[A-Za-z-_]+'])
    ->name('category');

Route::get('series/{series}', [SeriesController::class, 'postBySeries'])
    ->where(['series' => '[A-Za-z-_]+'])
    ->name('series');

Route::get('tags/{tag}', [TagController::class, 'postBytag'])
    ->where(['tag' => '[A-Za-z-_]+'])
    ->name('tag');


Route::get('{category}/{slug}', [PostController::class, 'show'])->name('post.show');


Route::get('sitemap:generate:blanee', function () {
    if (Auth()->check()) {
        return Artisan::call('sitemap:generate');
    } else {
        return abort(404);
    }
});

Route::prefix('submit-new-story')
    ->name('public.story.')
    ->group(function () {

        Route::get('', [WriteNewStoryController::class, 'index'])->name('index');
        Route::post('', [WriteNewStoryController::class, 'store'])->name('store');

        Route::get('success/{id}', [WriteNewStoryController::class, 'success'])->name('success');
        Route::post('success/{id}', [WriteNewStoryController::class, 'update'])->name('update');

    });


Route::get('/complain-story', [ComplainStoryController::class, 'index'])->name('complain.index');
Route::post('/complain-story', [ComplainStoryController::class, 'store'])->name('complain.store');

Route::prefix('contact')
    ->name('contact.')
    ->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('index');
        Route::post('/', [ContactController::class, 'store'])->name('store');
    });

Route::prefix('search')
    ->name('search.')
    ->group(function () {
        Route::get('/', [SearchController::class, 'index'])->name('index');
    });

Route::prefix('auth')
    ->middleware('guest')
    ->name('public.auth.')
    ->group(function () {
        Route::get('', [AuthController::class, 'index'])->name('index');
        Route::post('signup', [AuthController::class, 'signup'])->name('signup');
        Route::post('login', [AuthController::class, 'login'])->name('login');
    });


Route::prefix('my-story')
    ->name('public.mystory.')
    ->group(function () {
        Route::get('/', [MyStoryController::class, 'index'])
            ->middleware('guest')
            ->name('index');

        Route::get('/edit/{id}', [MyStoryController::class, 'edit'])->name('edit');
    });
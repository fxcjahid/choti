<?php 

use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\TagController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\ContactController; 
use App\Http\Controllers\CategorydController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\FileManagerController; 
use App\Http\Controllers\admin\SearchController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin's routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "authintication" middleware group. Now create something great!
|
*/


Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('search')
    ->name('search.')
    ->controller(SearchController::class)
    ->group(function () {
        Route::post('show', 'show')->name('show');
    });

Route::get('category', [CategorydController::class, 'index'])->name('category');
Route::post('category/show', [CategorydController::class, 'show'])->name('category.show');
Route::post('category/store', [CategorydController::class, 'store'])->name('category.store');
Route::post('category/update', [CategorydController::class, 'update'])->name('category.update');
Route::delete('category/destroy/{id}', [CategorydController::class, 'destroy'])->name('category.destroy');


Route::prefix('series')->name('series.')->group(function () {
    Route::get('/', [SeriesController::class, 'index'])->name('index');
    Route::post('/show', [SeriesController::class, 'show'])->name('show');
    Route::post('/store', [SeriesController::class, 'store'])->name('store');
    Route::post('/update', [SeriesController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [SeriesController::class, 'destroy'])->name('destroy');
});


Route::prefix('tags')
    ->name('tags.')
    ->group(function () {
        Route::get('/', [TagController::class, 'index'])->name('index');
        Route::post('show', [TagController::class, 'show'])->name('show');
        Route::post('store', [TagController::class, 'store'])->name('store');
        Route::post('update', [TagController::class, 'update'])->name('update');
        Route::delete('destroy/{id}', [TagController::class, 'destroy'])->name('destroy');
    });


Route::get('/create/post/{id}', [PostController::class, 'IndexCreatePost'])->name('create.get');
Route::post('/create/post', [PostController::class, 'createPost'])->name('create.post');
Route::post('/update/post', [PostController::class, 'updatePost'])->name('update.post');


Route::prefix('post')
    ->name('post.')
    ->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::post('update', [PostController::class, 'update'])->name('update');
    });

Route::prefix('page')
    ->name('page.')
    ->controller(PageController::class)
    ->group(function () {
        Route::get('/', 'view')->name('index');
        Route::get('/{slug}', 'modify')->name('modify');
        Route::post('/{slug}', 'CreateOrEdit')->name('CreateOrEdit');
    });

Route::prefix('contact')
    ->name('contact.')
    ->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('index');
        Route::post('/', [ContactController::class, 'store'])->name('store');
    });

Route::resource('users', UsersController::class)->names('users');

Route::prefix('file')
    ->name('file.')
    ->group(function () {
        Route::get('media', [FileController::class, 'index'])->name('media');

        /**
         * @@Remember: all requested files are Optimize By laravel-image-optimizer
         * @source: https://github.com/spatie/laravel-image-optimizer
         * @tools: https://github.com/spatie/image-optimizer#optimization-tools
         * @uses: Requested files are optimize by Middleware
         * @middleare: app/Http/Kernel.php
         * @config: config/image-optimizer.php
         * @required:
         *   ---> JpegOptim
         *   ---> JOptipng
         *   ---> Pngquant 2
         *   ---> SVGO 1
         *   ---> Gifsicle
         *   ---> cwebp
         * 	Without those packages, The Optimize will not worked.
         *  Please, Make sure you have installed all required packages in your server
         */
        Route::middleware('optimizeImages')
            ->post('upload', [FileController::class, 'store'])->name('upload');
    });

Route::any('file-manager', [FileManagerController::class, 'index'])->name('file-manager.index');

Route::prefix('editorjs')
    ->name('editorjs.')
    ->middleware('optimizeImages')
    ->group(function () {
        Route::post('uploadFile', [FileController::class, 'uploadFile'])->name('byFile');
        Route::post('uploadURL', [FileController::class, 'uploadURL'])->name('byURL');
    });

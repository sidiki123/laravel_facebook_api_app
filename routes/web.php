<?php

use App\Http\Controllers\FacebookUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PublicationController;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', [PageController::class,'home'])->name('home');
    Route::resource('facebook/profil/informations', FacebookUserController::class);
    Route::resource('publication', PublicationController::class)->middleware('RedirectIfFacebbokTokenIsEmpty');;
    Route::post('publishedPost', [PublicationController::class, 'publishedPost'])->name('publishedPost');
});

Route::get('/facebook/handle', [FacebookUserController::class,'handleFacebook'])->name('handleFacebook');
Route::get('/facebook/handle/callback', [FacebookUserController::class,'handleFacebookCallback'])->name('handleFacebookCallback');

Route::get('auth/facebook', [FacebookUserController::class, 'facebookRedirect'])->name('facebookRedirect');
Route::get('auth/facebook/callback', [FacebookUserController::class, 'loginWithFacebook'])->name('loginWithFacebook');

Route::post('facebookPageId', [FacebookUserController::class, 'handleFacebookPageId'])->name('handleFacebookPageId');

require __DIR__.'/auth.php';

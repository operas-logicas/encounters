<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

//Auth::routes();

Route::post(
    '/login',
    'Auth\LoginController@login'
)->name('login');

Route::post(
    '/logout',
    'Auth\LoginController@logout'
)->name('logout');

Route::post(
    '/register',
    'Auth\RegisterController@register'
)->name('register');

Route::middleware('auth')
    ->get('/user', function (Request $request) {
        return $request->user();
    });

Route::get('/{any?}', function () {
    return view('home');
})->where('any', '^(?!api\/)[\/\w\.\,-]*');

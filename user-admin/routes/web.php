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

require __DIR__ . '/auth.php';


Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/admin', function () {
    return redirect('/admin/login');
});


//admin
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
    Route::namespace('Auth')->middleware('guest:admin')->group(function () {
        //login route
        Route::get('login', 'AuthenticatedSessionController@create')->name('login');
        Route::post('login', 'AuthenticatedSessionController@store')->name('adminlogin');
    });
    Route::middleware('admin')->group(function () {
        
        Route::get('dashboard', 'HomeController@index')->name('dashboard');

    });
    Route::get('logout', 'Auth\AuthenticatedSessionController@destroy')->name('logout');
});

//User
Route::namespace('User')->prefix('user')->name('user.')->group(function () {
    Route::namespace('Auth')->middleware('guest:user')->group(function () {
        //login route
        Route::get('login', 'AuthenticatedSessionController@create')->name('login');
        Route::post('login', 'AuthenticatedSessionController@store')->name('userlogin');
    });
    Route::middleware('user')->group(function () {
        Route::get('dashboard', 'HomeController@index')->name('dashboard');
    });
    Route::get('logout', 'Auth\AuthenticatedSessionController@destroy')->name('logout');
});
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::middleware(["auth"])->group(function (){
    //Language Translation
    Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

    Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//Update User Details
    Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

    Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

    Route::controller(\App\Http\Controllers\Admin\PointageController::class)->group(function () {
        Route::get('/importation/add', 'create')->name("importation.create");
        Route::get('/importation/list', 'index')->name("importation.list");
        Route::post('/importation/add', 'store')->name("importation.store");
    });

    Route::controller(\App\Http\Controllers\Admin\StructureController::class)->group(function () {
        Route::get('/dashboard/{structure_id}', 'index')->name("structure.dashboard");
        Route::get('/dashboard/{structure_id}/{personnel_id}', 'show')->name("personnel.dashboard");
    });

    Route::controller(\App\Http\Controllers\Admin\UsersController::class)->group(function () {
        Route::get('/users/add', 'create')->name("users.create");
        Route::get('/users/list', 'index')->name("users.list");
        Route::post('/users/add', 'store')->name("users.store");
    });

});


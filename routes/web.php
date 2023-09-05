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

Route::middleware(["auth","is_active"])->group(function (){
    //Language Translation
    Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

    Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//Update User Details
    Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

    Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

    Route::controller(\App\Http\Controllers\Admin\PointageController::class)->middleware("is_admin")->group(function () {
        Route::get('/importation/add', 'create')->name("importation.create");
        Route::get('/importation/list', 'index')->name("importation.list");
        Route::post('/importation/add', 'store')->name("importation.store");
        Route::post('/structure/{structure_id}/export', 'exportStructure')->name("export.structure");
        Route::post('/structure/{structure_id}/{personnel_id}/export', 'exportPersonnel')->name("export.personnel");
    });

    Route::controller(\App\Http\Controllers\Admin\StructureController::class)->group(function () {
        Route::get('/structure/{structure_id}', 'index')->name("structure.dashboard");
        Route::get('/structure/{structure_id}/{personnel_id}', 'show')->name("personnel.dashboard");
    });

    Route::controller(\App\Http\Controllers\Admin\UsersController::class)->middleware("is_admin")->group(function () {
        Route::get('/users/add', 'create')->name("users.create");
        Route::get('/users/list', 'index')->name("users.list");
        Route::post('/users/add', 'store')->name("users.store");
        Route::get("/users/edit/{user_id}", "edit")->name("users.edit");
        Route::post("/users/edit/{user_id}", "update")->name("users.update");
        Route::get("/users/editStatus/{user_id}", "setActiveStatus")->name("users.update.status");
        Route::get("/users/editAdmin/{user_id}", "setAdminStatus")->name("users.update.admin");
    });

});


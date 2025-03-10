<?php

use App\Http\Controllers\Admin\CrudController;
use App\Http\Controllers\FoodController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(CrudController::class)->prefix('crud')->group(function(){
    Route::get('/', 'index')->name('crud');
    Route::get('/list','list')->name('crud.list');
    Route::get('/add', 'add')->name('crud.add');
    Route::get('/edit/{student}', 'edit')->name('crud.edit');
    Route::post('/update/{student}', 'update')->name('crud.update');
    Route::post('/store', 'store')->name('crud.store');
    Route::get('/delete/{student}', 'delete')->name('crud.delete');
    Route::get('/details/{student}', 'details')->name('crud.details');
   
});

Route::controller(FoodController::class)->prefix('food')->group(function(){
    Route::get('/', 'index')->name('food');
});
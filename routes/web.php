<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\MainController@main');
Route::post('/', 'App\Http\Controllers\MainController@main');

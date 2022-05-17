<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\MainController@main');
Route::get('/to-normal-code', 'App\Http\Controllers\ToNormalController@to_normal_code');
Route::post('/to-normal-code', 'App\Http\Controllers\ToNormalController@to_normal_code');
Route::get('/to-special-code', 'App\Http\Controllers\ToSpecialController@to_special_code');
Route::post('/to-special-code', 'App\Http\Controllers\ToSpecialController@to_special_code');

<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MapController;  
Route::get('/peta', [MapController::class, 'index']); 

Route::get('/', function () {
    return view('welcome');
});
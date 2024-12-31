<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


use App\Http\Controllers\MapController;  
use App\Http\Controllers\MapDataController;
use App\Http\Controllers\PetaCRUDController;

Route::get('/peta', [MapController::class, 'index']); 

Route::get('/', function () {
    return view('welcome');
});

Route::get('/interactive', [MapDataController::class, 'index'])->name('map.interactive');

Route::prefix('api')->group(function () {
    Route::get('/markers', [MapDataController::class, 'getMarkers'])->name('api.markers');
    Route::post('/markers', [MapDataController::class, 'storeMarker']);
    Route::delete('/markers/{id}', [MapDataController::class, 'deleteMarker'])->name('api.markers.delete');
    Route::get('/markers/{id}', [MapDataController::class, 'viewMarker'])->name('api.markers.view');

    Route::get('/polygons', [MapDataController::class, 'getPolygons'])->name('api.polygons.get');
    Route::post('/polygons', [MapDataController::class, 'storePolygon']);
    Route::delete('/polygons/{id}', [MapDataController::class, 'deletePolygon'])->name('api.polygons.delete');
    Route::get('/polygons/{id}', [MapDataController::class, 'viewPolygon'])->name('api.polygons.view');

});

Route::get('/handson3', [PetaCRUDController::class, 'index'])->name('handson3.index');
Route::get('/listDataMarker', [PetaCRUDController::class, 'getListMarker'])->name('handson3.getListMarker');
Route::get('/listDataPolygon', [PetaCRUDController::class, 'getListPolygon'])->name('handson3.getListPolygon');

Route::get('/jarak', [MapDataController::class, 'jarak']);
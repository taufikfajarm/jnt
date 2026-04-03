<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\SalesController;

Route::apiResource('pelanggans', PelangganController::class);
Route::apiResource('sales', SalesController::class);

Route::get('pakets', [PaketController::class, 'index']);

Route::get('regions/kabupatens', [RegionController::class, 'kabupatens']);
Route::get('regions/kecamatans/{kabupaten}', [RegionController::class, 'kecamatans']);
Route::get('regions/desas/{kecamatan}', [RegionController::class, 'desas']);

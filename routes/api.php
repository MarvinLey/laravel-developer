<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GolferController;

Route::get('/golfers/nearby', [GolferController::class, 'nearby']);
Route::get('/golfers/nearby/csv', [GolferController::class, 'nearbyCsv']);


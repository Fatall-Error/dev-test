<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ZohoController;


Route::post('/create-account', [ZohoController::class, 'createAccount']);
Route::post('/create-deal', [ZohoController::class, 'createDeal']);




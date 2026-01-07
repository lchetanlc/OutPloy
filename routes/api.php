<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\WebsiteController;

Route::get('/clients', [ClientController::class, 'index']);
Route::get('/clients/{client}/websites', [WebsiteController::class, 'byClient']);

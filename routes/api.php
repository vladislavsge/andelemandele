<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/characters', [ApiController::class, 'index']);
Route::get('/characters/search', [ApiController::class, 'search']);
Route::get('/characters/{id}', [ApiController::class, 'getById']);
Route::get('/characters/episode/{episode}', [ApiController::class, 'getByEpisode']);
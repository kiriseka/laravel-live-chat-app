<?php

use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ChatController::class, 'index'])->name('chat');
Route::post('/broadcast', [ChatController::class, 'broadcast'])->name('broadcast');
Route::post('/receive', [ChatController::class, 'receive'])->name('receive');


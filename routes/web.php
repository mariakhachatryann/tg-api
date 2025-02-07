<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\TelegramController;
use Illuminate\Support\Facades\Route;

Route::post('/telegram/webhook', [TelegramController::class, 'handleWebhook']);
Route::get('/messages', [MessageController::class, 'getMessages']);
Route::post('/send-message', [MessageController::class, 'sendReply']);


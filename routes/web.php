<?php

use App\Http\Controllers\ChatController;
use App\Services\AIService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/username', function () {
    return view('username');
})->name('username');

Route::post('/set-username', [ChatController::class, 'setUsername'])->name('set-username');

Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
Route::post('/chat', [ChatController::class, 'sendMessage'])->name('chat.send-message');
Route::get('/get-new-messages', [ChatController::class, 'getNewMessages'])->name('chat.get-new-messages');

Route::get('/test-ai', function () {
    $aiService = new AIService();
    $response = $aiService->generateResponse('What is the situation of the world\'s children?');

    return response()->json(['response' => $response]);


});

<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

// Chatbot Routes
Route::get('/', [ChatbotController::class, 'index']);
Route::get('/getSubCat1Options', [ChatbotController::class, 'getSubCat1Options']);
Route::get('/getSubCat2Options', [ChatbotController::class, 'getSubCat2Options']);
Route::get('/getQuestions', [ChatbotController::class, 'getQuestions']);
Route::get('/getAnswer', [ChatbotController::class, 'getAnswer']);

// Authentication Routes
Route::get('/chatbotLogin', function () {
    return view('chatbotLogin');
})->name('chatbotLogin');
Route::post('/chatbotLogin', [AuthController::class, 'login']);
Route::get('/chatbotLogout', [AuthController::class, 'logout'])->name('logout');


// Protect the Admin Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/chatBotAdmin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/chatBotAdmin/filter', [AdminController::class, 'filter'])->name('admin.filter');
    Route::post('/chatBotAdmin/store', [AdminController::class, 'store'])->name('admin.store');
    Route::post('/chatBotAdmin/update/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/chatBotAdmin/delete/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::get('/questions/{id}', [AdminController::class, 'show'])->name('questions.show');
    Route::post('/getSubCat1Options', [AdminController::class, 'getSubCat1Options'])->name('getSubCat1Options');
    Route::post('/getSubCat2Options', [AdminController::class, 'getSubCat2Options'])->name('getSubCat2Options');
});


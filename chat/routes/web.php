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
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// Protect the Admin Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/filter', [AdminController::class, 'filter'])->name('admin.filter');
    Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
    Route::post('/admin/update/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/delete/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::get('/questions/{id}', [AdminController::class, 'show'])->name('questions.show');
    Route::post('/getSubCat1Options', [AdminController::class, 'getSubCat1Options'])->name('getSubCat1Options');
    Route::post('/getSubCat2Options', [AdminController::class, 'getSubCat2Options'])->name('getSubCat2Options');
});


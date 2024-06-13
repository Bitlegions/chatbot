<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\ChatbotController;


Route::get('/', [ChatbotController::class, 'index']);

// Route to get SubCat1 options based on selected Category
Route::get('/getSubCat1Options', [ChatbotController::class, 'getSubCat1Options']);

// Route to get SubCat2 options based on selected Category and SubCat1
Route::get('/getSubCat2Options', [ChatbotController::class, 'getSubCat2Options']);

// Route to get Questions based on selected Category, SubCat1, and SubCat2
Route::get('/getQuestions', [ChatbotController::class, 'getQuestions']);

// Route to get Answer based on selected Question
Route::get('/getAnswer', [ChatbotController::class, 'getAnswer']);

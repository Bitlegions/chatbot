<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\ChatbotController;


Route::get('/chatbot', [ChatbotController::class, 'index']);

Route::post('/get_options', [ChatbotController::class, 'getOptions']);
Route::post('/get_answer', [ChatbotController::class, 'getAnswer']);


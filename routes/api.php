<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\Api\InstagramAPIController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/new-inquiry', [ChatController::class, 'newInquiry']);
Route::post('/verify-otp', [ChatController::class, 'verifyOtp']);
Route::post('/validateUser', [ChatController::class, 'validateUser']);

Route::post('/send-otp', [ChatController::class, 'sendOtp']);
Route::post('/generate-ticket', [ChatController::class, 'generateTicket']);
Route::get('/get-questions',[ChatController::class, 'getQuestions']);

Route::post('/hub-data', [DataController::class, 'store'])->name('hub-data');
Route::get('/get-threshold-data/{podid}',[DataController::class,'getThresholdData'])->name('get-threshold-data');
Route::get('/get-instagram-token',[InstagramAPIController::class, 'get_instatoken']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




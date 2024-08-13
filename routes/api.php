<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AppointmentDocumentationController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\NewsAttachmentsControllers;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/appointment/create', [AppointmentController::class, 'actionCreate']);
Route::get('file/{table}/secret/{file}', [FileController::class, 'getSecretFile'])
    ->name('getSecretFile')
    ->middleware('signed');
Route::get('file/{table}/public/{file}', [FileController::class, 'getPublicFile'])
    ->name('getPublicFile');

Route::post('/appointment-documentation/create', [AppointmentDocumentationController::class, 'actionCreate']);
Route::post('admin/news-attachments/create', [NewsAttachmentsControllers::class, 'actionCreate'])->name('news-attachments.create')->middleware('signed');

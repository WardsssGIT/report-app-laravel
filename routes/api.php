<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportUpload;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});

Route::get('/reports', [ReportUpload::class, 'index']); //getting data in database

Route::post('/reports-upload', [ReportUpload::class, 'store']); // storing data in database

Route::get('/reports/{id}', [ReportUpload::class, 'show']);//single selected data

Route::put('/reports/{id}', [ReportUpload::class, 'update']); //update sindle selected data

Route::delete('/reports/{id}', [ReportUpload::class,'destroy']);// deleting data

Route::put('/reports/archive/{id}', [ReportUpload::class, 'archive']);//data archive

Route::get('/reports/generate-pdf/{id}', [ReportUpload::class, 'generate_pdf']);//pdf

// Authentication routes
Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout']);
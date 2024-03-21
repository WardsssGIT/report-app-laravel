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
| routes are loaded by the RouteServiceProvider and assigned to the "api"
| middleware group. Make something great!
|
*/

// Authentication routes
Route::post('/login', [AuthController::class, 'login'])->name('login'); // Route for user login
Route::post('/register', [AuthController::class, 'register'])->name('register'); // Route for user registration


// Routes protected by the 'auth:sanctum' middleware
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/reports', [ReportUpload::class, 'index']); // Route to get all reports
    Route::post('/reports-upload', [ReportUpload::class, 'store']); // Route to upload a report
    Route::get('/reports/{id}', [ReportUpload::class, 'show']); // Route to get a single report by ID
    Route::put('/reports/{id}', [ReportUpload::class, 'update']); // Route to update a report by ID
    Route::delete('/reports/{id}', [ReportUpload::class, 'destroy']); // Route to delete a report by ID
    Route::put('/reports/archive/{id}', [ReportUpload::class, 'archive']); // Route to archive a report by ID
    Route::get('/reports/generate-pdf/{id}', [ReportUpload::class, 'generate_pdf']); // Route to generate PDF for a report by ID
    Route::post('/report/{id}/approve', [ReportUpload::class, 'approve_report']); // Route to approve a report by ID
    Route::get('/generate-pdf/{id}', [ReportUpload::class, 'generate_pdf']); // Route to generate PDF for a report by ID
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Route for user logout
});

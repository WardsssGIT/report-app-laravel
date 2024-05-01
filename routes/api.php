<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportUpload;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Department_Controller;
use App\Http\Controllers\TempData;
use App\Http\Controllers\UserModifier;
use App\Http\Controllers\SendEmailController;


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
Route::post('/register', [AuthController::class, 'register']);

// Routes protected by the 'auth:sanctum' middleware
Route::middleware('auth:sanctum')->group(function () {
//Route::post('/register', [AuthController::class, 'register']);
Route::post('/reports-upload', [ReportUpload::class, 'store']); // Route to upload a report
Route::get('/reports',[ReportUpload::class,'index']); // show all reports

Route::get('/reports/{id}', [ReportUpload::class, 'show']); // Route to get a single report by ID
Route::put('/reports/{id}', [ReportUpload::class, 'update']); // Route to update a report by ID
Route::put('/reports/archive/{id}', [ReportUpload::class, 'archive']); // Route to archive a report by ID
Route::get('/reports/generate-pdf/{id}', [ReportUpload::class, 'generate_pdf']); // Route to generate PDF for a report by ID
Route::post('/reports/approve/{id}', [ReportUpload::class, 'approve_report']); // Route to approve a report by ID
Route::post('/reports/disapprove/{id}',[ReportUpload::class,'disapprove_report']);// Route to disapprove a report by ID
Route::get('/generate-pdf/{id}', [ReportUpload::class, 'generate_pdf']); // Route to generate PDF for a report by ID
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Route for user logout

Route::get('/useraccounts',[UserModifier::class, 'indexuser']); // Route for displaying all user accounts
//For Temporary Data
Route::post('/temporary-data',[TempData::class, 'storetemporary']);//store temporary data

//email
Route::get('/emailapproved',[SendEmailController::class,"sendnotification"]); //reportapproved
Route::get('/emaildisapproved',[SendEmailController::class,"rejected"]); //report disapproved

//department
Route::post('/adddepartment',[Department_Controller::class,"addDepartment"]);//add department
Route::get('/indexdepartment',[Department_Controller::class,"showall"]);
});





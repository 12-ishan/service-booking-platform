<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\OrganisationController;
use App\Http\Controllers\api\v1\StudentController;
use App\Http\Controllers\api\v1\ProgramVerifyController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Public Api Routes
Route::post('/v1/student-register', [StudentController::class, 'studentRegister']);
Route::post('/v1/verify-otp', [StudentController::class, 'verifyOtp']);
Route::post('/v1/send-student-login-otp', [StudentController::class, 'sendOtp']);
Route::post('/v1/verify-student-login-otp', [StudentController::class, 'verifyStudentLoginOtp']);
Route::post('/v1/student-login', [StudentController::class, 'studentLogin']);
Route::post('/v1/send-forgot-password-otp', [StudentController::class, 'sendForgotPasswordOtp']);
Route::post('/v1/verify-forgot-password-otp', [StudentController::class, 'verifyForgotPasswordOtp']);

//Public Api route ends

//program-verify Api Route
Route::post('/v1/program-verify', [ProgramVerifyController::class, 'programVerify']);
//Program-verify Api Route ends

//Route::post('/organisation', [OrganisationController::class, 'store']);
// Protected routes of product and logout
Route::middleware('auth:sanctum')->group( function () {

    // Route::post('/v1/program-test', [ProgramVerifyController::class, 'programTest']);
    Route::post('/v1/program-test', [ProgramVerifyController::class, 'programTest']);


    // Route::post('/logout', [LoginRegisterController::class, 'logout']);

    // Route::controller(ProductController::class)->group(function() {
    //     Route::post('/products', 'store');
    //     Route::post('/products/{id}', 'update');
    //     Route::delete('/products/{id}', 'destroy');
    // });
});
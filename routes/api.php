<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\ContactController;
use App\Http\Controllers\api\v1\OurServicesController;
use App\Http\Controllers\api\v1\GeneralSettingController;
use App\Http\Controllers\api\v1\BlogController;
use App\Http\Controllers\api\v1\BlogDetailsController;
use App\Http\Controllers\api\v1\BlogPaginationController;




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


Route::post('/v1/create-contact', [ContactController::class, 'insert']);

Route::post('/v1/create-our-services', [OurServicesController::class, 'index']);


Route::post('/v1/general-settings', [GeneralSettingController::class, 'index']);

Route::post('/v1/get-blogs', [BlogController::class, 'index']);

Route::post('/v1/get-blog-details', [BlogDetailsController::class, 'index'])->name('blogDetails');

Route::post('/v1/blog-load-more', [BlogPaginationController::class, 'index']);



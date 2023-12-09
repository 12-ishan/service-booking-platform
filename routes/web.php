<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\ProgramController;
use App\Http\Controllers\admin\SubjectController;
use App\Http\Controllers\admin\TopicController;
use App\Http\Controllers\admin\TimeSlotController;
use App\Http\Controllers\admin\QuestionCategoryController;
use App\Http\Controllers\admin\QuestionController;
use App\Http\Controllers\admin\MeetingController;
use App\Http\Controllers\admin\ContactController;







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

Route::get('/admin/login',[AdminController::class, 'login'])->name('adminLogin');
Route::get('/admin/register',[AdminController::class, 'register'])->name('adminRegister');
Route::post('register',[AdminController::class, 'createUser'])->name('adminRegisterPost');
Route::post('login',[AdminController::class, 'doLogin'])->name('doLogin');

Route::group(['middleware' => ['auth']], function () {

    Route::get('admin/user/{id}/edit',[UserController::class, 'edit'])->name('user.edit');
    Route::put('admin/user/{id}',[UserController::class, 'update'])->name('user.update');
    Route::get('/admin/dashboard',[DashboardController::class, 'home'])->name('dashboard');


      //Program Routings
    
      Route::post('admin/program/updateSortorder',[ProgramController::class, 'updateSortorder']);
      Route::post('admin/program/destroyAll',[ProgramController::class, 'destroyAll']);
      Route::post('admin/program/updateStatus',[ProgramController::class, 'updateStatus']);
      Route::resource('admin/program', ProgramController::class);
  
      //Program Routings ends

    //Subject Routings

       Route::post('admin/subject/getSubjectByProgramId', [SubjectController:: class, 'getSubjectByProgramId']);
       Route::post('admin/subject/updateSortorder', [SubjectController:: class, 'updateSortorder']);
       Route::post('admin/subject/destroyAll', [SubjectController:: class, 'destroyAll']);
       Route::post('admin/subject/updateStatus', [SubjectController:: class, 'updateStatus']);
       Route::resource('admin/subject', SubjectController:: class);
   
    //Program Routings ends

     //Topic Routings
         
     Route::post('admin/topic/updateSortorder', [TopicController:: class, 'updateSortorder']);
     Route::post('admin/topic/destroyAll', [TopicController:: class, 'destroyAll']);
     Route::post('admin/topic/updateStatus', [TopicController:: class, 'updateStatus']);
     Route::resource('admin/topic', TopicController::class);
 
     //Topic Routings ends

     //Master/Time-Slot Routings
    
     Route::post('admin/time-slot/updateSortorder',[TimeSlotController:: class, 'updateSortorder']);
     Route::post('admin/time-slot/destroyAll',[TimeSlotController:: class, 'destroyAll']);
     Route::post('admin/time-slot/updateStatus',[TimeSlotController:: class, 'updateStatus']);
     Route::resource('admin/time-slot', TimeSlotController::class);
 
     //Master/Time-Slot  Routings ends

     //Question Catgory Routings
    
     Route::post('admin/question-category/updateSortorder',[QuestionCategoryController:: class, 'updateSortorder']);
     Route::post('admin/question-category/destroyAll',[QuestionCategoryController:: class, 'destroyAll']);
     Route::post('admin/question-category/updateStatus',[QuestionCategoryController:: class, 'updateStatus']);
     Route::resource('admin/question-category',QuestionCategoryController::class);
 
     //QUestion Category Routings ends

     //Question Routings

     Route::post('admin/question/updateSortorder',[QuestionController:: class, 'updateSortorder']);
     Route::post('admin/question/destroyAll',[QuestionController:: class, 'destroyAll']);
     Route::post('admin/question/updateStatus',[QuestionController:: class, 'updateStatus']);
     Route::resource('admin/question',QuestionController::class);
 
     //Question Routings ends

           //Meeting Routings

           Route::post('admin/topic/getTopicBySubjectId',[MeetingController:: class, 'getTopicBySubjectId']);
           Route::post('admin/topic/getTeacherByProgramIDSubjectId',[MeetingController:: class, 'getTeacherByProgramIDSubjectId']);
           Route::post('admin/meeting/updateSortorder',[MeetingController:: class, 'updateSortorder']);
           Route::post('admin/meeting/destroyAll',[MeetingController:: class, 'destroyAll']);
           Route::post('admin/meeting/updateStatus',[MeetingController:: class, 'updateStatus']);
           Route::get('admin/meeting/activate/{id}',[MeetingController:: class, 'meetingActivate']);
       //    Route::post('/meeting/activate/update/{id}', ['as' => 'meeting.meetingActivateUpdate','uses' => 'admin\MeetingController@meetingActivateUpdate']);
           Route::resource('admin/meeting',MeetingController::class);
       
          //Meeting Routings ends



         //Contact Routings

    
         Route::post('admin/contact/updateSortorder',[ContactController:: class,  'updateSortorder']);
         Route::post('admin/contact/destroyAll',[ContactController:: class,  'destroyAll']);
         Route::post('admin/contact/updateStatus',[ContactController:: class,  'updateStatus']);
         Route::resource('admin/contact',ContactController::class);
     
         //Contact Routings ends

});



// Route::get('/admin/dashboard', 'admin\DashboardController@home');


//Route::get('/admin/login', 'admin\AdminController@login')->name('adminLogin');
// Route::post('login', 'admin\AdminController@doLogin')->name('customeLogin');
//Route::get('/admin/register', 'admin\AdminController@register');
//Route::post('register', 'admin\AdminController@createUser');

Route::get('/', function () {
    return view('welcome');
});

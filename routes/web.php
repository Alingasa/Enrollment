<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnrollmentController;


// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[EnrollmentController::class,'welcome']);
Route::resource('/students', EnrollmentController::class);
Route::get('/findschoolid/{school_id}',[EnrollmentController::class,'findschoolid']);
Route::put('/studentsUpdate/{school_id}', [EnrollmentController::class, 'updateSchool']);

<?php

use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnrollmentController;


// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[EnrollmentController::class,'welcome']);
Route::resource('/students', EnrollmentController::class);
Route::get('/findschoolid/{school_id}',[EnrollmentController::class,'findschoolid']);
Route::get('/profile/{hash}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/teacher/{hash}', [ProfileController::class, 'teacher'])->name('teacher');
Route::put('/studentsUpdate/{school_id}', [EnrollmentController::class, 'updateSchool']);

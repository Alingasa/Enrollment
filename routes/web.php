<?php

use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\PDFController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[EnrollmentController::class,'welcome']);
Route::resource('/students', EnrollmentController::class);
Route::get('/findschoolid/{school_id}',[EnrollmentController::class,'findschoolid']);
Route::get('/profile/{hash}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/teacher/{hash}', [ProfileController::class, 'teacher'])->name('teacher');
Route::put('/studentsUpdate/{school_id}', [EnrollmentController::class, 'updateSchool']);



//Print PDF
Route::get('download', [PDFController::class, 'downloadpdf'])->name('download.tes');
<<<<<<< Updated upstream

Route::get('teacher', [PDFController::class, 'teacherProfile'])->name('teacher.profile');
=======
Route::get('downloadpdfstudent', [PDFController::class, 'downloadpdfstudent'])->name('download.allstudent');
Route::get('downloadpdfstudentprofile', [PDFController::class, 'downloadpdfstudentprofile'])->name('download.studentprofile');
>>>>>>> Stashed changes

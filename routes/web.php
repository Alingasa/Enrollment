<?php

use App\Filament\Pages\Auth\Login;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\Api\ProfileController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[EnrollmentController::class,'welcome']);
Route::resource('/students', EnrollmentController::class);
Route::get('/findschoolid/{school_id}',[EnrollmentController::class,'findschoolid']);
Route::get('/profile/{hash}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/teacher/{hash}', [ProfileController::class, 'teacher'])->name('teacher');
Route::get('/studentview/{hash}', [ProfileController::class, 'studentvalidateid'])->name('studentview');
Route::put('/studentsUpdate/{school_id}', [EnrollmentController::class, 'updateSchool']);

Route::get('/login', Login::class)->name('login');

//Print PDF
Route::get('download', [PDFController::class, 'downloadpdf'])->name('download.tes');


Route::get('teacher', [PDFController::class, 'teacherProfile'])->name('teacher.profile');

Route::get('downloadpdfstudent', [PDFController::class, 'downloadpdfstudent'])->name('download.allstudent');
Route::get('downloadProfile', [PDFController::class, 'downloadProfile'])->name('download.studentProfile');
Route::get('downloadpdfallsubjects', [PDFController::class, 'downloadpdfallsubjects'])->name('download.allsubjects');
Route::get('downloadallteacher', [PDFController::class, 'downloadallteacher'])->name('download.allteacher');
Route::get('/try', function(){
    return view('try');
});

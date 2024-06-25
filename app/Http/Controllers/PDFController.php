<?php

namespace App\Http\Controllers;

use Dompdf\Options;
use App\EnrolledStatus;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    //
    public function downloadpdf(){
        $subject = Subject::findOrFail(request()->query('record'));
        // dd($subject->subject_code);
        // dd($subject['day']);
        $strand =  $subject->load('enrollments.strand');
        $section =  $subject->load('enrollments.section');
        $student = $subject->enrollments;
        $countStudent = count($student);

        $pdf = PDF::loadView('listStudent', compact('student', 'strand', 'section', 'countStudent', 'subject'));

        // return $pdf->download('List.pdf');
        return $pdf->stream('List.pdf');
    }

    public function teacherProfile(){
        $teacher = Teacher::findorFail(request()->query('record'));

        $teacherSchedule = $teacher->subjects;

        // dd($teacher);
        $pdf = PDF::loadView('teacherProfile', compact('teacher'));

        return $pdf->stream('Teacher.pdf');

    }

    public function downloadpdfstudent(){
        $data = Enrollment::with('strand')
        ->where('status', EnrolledStatus::ENROLLED)
        ->get();

       $options = [
        'isPhpEnabled' => true,
        'defaultFont' => 'Arial',
        'orientation' => 'landscape',
    ];

    $pdf = PDF::setOptions($options)
    ->loadView('allstudent', compact('data'));

      // Add footer
    //   $pdf->setOptions(['isHtml5ParserEnabled' => true]);
    //   $pdf->setOptions(['isRemoteEnabled' => true]);
    //   $pdf->setOptions(['isPhpEnabled' => true]);

    return $pdf->stream('students.pdf');
    }


    public function downloadpdfstudentprofile(){
      $data = Enrollment::findOrFail(request()->query('record'));
     $section =   $data->load('section');
// dd($data);
    //   $subjects = Subject::findOrFail(request()->query('record'));

// dd($section->section->name);
    $subjects = $data->subjects;

    // dd($subjects);
    foreach($subjects as $t){
        // dd($t->id);
        $teacher = Teacher::findOrFail($t->id);
        // $room

        // dd($teacher);
    }
// dd($subjects);
      $options = [
        'isPhpEnabled' => true,
        'defaultFont' => 'Arial',
        // 'orientation' => 'landscape',
    ];

    $pdf = PDF::setOptions($options)
    ->loadView('studentprofile', compact('data','subjects', 'section', 'teacher'));


    return $pdf->stream('studentprofile.pdf');
    }

}

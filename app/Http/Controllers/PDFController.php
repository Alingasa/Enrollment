<?php

namespace App\Http\Controllers;

use Dompdf\Options;
use App\EnrolledStatus;

use Carbon\Carbon;


use App\Models\Room;
use App\Models\Section;
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

        // dd($teacher->id);
        $teacher->birthdate = Carbon::parse($teacher->birthdate)->isoFormat('MMMM DD, YYYY');

        $teacherSchedule = $teacher->subjects;

        foreach($teacherSchedule as $sectionId){
            $sections = Section::findorFail($sectionId->section_id);
            $rooms = Room::findorFail($sectionId->room_id);
        }
        $pdf = PDF::loadView('teacherProfile', compact('teacher', 'teacherSchedule', 'sections', 'rooms'))->setPaper('a4', 'landscape');

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

    $subjects = $data->subjects;


    foreach($subjects as $t){

        $teacher = Teacher::findOrFail($t->id);

    }



    $pdf = PDF::loadView('studentprofile', compact('data','subjects', 'section', 'teacher'))->setPaper('a4', 'landscape');


    return $pdf->stream('studentprofile.pdf');

    }




    public function downloadpdfallsubjects(){
        $subj = Subject::with('section', 'teacher')->get();

        foreach($subj as $t){

            $teac = Teacher::findOrFail($t->id);
            $section = Section::findorFail($t->section_id);
            // dd($t->section_id);

        }

        // $sect =   $subj->load('section');


    $pdf = PDF::loadView('allsubjects', compact('subj','section','teac'))->setPaper('a4','landscape');


    return $pdf->stream('allsubjects.pdf');
    }

}

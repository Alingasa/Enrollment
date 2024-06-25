<?php

namespace App\Http\Controllers;

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
}

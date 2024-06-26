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

        $strand =  $subject->load('enrollments.strand');
        $section =  $subject->load('enrollments.section');
        $student = $subject->enrollments;
        $countStudent = count($student);

        $pdf = PDF::loadView('listStudent', compact('student', 'strand', 'section', 'countStudent', 'subject'));


        return $pdf->stream('List.pdf');
    }


    public function teacherProfile(){

        $teacher = Teacher::findOrFail(request()->query('record'));

        $teacher->birthdate = Carbon::parse($teacher->birthdate)->isoFormat('MMMM DD, YYYY');

        $teacherSchedule = $teacher->subjects;
        $sections = [];
        $rooms = [];

        foreach($teacherSchedule as $subject){
            $section = Section::find($subject->section_id);
            $sections[] = $section ? $section->name : 'Not provided'; // Default value if section is null

            $room = Room::find($subject->room_id);
            $rooms[] = $room ? $room->room : 'Not provided'; // Default value if room is null
        }

        $pdf = PDF::loadView('teacherProfile', compact('teacher', 'teacherSchedule', 'sections', 'rooms'))->setPaper('a4', 'landscape');

        return $pdf->stream('Teacher.pdf');
    }



    public function downloadpdfstudent(){

        $data = Enrollment::with('strand')
            ->where('status', EnrolledStatus::ENROLLED)
            ->get();

        $pdf = PDF::loadView('allstudent', compact('data'))->setPaper('a4', 'landscape');

        return $pdf->stream('students.pdf');
    }


    public function downloadProfile(){

        $data = Enrollment::findOrFail(request()->query('record'));

        $section =   $data->load('section');

        $subjects = $data->subjects;

        $teachers = $subjects->load('teacher');


        $pdf = PDF::loadView('studentprofile', compact('data','subjects', 'section', 'teachers'))->setPaper('a4', 'landscape');

        return $pdf->stream('studentprofile.pdf');

    }




    public function downloadpdfallsubjects(){

        $subj = Subject::with('section', 'teacher')->get();

        $pdf = PDF::loadView('allsubjects', compact('subj'))->setPaper('a4','landscape');

        return $pdf->stream('allsubjects.pdf');
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Subject;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    //
    public function downloadpdf(){
        $subject = Subject::findOrFail(request()->query('record'));


        $student = $subject->enrollments;


        $pdf = PDF::loadView('listStudent', compact('student'));

        return $pdf->download('subjects.pdf');
    }
}

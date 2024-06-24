<?php

namespace App\Http\Controllers;

use App\Models\Subject;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    //
    public function downloadpdf(){
        $subject = Subject::whereHas('teacher', function($quer){
            $quer->where('user_id');
        });

        dd($subject);

        $data = [
            'subject' => $subject
        ];
        $pdf = PDF::loadView('listStudent', $data);

        return $pdf->download('subjects.pdf');
    }
}

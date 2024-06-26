<?php

namespace App\Http\Controllers\Api;

use App\EnrolledStatus;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Enrollment;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
        $request->validate([
            'school_id' => 'required'
        ]);

        $enrollment = Enrollment::where('school_id', $request->school_id)->first();
        // dd($enrollment);

        $data = $enrollment->toArray();
        $data['status'] = $enrollment->status->name;
        $data['section_id'] = $enrollment->section->name;
        $data['civil_status'] = $enrollment->civil_status->name;

        if($enrollment->strand_id != null){
            $data['strand_id'] =  $enrollment->strand->name;

        }else{
            $data['strand_id'] = 'No Strand';
        }


        if($data == true){
            return response()->json([
                'status' => 200,
                 $data,
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Not Found!'
            ]);
        }




    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

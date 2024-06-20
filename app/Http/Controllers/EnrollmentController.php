<?php

namespace App\Http\Controllers;

use App\Models\Strand;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
  /**
     * Display a listing of the resource.
     */

     public function welcome(){
        $strand = Strand::all();
        return view('welcome',compact('strand'));
     }
    public function index()
    {
        //
        $strand = Strand::all();
        return view('students.create',compact('strand'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $strand = Strand::all();
        return view('welcome',compact('strand'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    try{
    $data =  $request->validate([
            'first_name' => 'required',
            'middle_name'=> 'required',
            'last_name'=> 'required',
            'email' => 'required|email|unique:enrollments,email',
            'contact_number'=> 'required|max:11',
            'gender'=> 'required',
            'birthdate'=> 'required',
            'civil_status'=> 'required',
            'religion'=> 'required',
            'purok'=> 'required',
            'sitio_street'=> 'required',
            'barangay'=> 'required',
            'municipality'=> 'required',
            'province'=> 'required',
            'zip_code'=> 'required',
            'guardian_name'=> 'required',
            'grade_level'=> 'required',



        ]);


        if ($request->hasFile('profile_image')) {
            $profilePath = $request->file('profile_image')->store('profile_image', 'public');
            $data['profile_image'] = $profilePath;
        }else {
            $profilePath = null;
        }

        if ($request->hasFile('strand_id')){
            $data['strand_id'] = $request->strand_id;
        }

        Enrollment::create($data);




        return redirect()->to('http://highschoolenrollment.webactivities.online/')


            ->with('success_apply','You are successfully apply for enrollment!');

    }
    catch (\Illuminate\Database\QueryException $e)
    {

        $errorCode = $e->errorInfo[1];

        if ($errorCode == 1062) {

            return redirect()->back()->with('error', 'Duplicate entry for email.');
        }

        return redirect()->back()->with('error', 'An error occurred during applying for enrollment!.');
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrollment $student)
    {
        //
        return view('students.edit',compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enrollment $student)
    {

        try{

        $data =  $request->validate([
            'first_name' => 'required',
            'middle_name'=> 'required',
            'last_name'=> 'required',
            'email' => 'required|email|unique:users,email',
            'contact_number'=> 'required',
            'gender'=> 'required',
            'birthdate'=> 'required',
            'civil_status'=> 'required',
            'religion'=> 'required',
            'purok'=> 'required',
            'sitio_street'=> 'required',
            'barangay'=> 'required',
            'municipality'=> 'required',
            'province'=> 'required',
            'zip_code'=> 'required',
            'guardian_name'=> 'required',
            'grade_level'=> 'required',



        ]);



        if (!$student) {
            return back()->with('error', 'Student with provided school ID not found.');
        }

        if ($request->hasFile('profile_image')) {
            $profilePath = $request->file('profile_image')->store('profile_image', 'public');
            $data['profile_image'] = $profilePath;
        }else {
            $profilePath = null;
        }

        if($request->hasFile('grade_level')){
            $data['grade_level'] = $request->grade_level;
        }

        if ($request->hasFile('strand_id')){
            $data['strand_id'] = $request->strand_id;
        }

        $data['status'] = 1;


        // unset($data['school_id']);

        $student->update($data);

        return view('welcome')->with('success', 'You are successfully apply for enrollment!');
    }
    catch (\Illuminate\Database\QueryException $e)
    {

        $errorCode = $e->errorInfo[1];

        if ($errorCode == 1062) {


            return redirect()->back()->with('error', 'Duplicate entry for email.');
        }

        return redirect()->back()->with('error', 'An error occurred during applying for enrollment!.');
    }
}


public function updatestudent(Request $request, Enrollment $student)
{
    //
    try{

    $data =  $request->validate([

        'grade_level'=> 'required',



    ]);

    $student = Enrollment::where('school_id', $request->school_id)->first();

    if (!$student) {
        return redirect()->back()->with('error', 'Student with provided school ID not found.');
    }


    if($request->hasFile('grade_level')){
        $data['grade_level'] = $request->grade_level;
    }

    if ($request->hasFile('strand_id')){
        $data['strand_id'] = $request->strand_id;
    }


    $data['status'] = 1;
    // unset($data['school_id']);

    $student->update($data);

    return view('welcome')->with('success', 'You are successfully apply for enrollment!');
}
catch (\Illuminate\Database\QueryException $e)
{

    $errorCode = $e->errorInfo[1];

    if ($errorCode == 1062) {


        return redirect()->back()->with('error', 'Duplicate entry for email.');
    }

    return redirect()->back()->with('error', 'An error occurred during applying for enrollment!.');
}
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function findschoolid(Request $request,Enrollment $student){

    $data =  $request->validate([

        'school_id'=> 'required',

    ]);


    $student = Enrollment::where('school_id', $request->school_id)->first();
    $strand = Strand::all();
    if (!$student) {
        return redirect()->back()->with('error', 'Student with provided school ID not found.');
    }

    return view('students.updatestudent',compact('student','strand'))->with('success', 'School ID found!');
    }

    public function updateSchool(Request $request){

        $student = Enrollment::where('school_id', $request->school_id);

        $data =  $request->validate([
            'status' => 'required',
            'first_name' => 'required',
            'middle_name'=> 'required',
            'last_name'=> 'required',
            'email' => 'required',
            'contact_number'=> 'required',
            'gender'=> 'required',
            'birthdate'=> 'required',
            'civil_status'=> 'required',
            'religion'=> 'required',
            'purok'=> 'required',
            'sitio_street'=> 'required',
            'barangay'=> 'required',
            'municipality'=> 'required',
            'province'=> 'required',
            'zip_code'=> 'required',
            'guardian_name'=> 'required',
            'grade_level'=> 'required',
        ]);



        if (!$student) {
            return back()->with('error', 'Student with provided school ID not found.');
        }

        if ($request->hasFile('profile_image')) {
            $profilePath = $request->file('profile_image')->store('profile_image', 'public');
            $data['profile_image'] = $profilePath;
        }else {
            $profilePath = null;
        }

// dd($data);
        // unset($data['school_id']);

        $student->update($data);



        return redirect()->to('http://highschoolenrollment.webactivities.online/')->with('update_success', 'You are successfully apply for enrollment!');


    }
}

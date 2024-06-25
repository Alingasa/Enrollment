<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gradesheet</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .gradesheet-container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            /* border: 1px solid #ddd; */
            border-radius: 5px;
        }
        .gradesheet-header {
            /* text-align: center; */
            margin-bottom: 20px;
        }
        .gradesheet-header img {
            width: 100px;
            margin-bottom: 10px;
        }
        .gradesheet-title {
            font-size: 18px;
            font-weight: bold;
            color: red;
            margin-bottom: 10px;
        }
        /* .personal-info, .educational-history, .emergency-contact {
            margin-bottom: 20px;
        } */
        .gradesheet-table th, .gradesheet-table td {
            text-align: center;
        }
    </style>
</head>
<body>
    {{-- <div style="text-align: center;">
        {!! QrCode::size(200)->generate(route('profile.show', Crypt::encryptString($teacher->id))) !!}

    </div> --}}
<div class="container gradesheet-container">
    <div class="gradesheet-header">
        {{-- <img src="logo.png" alt="MLG College of Learning, Inc."> --}}
        <h4 >Personal Information</h4>
        {{-- <p>Brgy. Atabay, Hilongos, Leyte</p> --}}
    </div>
    {{-- <h5 class="text-right">GRADESHEET</h5> --}}
{{-- @include('filament.resources.student-resource.pages.teacher') --}}
{{-- <div style="flex: 1; text-align: center;">
    <div style="display: inline-block; padding: 10px; background: #fff; border-radius: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        {!! QrCode::size(200)->generate(route('profile.show', Crypt::encryptString($teacher->id))) !!}

    </div> --}}
    <div class="personal-info">

{{-- @dd(QrCode::size(200)->generate(route('profile.show', Crypt::encryptString($teacher->id)))) --}}
        @if($teacher->profile_image)
        <img style="height: 140px; width: 140px;" src="{{public_path('storage/'.$teacher->profile_image)}}" alt="">
        @else
        <img src="{{public_path('default_images/me.jpg')}}" alt="">
        @endif

        <p> <b>Name:</b> {{$teacher->full_name}}</p>
        <p><b>Contact:</b>{{$teacher->contact_number}}1</p>
        <p><b>Gender:</b> {{$teacher->gender}}</p>
        {{-- <p>Civil Status: {{$teacher->civil_status}}</p> --}}
        <p><b>Religion:</b> {{$teacher->zip_code}}</p>
        <p><b>Address:</b> {{$teacher->barangay. ' '. $teacher->municipality.','.' '.$teacher->province}}</p>
        <p><b>Birth Date:</b> {{$teacher->birthdate}}</p>
    </div>

    {{-- <div class="gradesheet-title">
       Incase of Emergency
    </div>
    <p> <b>Guardian/Parent:</b> {{$teacher->guardian_name}}</p>
    <p><b>Contact:</b>{{$teacher->incaseof_emergency}}</p> --}}

    {{-- <p class="text-center">Third Year (Second Semester, AY 2023-2024)</p> --}}

    <div class="emergency-contact">
       <center><h5>Subjects</h5></center>
        {{-- <p>Name: Rosemarie A. Lora</p>
        <p>Number: 09368981592</p> --}}
    </div>

    {{-- <div class="educational-history">
        <h6>Educational History</h6>
        <p>LRN: 121380080003</p>
        <p>School Graduated: Hilongos National Vocational School</p>
        <p>School Address: RV. Fulache Street Hilongos Leyte</p>
        <p>Year Graduated: 2021</p>
    </div> --}}

    <table class="table table-bordered gradesheet-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Code</th>
                <th>Description</th>
                <th>Section</th>
                <th>Schedule</th>
                <th>Subject Type</th>
                <th>Units</th>
                <th>Room</th>
            </tr>
        </thead>
        <tbody>

            @foreach($teacherSchedule as $subjects)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$subjects->subject_code}}</td>
                <td>{{$subjects->subject_title}}</td>
                <td>{{$sections->name}}</td>
                <td><?php foreach ($subjects['day'] as $day): ?>
                    <?php echo $day.','; ?>
                 <?php endforeach; ?>/{{$subjects->time_start.'-'.$subjects->time_end}}</td>
                 <td>{{$subjects->subject_type}}</td>
                 <td>{{$subjects->units}}</td>
                 <td>{{$rooms->room}}</td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

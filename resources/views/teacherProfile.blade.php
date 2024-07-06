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
            background-color: #f8f9fa;
        }
        .gradesheet-container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .gradesheet-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .gradesheet-header img {
            width: 80px;
            margin-bottom: 10px;
        }
        .gradesheet-title {
            font-size: 24px;
            font-weight: bold;
            color: #343a40;
            margin-bottom: 20px;
        }
        .personal-info p, .emergency-contact p {
            margin-bottom: 5px;
        }
        .gradesheet-table th, .gradesheet-table td {
            text-align: center;
            vertical-align: middle;
        }
        .gradesheet-table th {
            background-color: #343a40;
            color: #ffffff;
        }
        .gradesheet-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        #header-p{
            font-size: 28px;
            font-weight: bold;
         }
    </style>
</head>
<body>
<div class="container gradesheet-container">
    <div class="gradesheet-header">
        <h2 class="gradesheet-title">Personal Information</h2>
    </div>
    <div class="personal-info">
        @if($teacher->profile_image)
        <img style="height: 140px; width: 140px;" src="{{public_path('storage/'.$teacher->profile_image)}}" alt="">
        @else
        <img style="height: 140px; width: 140px;" src="{{public_path('default_images/me.jpg')}}" alt="">
        @endif
        <p><strong>Name:</strong> {{$teacher->full_name}}</p>
        <p><strong>Contact:</strong> {{$teacher->contact_number}}</p>
        <p><strong>Gender:</strong> {{$teacher->gender}}</p>
        <p><strong>Religion:</strong> {{$teacher->zip_code}}</p>
        <p><strong>Address:</strong> {{$teacher->barangay . ' ' . $teacher->municipality . ', ' . $teacher->province}}</p>
        <p><strong>Birth Date:</strong> {{$teacher->birthdate}}</p>
    </div>
    <div class="emergency-contact">
        <h4 class="gradesheet-title">Subjects</h4>
    </div>
    <table class="table table-bordered gradesheet-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Code</th>
                <th>Description</th>
                <th>Section</th>
                <th>Schedule</th>
                <th>Type</th>
                <th>Units</th>
                <th>Room</th>
            </tr>
        </thead>
        <tbody>

            {{-- @foreach($teacherSchedule as $index => $subjects)
            <tr>
                @if($teacherSchedule)
                <td>{{ $loop->iteration }}</td>
                <td>{{ $subjects->subject_code }}</td>
                <td>{{ $subjects->subject_title }}</td>
                <td>{{ $sections[$index] }}</td> <!-- Using the index to get the correct section -->
                <td>
                    @foreach ($subjects['day'] as $day)
                        {{ $day }},
                    @endforeach
                    {{ $subjects->time_start }} - {{ $subjects->time_end }}
                </td>
                <td>{{ $subjects->subject_type }}</td>
                <td>{{ $subjects->units }}</td>
                <td>{{ $rooms[$index] }}</td> <!-- Using the index to get the correct room -->
                @else
                <tr>
                <td><h1>No Subjects</h></td>
                </tr>
                @endif
            </tr>
        @endforeach --}}
        @if($teacherSchedule->isEmpty())
    <tr>
        <td colspan="8"><p id="header-p">No Subjects</p></td>
    </tr>
@else
    @foreach($teacherSchedule as $index => $subjects)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $subjects->subject_code }}</td>
            <td>{{ $subjects->subject_title }}</td>
            <td>{{ $sections[$index] }}</td> <!-- Using the index to get the correct section -->
            <td>
                @foreach ($subjects['day'] as $day)
                    {{ $day }},
                @endforeach
                {{ $subjects->time_start }} - {{ $subjects->time_end }}
            </td>
            <td>{{ $subjects->subject_type }}</td>
            <td>{{ $subjects->units }}</td>
            <td>{{ $rooms[$index] }}</td> <!-- Using the index to get the correct room -->
        </tr>
    @endforeach
@endif



        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

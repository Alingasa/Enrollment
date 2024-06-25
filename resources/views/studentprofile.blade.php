{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

    <div class="profile-container">

        <div class="profile-image">
            <img src="{{ public_path('storage/'. $data->profile_image) }}" class="img-fluid" alt="Profile Image">
        </div>
        <div class="profile-info">
            <h3>{{ $data->full_name }}</h3>
            <p></p>
            <p><span>Contact:</span> {{ $data->contact_number }}</p>
            <p><span>Email:</span> {{ $data->email }}</p>
            <p><span>Gender:</span> {{ $data->gender }}</p>
            <p><span>Civil status:</span> {{ $data->civil_status->getLabel() }}</p>
            <p><span>Date of Birth:</span> {{ $data->birthdate }}</p>
            <p><span>Religion:</span> {{ $data->religion }}</p>
            <p><span>Address:</span> {{ $data->barangay . ' ' . $data->municipality . ' ' . $data->province }}</p>
            <p><span>School ID:</span> {{ $data->school_id ?: 'Not provided' }}</p>
            <p><span>Grade:</span> {{ $data->grade_level }}</p>
            <p><span>Guardian:</span> {{ $data->guardian_name }}</p>
            <p><span>Incase of emergency:</span> {{ $data->incaseof_emergency }}</p>
        </div>

    </div>

    <div class="student-subjects">
        <h1 class="mt-4 center-heading">Subjects</h1>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Code</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Section</th>
                    <th scope="col">Teacher</th>
                    <th scope="col">Schedule</th>
                    <th scope="col">Subject-type</th>
                    <th scope="col">Units</th>
                    <th scope="col">Room</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($subjects as  $sub)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $sub->subject_code ?: 'Not provided' }}</td>
                    <td>{{ $sub->subject_title ?: 'Not provided' }}</td>
                    <td>{{ $section->section->name ?: 'Not provided' }}</td>
                    <td>{{ $teacher->full_name ?: 'Not provided' }}</td>
                    <td>{{ $sub->day ?: 'Not provided' }}</td>
                    <td>{{ $sub->subject_type ?: 'Not provided' }}</td>
                    <td>{{ $sub->units ?: 'Not provided' }}</td>
                    <td>{{ $sub->room ?: 'Not provided' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

          <!-- Footer -->
          {{-- <div class="footer">
            <span>No. of students: {{ count($subjects) }}</span>
        </div> --}}
    {{-- </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>  --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .gradesheet-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            /* border: 1px solid #ddd; */
            border-radius: 5px;
        }
        .gradesheet-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .gradesheet-header img {
            width: 100px;
            margin-bottom: 10px;
        }
        .gradesheet-title {
            font-size: 24px;
            font-weight: bold;
            color: red;
            margin-bottom: 10px;
        }
        .personal-info, .educational-history, .emergency-contact {
            margin-bottom: 20px;
        }
        .gradesheet-table th, .gradesheet-table td {
            text-align: center;
            vertical-align: middle;
        }
        </style>
</head>
<body>
    <div class="container gradesheet-container">
        <div class="gradesheet-header">
            {{-- <img src="logo.png" alt="MLG College of Learning, Inc."> --}}
            <h4>Personal Information</h4>
            {{-- <p>Brgy. Atabay, Hilongos, Leyte</p> --}}
        </div>
        {{-- <h5 class="text-right">GRADESHEET</h5> --}}

        <div class="personal-info">

            @if($data->profile_image)
            <img style="height: 140px; width: 140px;" src="{{public_path('storage/'.$data->profile_image)}}" alt="">
            @else
            <img src="{{public_path('default_images/me.jpg')}}" alt="">
            @endif

            <p>Name: {{ $data->full_name }}</p>
            <p>Contact: {{ $data->contact_number }}</p>
            <p>Gender: {{ $data->gender }}</p>
            <p>Civil Status: {{ $data->civil_status->getLabel() }}</p>
            <p>Religion: {{ $data->religion }}</p>
            <p>Address: {{ $data->barangay . ' ' . $data->municipality . ' ' . $data->province }}</p>
            <p>School ID: {{ $data->school_id ?: 'Not provided' }}</p>
        </div>


        {{-- <p class="text-center">Third Year (Second Semester, AY 2023-2024)</p> --}}

        <div class="emergency-contact">
            <h5>Emergency Contact</h5>
            <p>Name: {{ $data->guardian_name }}</p>
            <p>Number: {{ $data->incaseof_emergency }}</p>
        </div>
        <div class="gradesheet-title text-center">
            GRADE {{ $data->grade_level }}
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
                    <th>Subject</th>
                    <th>Section</th>
                    <th>Teacher</th>
                    <th>Schedule</th>
                    <th>Subject-type</th>
                    <th>Units</th>
                    <th>Room</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subjects as  $sub)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $sub->subject_code ?: 'Not provided' }}</td>
                    <td>{{ $sub->subject_title ?: 'Not provided' }}</td>
                    <td>{{ $section->section->name ?: 'Not provided' }}</td>
                    <td>{{ $teacher->full_name ?: 'Not provided' }}</td>
                    <td>{{ $sub->day ?: 'Not provided' }}</td>
                    <td>{{ $sub->subject_type ?: 'Not provided' }}</td>
                    <td>{{ $sub->units ?: 'Not provided' }}</td>
                    <td>{{ $sub->room ?: 'Not provided' }}</td>
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

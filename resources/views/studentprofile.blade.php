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
            <h2>Personal Information</h2>
            {{-- <p>Brgy. Atabay, Hilongos, Leyte</p> --}}
        </div>
        {{-- <h5 class="text-right">GRADESHEET</h5> --}}

        <div class="personal-info">
            <div>
                {{-- @dd($data) --}}
            @if($data->profile_image)
            <img style="height: 140px; width: 140px;" src="{{public_path('storage/'.$data->profile_image)}}" alt="">
            @else
            <img src="{{public_path('default_images/me.jpg')}}" alt="">
            @endif
            </div>
            <div>
            <p>Name: {{ $data->full_name }}</p>
            <p>Contact: {{ $data->contact_number }}</p>
            <p>Gender: {{ $data->gender }}</p>
            <p>Civil Status: {{ $data->civil_status->getLabel() }}</p>
            <p>Religion: {{ $data->religion }}</p>
            <p>Address: {{ $data->barangay . ' ' . $data->municipality . ' ' . $data->province }}</p>
            <p>School ID: {{ $data->school_id ?: 'Not provided' }}</p>
            </div>
        </div>


        {{-- <p class="text-center">Third Year (Second Semester, AY 2023-2024)</p> --}}

        <div class="emergency-contact">
            <h5>Emergency Contact</h5>
            <p>Name: {{ $data->guardian_name }}</p>
            <p>Number: {{ $data->incaseof_emergency }}</p>
        </div>
        {{-- <div class="gradesheet-title text-center">
            GRADE {{ $data->grade_level }}
        </div> --}}
        {{-- <div class="educational-history">
            <h6>Educational History</h6>
            <p>LRN: 121380080003</p>
            <p>School Graduated: Hilongos National Vocational School</p>
            <p>School Address: RV. Fulache Street Hilongos Leyte</p>
            <p>Year Graduated: 2021</p>
        </div> --}}
        <div class="table-header">
            {{-- <img src="logo.png" alt="MLG College of Learning, Inc."> --}}
            <h2>Subjects</h2>
            {{-- <p>Brgy. Atabay, Hilongos, Leyte</p> --}}
        </div>

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
                @foreach ($subjects as  $index => $sub)
                <tr>

                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $sub->subject_code ?: 'Not provided' }}</td>
                    <td>{{ $sub->subject_title ?: 'Not provided' }}</td>
                    <td>{{ $section->section->name ?: 'Not provided' }}</td>
<<<<<<< Updated upstream
                    {{-- @foreach ( as )

                    @endforeach --}}
                    <td>
                        <?php if (isset($teachers[$index])): ?>
                            <?php echo $teachers[$index]->teacher->full_name; ?>
                        <?php endif; ?>
                    </td>
                    {{-- <td>{{ $teachers->first_name ?: 'Not provided' }}</td> --}}
=======
                    <td>{{ $teacher->first_name ?: 'Not provided' }}</td>
>>>>>>> Stashed changes
                    <td><?php foreach ($sub['day'] as $day): ?>
                        <?php echo $day.','; ?>
                     <?php endforeach; ?>/{{$sub->time_start.'-'.$sub->time_end}}</td>
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

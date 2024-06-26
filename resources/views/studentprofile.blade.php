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
            background-color: #f8f9fa;
        }
        .gradesheet-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            /* border: 1px solid #ddd; */
            border-radius: 5px;
            /* background-color: #fff; */
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
        .personal-info, .emergency-contact {
            margin-bottom: 20px;
        }
        .gradesheet-table {
            width: 100%;
            border-collapse: collapse;
        }
        .gradesheet-table th, .gradesheet-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            vertical-align: middle;
        }
        .gradesheet-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .table-header {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container gradesheet-container">
        <div class="gradesheet-header">
            <h2>Personal Information</h2>
        </div>

        <div class="personal-info">
            <div>
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

        <div class="emergency-contact">
            <h5>Emergency Contact</h5>
            <p>Name: {{ $data->guardian_name }}</p>
            <p>Number: {{ $data->incaseof_emergency }}</p>
        </div>

        <div class="table-header">
            <h2>Subjects</h2>
        </div>

        <table class="gradesheet-table">
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
                @foreach ($subjects as $index => $sub)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $sub->subject_code ?: 'Not provided' }}</td>
                    <td>{{ $sub->subject_title ?: 'Not provided' }}</td>
                    <td>{{ $section->section->name ?: 'Not provided' }}</td>
                    <td>
                        <?php if (isset($teachers[$index])): ?>
                        <?php echo $teachers[$index]->teacher->full_name; ?>
                        <?php endif; ?>
                    </td>
                    {{-- @dd($sub['day']); --}}
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

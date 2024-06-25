<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All Subjects</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
         body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .gradesheet-container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
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
            font-size: 18px;
            font-weight: bold;
            color: red;
            margin-bottom: 10px;
        }
        .personal-info, .educational-history, .emergency-contact {
            margin-bottom: 20px;
        }
        .gradesheet-table th, .gradesheet-table td {
            text-align: center;
            width: 100%;
        }


    </style>
</head>
<body>
    <div class="container ">
        <h1 class="mt-4 center-heading">List of subjects</h1>

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
                @foreach ($subj as  $sub)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $sub->subject_code ?: 'Not provided' }}</td>
                    <td>{{ $sub->subject_title ?: 'Not provided' }}</td>
                    <td>{{ $section->name ?: 'Not provided' }}</td>
                    <td style="width: 200px">{{ $teac->full_name ?: 'Not provided' }}</td>
                    <td style="width: 220px"><?php foreach ($sub['day'] as $day): ?>
                        <?php echo $day.','; ?>
                     <?php endforeach; ?>/{{$sub->time_start.'-'.$sub->time_end}}</td>
                    <td>{{ $sub->subject_type ?: 'Not provided' }}</td>
                    <td>{{ $sub->units ?: 'Not provided' }}</td>
                    <td>{{ $sub->room ?: 'Not provided' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    <div class="footer">
        <p>No. of Subjects: {{ count($subj) }}</p>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Bootstrap JS and dependencies (optional) -->
    <!-- Scripts are usually included at the end of the body section -->
</body>
</html>

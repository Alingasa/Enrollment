{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Students Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
            background-color: #f4f4f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        caption {
            font-size: 1.5em;
            margin: 10px 0;
            font-weight: bold;
            color: #333;
        }
        img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            thead tr {
                display: none;
            }
            tr {
                margin-bottom: 15px;
                border-bottom: 2px solid #ddd;
            }
            td {
                border-bottom: none;
                position: relative;
                padding-left: 50%;
            }
            td:before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 50%;
                padding-left: 15px;
                font-weight: bold;
                background-color: #f2f2f2;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: flex-start;
            }
        }
    </style>
</head>
<body>
    <table>
        <caption>Student Information</caption>
        <thead>
            <tr>
                <th>Profile Image</th>
                <th>Full Name</th>
                <th>Grade Level</th>
                <th>Email</th>
                <th>School ID</th>
                <th>Strand ID</th>
                <th>Section ID</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($student as $students)
            <tr>
                <td data-label="Profile Image">
                    <img src="{{ $students->profile_image ? $students->profile_image : 'default-profile.png' }}" alt="Profile Image">
                </td>
                <td data-label="Full Name">{{ $students->full_name }}</td>
                <td data-label="Grade Level">{{ $students->grade_level }}</td>
                <td data-label="Email">{{ $students->email }}</td>
                <td data-label="School ID">{{ $students->school_id }}</td>
                <td data-label="Strand ID">{{ $students->strand_id }}</td>
                <td data-label="Section ID">{{ $students->section_id }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        @import url(http://fonts.googleapis.com/css?family=Calibri:400,300,700);

        body {
            font-family: 'Calibri', sans-serif !important;
            /* background-color: #f8f9fa; */
        }

        .container {
            margin-top: 50px;
            max-width: 90%;
        }

        .center-content {
            display: flex;
            justify-content: center;
        }

        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px; /* Adjust width as needed */
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-weight: 500;
            font-size: 1.5rem;
            color: #343a40;
        }

        /* .table-responsive {
            margin-top: 1rem;
        } */

        .table {
            width: 100%;
            margin-bottom: 1rem;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
            padding: 0.75rem;
        }

        .table thead th {
            /* background: linear-gradient(45deg, #6a11cb 0%, #2575fc 100%); */
            color: white;
            border: none;
            font-weight: 700;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tbody tr:hover {
            background-color: #e0f7fa;
        }

        .badge-stem {
            background-color: #28a745;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
        }

        .customtable tr:hover .badge-stem {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12 center-content">
                <div class="card">
                    <div class="card-body">

                     <p><b>Code:</b> {{$subject->subject_code}}</p>
                     <p><b>Description:</b> {{$subject->subject_title}}</p>
                    <p><b>Schedule Days: </b><?php foreach ($subject['day'] as $day): ?>
                        <?php echo $day.','; ?>
                     <?php endforeach; ?>
                        </p>
                        <p><b>Time: </b> {{$subject->time_start}} - {{$subject->time_end}} </p>
                        <p><b>Teacher: </b>{{$subject->teacher->full_name}}</p>
                        <center> <h5 class="card-title">List of Students</h5></center>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Grade</th>
                                    <th scope="col">Strand</th>
                                    <th scope="col">Section</th>


                                </tr>
                            </thead>
                            <tbody class="customtable">
                                @foreach($student as $students)
                                <tr>
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td>{{$students->school_id ? : 'Not Provided'}}</td>
                                    <td>{{$students->full_name}}</td>
                                    <td>{{$students->grade_level}}</td>
                                   <td>  @if($strand->strand && $strand->strand->name)
                                        <span class="badge badge-stem">{{$strand->strand->name}}</span>
                                    @else
                                        <span class="badge badge-danger">No Strand</span>
                                    @endif</td>
                                    <td>{{$section->section->name}}</td>
                                </tr>
                                @endforeach

                                <!-- More rows as needed -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="text-right"><strong>Total Students: {{$countStudent}}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

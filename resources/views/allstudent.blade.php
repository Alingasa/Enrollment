<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All Enrolled Students</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        /* Custom CSS for table */
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            word-break: break-word;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6;
        }

        .table .table {
            background-color: #fff;
        }
        .center-heading {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-4 center-heading">List of Enrolled Students</h1>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Grade</th>
                    <th scope="col">Email</th>
                    <th scope="col">School ID</th>
                    <th scope="col">Strand</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $datas)
                <tr>
                    <th scope="row">{{ $index + 1 }}</th>
                    <td style="width: 120px">{{ $datas->full_name ?: 'Not provided' }}</td>
                    <td>{{ $datas->grade_level ?: 'Not provided' }}</td>
                    <td>{{ $datas->email ?: 'Not provided' }}</td>
                    <td>{{ $datas->school_id ?: 'Not provided' }}</td>
                    <td>{{ $datas->strand ?: 'Not provided' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    <div class="footer">
        <p>No. of Students: {{ count($data) }}</p>
    </div>
    </div>

    <!-- Bootstrap JS and dependencies (optional) -->
    <!-- Scripts are usually included at the end of the body section -->
</body>
</html>

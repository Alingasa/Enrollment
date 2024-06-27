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
            border: 1px solid #dee2e6;
            table-layout: auto; /* Makes table columns fixed width */
        }

        .table th,
        .table td {
            padding: .75rem;
            vertical-align: top;
            border: 1px solid #dee2e6;
            word-break: break-word;
            white-space: nowrap;
            text-align: center; /* Center align text in table cells */
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
            background-color: #f8f9fa;
            text-align: center;
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6;
        }

        .center-heading {
            text-align: center;
            margin-bottom: 20px;
            font-family: 'Arial', sans-serif;
            color: #343a40;
        }

        .footer {
            text-align: left;
            margin-top: 20px;
            font-family: 'Arial', sans-serif;
            color: #343a40;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            /* background-color: rgba(0, 0, 0, 0.05); */
        }

        .table-hover tbody tr:hover {
            color: #212529;
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid #dee2e6;
        }

        /* Additional styles for DOMPDF landscape layout */
        @page {
            size: A4 landscape;
            margin: 20mm;
        }

        body {
            font-family: 'Arial', sans-serif;
        }

        .container {
            width: 100%;
            max-width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-4 center-heading">List of Enrolled Students</h1>

        <table class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Grade</th>
                    <th>Email</th>
                    <th>ID</th>
                    <th>Strand</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $datas)
                <tr>
                    <th scope="row">{{ $index + 1 }}</th>
                    <td style="width: 150px">{{ $datas->full_name ?: 'Not provided' }}</td>
                    <td>{{ $datas->grade_level ?: 'Not provided' }}</td>
                    <td>{{ $datas->email ?: 'Not provided' }}</td>
                    <td>{{ $datas->school_id ?: 'Not provided' }}</td>
                    <td>{{ $datas->strand->name ?? 'Not provided' }}</td>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-ppN3U6Y1Y9KREg7XX0Yq4STcMnOTFY+I/Ep9bcgYQZb3p1HUHkCVzVftF5PYF7r9" crossorigin="anonymous"></script>
</body>
</html>

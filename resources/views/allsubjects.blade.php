<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List of Subjects</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            /* background-color: #f8f9fa; */
        }
        .container {
            max-width: 100%; /* Full width container */
            margin: 0 auto; /* Center align */
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .center-heading {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            color: #343a40;
        }
        .gradesheet-table th, .gradesheet-table td {
            text-align: center;
            padding: 8px;
        }
        .gradesheet-table thead {
            background-color: #e9ecef;
        }
        .gradesheet-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
        }

        /* DOMPDF landscape orientation */
        @page {
            size: landscape;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="center-heading">List of Subjects</h1>
        <table class="table table-bordered gradesheet-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Code</th>
                    <th>Subject</th>
                    <th>Section</th>
                    <th>Teacher</th>
                    <th>Schedule</th>
                    <th>Type</th>
                    <th>Units</th>
                    <th>Room</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subj as $sub)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $sub->subject_code ?: 'Not provided' }}</td>
                    <td>{{ $sub->subject_title ?: 'Not provided' }}</td>
                    <td>{{ $sub->section->name ?: 'Not provided' }}</td>
                    <td>{{ $sub->teacher->full_name ?: 'Not provided' }}</td>
                    <td>
                        {{ implode(', ', $sub['day']) }}/{{ $sub->time_start.'-'.$sub->time_end }}
                    </td>
                    <td>{{ $sub->subject_type ?: 'Not provided' }}</td>
                    <td>{{ $sub->units ?: 'Not provided' }}</td>
                    <td>{{ $sub->room ?: 'Not provided' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="footer">
            <p>Total Subjects: {{ count($subj) }}</p>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.24/jspdf.plugin.autotable.min.js"></script>
    <script>
        window.jsPDF = window.jspdf.jsPDF;

        function generatePDF() {
            const doc = new jsPDF();
            doc.text("List of Subjects", 20, 10);
            doc.autoTable({ html: '.gradesheet-table' });
            doc.save('subjects.pdf');
        }

        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.createElement('button');
            btn.textContent = 'Download PDF';
            btn.className = 'btn btn-primary';
            btn.style.display = 'block';
            btn.style.margin = '20px auto';
            btn.onclick = generatePDF;
            document.body.appendChild(btn);
        });
    </script>
</body>
</html>

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
        <h4>Profile Information</h4>
        {{-- <p>Brgy. Atabay, Hilongos, Leyte</p> --}}
    </div>
    {{-- <h5 class="text-right">GRADESHEET</h5> --}}

    <div class="personal-info">
        <h5>Personal Information</h5>
        @if($teacher->profile_image)
        <img style="height: 140px; width: 140px;" src="{{public_path('storage/'.$teacher->profile_image)}}" alt="">
        @else
        <img src="{{public_path('default_images/me.jpg')}}" alt="">
        @endif

        <p>Name: James Pag-iwayan Alingsasa</p>
        <p>Contact: 09973668501</p>
        <p>Gender: Male</p>
        <p>Civil Status: Single</p>
        <p>Religion: Roman Catholic</p>
        <p>Address: Tikab Sitio Tikab Brgy. Atabay, Hilongos Leyte, 6524</p>
        <p>School ID: 21-003065</p>
    </div>

    <div class="gradesheet-title text-center">
        Bachelor of Science in Information Technology
    </div>
    <p class="text-center">Third Year (Second Semester, AY 2023-2024)</p>

    <div class="emergency-contact">
        <h5>Emergency Contact</h5>
        <p>Name: Rosemarie A. Lora</p>
        <p>Number: 09368981592</p>
    </div>

    <div class="educational-history">
        <h6>Educational History</h6>
        <p>LRN: 121380080003</p>
        <p>School Graduated: Hilongos National Vocational School</p>
        <p>School Address: RV. Fulache Street Hilongos Leyte</p>
        <p>Year Graduated: 2021</p>
    </div>

    <table class="table table-bordered gradesheet-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Code</th>
                <th>Description</th>
                <th>Instructor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>PC 118</td>
                <td>System Integration and Architecture 2</td>
                <td>Marnito Mahinlo</td>
            </tr>
            <tr>
                <td>2</td>
                <td>PC 117</td>
                <td>Application Development and Emerging Technologies</td>
                <td>Francis Celsano</td>
            </tr>
            <tr>
                <td>3</td>
                <td>PC 116</td>
                <td>Information Assurance and Security 1</td>
                <td>Mark Joseph Gigante</td>
            </tr>
            <tr>
                <td>4</td>
                <td>PC 115</td>
                <td>System Analysis and Design</td>
                <td>Rosendo Resuelo</td>
            </tr>
            <tr>
                <td>5</td>
                <td>PC 113</td>
                <td>Integrative Programming and Technology 1</td>
                <td>Marnito Mahinlo</td>
            </tr>
            <tr>
                <td>6</td>
                <td>FILIPINO 102</td>
                <td>Ang Panitikan ng Filipino</td>
                <td>Adelaida Millanes</td>
            </tr>
            <tr>
                <td>7</td>
                <td>GEN ELEC 400</td>
                <td>The Entrepreneurial Mind</td>
                <td>Nenita Alibor</td>
            </tr>
            <tr>
                <td>8</td>
                <td>GEN.ED. 112</td>
                <td>Rizal-Life & Works of Dr. Jose Rizal</td>
                <td>Reynaldo Perez</td>
            </tr>
            <tr>
                <td>9</td>
                <td>FREE ELEC 400</td>
                <td>Multimedia System</td>
                <td>Emmanuelle Barrientos</td>
            </tr>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

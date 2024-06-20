<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ID Card</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .id-card {
            width: 350px;
            height: 550px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .id-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
        }

        .header {
            background: linear-gradient(to right, #ff5f6d, #ffc371);
            color: #fff;
            text-align: center;
            padding: 15px 0;
            border-bottom: 5px solid #fff;
            position: relative;
        }

        .header h1 {
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 5px;
            letter-spacing: 2px;
        }

        .header h2 {
            font-size: 1.2em;
            font-weight: normal;
            letter-spacing: 1px;
        }

        .header img {
            width: 50px;
            height: auto;
            position: absolute;
            top: 15px;
            left: 15px;
        }

        .photo {
            text-align: center;
            margin: 20px 0;
        }

        .photo img {
            width: 120px;
            height: 150px;
            border-radius: 10px;
            border: 3px solid #ddd;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .details {
            padding: 20px;
            color: #333;
        }

        .details p {
            margin: 12px 0;
            font-size: 1em;
        }

        .details span {
            font-weight: bold;
            color: #ff5f6d;
        }

        .signature {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0 20px;
            margin: 20px 0;
        }

        .signature .signature-label {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .signature img {
            width: 100px;
            height: auto;
            border: 2px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
        }

        .footer {
            background: #ff5f6d;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: absolute;
            bottom: 0;
            width: 100%;
            border-top: 5px solid #fff;
        }

        .footer p {
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    {{-- {{dd($record)}} --}}
    <div class="id-card">
        <div class="header">
            <img src="/default_images/MLG_Logo.png" alt="Logo">
            <h1>MLGCL</h1>
            <h2>HighSchool</h2>
        </div>
        <div class="photo">
            {{-- <img src="{{ $record->profile_image ?? 'http://try.test/default_images/me.jpg' }}" alt="profile"> --}}
            @if ($record->profile_image)
            <img src='{{"http://enrollment-highschool.webactivities.online/storage/".$record->profile_image}}'; alt="profile"/>
            @else
            <img src="{{'http://enrollment-highschool.webactivities.online/default_images/me.jpg'}}" alt="profile">
            @endif

        </div>
{{-- {{dd($record)}} --}}
        <div class="details">
            <p><span>NAME:</span> {{ $record->full_name}}</p>
            <p><span>DATE OF BIRTH:</span> {{$record->birthdate}}</p>
            <p><span>Age</span> {{$record->age}}</p>
            <p><span>GUARDIAN/PARENT:</span> {{$record->guardian_name}}</p>
            <div class="signature">
                <p class="signature-label">Student Signature</p>

            </div>
        </div>
        <div class="footer">
            <p>{{$record->barangay}}, {{$record->municipality}}, {{$record->province}} - {{$record->zip_code}}</p>
            <p>Contact: {{$record->contact_number}}</p>
        </div>
    </div>
</body>
</html>

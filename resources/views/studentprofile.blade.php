{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student Profile</title>


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
          <div class="footer">
            {{-- <span>No. of students: {{ count($subjects) }}</span> --}}
        {{-- </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student Enrollment Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        /* body{
            background-color: #c4c4c4;
        } */
        fieldset {
            border: 5px solid #000;
            /* Adjust the thickness and color as needed */
            background-image: linear-gradient(to right, #ffffff, #f0f0f0);
            padding: 5px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        legend {
            font-weight: bold;
            padding: 5px 10px;
        }

        .row {
            border-radius: 10px;
            padding: 10px;
        }

        h2 {
            font-weight: bold;
        }

        /* input[type="text"] {
            border: 0.1px solid black;
        } */
    </style>
</head>

<body>
    @if (Session::has('error'))
        <div class="alert alert-danger form-container" role="alert">
            {{ Session::get('error') }}
        </div>
    @endif

    <div class="container mt-5">
        <h2 class="text-center mb-4">Student Enrollment Form</h2>
        <form id="studentform" action="{{ route('students.store') }}" method="post" enctype="multipart/form-data"
            class="row g-3">
            @csrf
            <fieldset class="border p-4 mb-4">
                <legend class="w-auto px-2">Personal Details</legend>
                <div class="row">
                    <div class="col-md-4">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" name="first_name"
                            class="form-control @error('first_name') is-invalid @enderror" id="first_name"
                            value="{{ old('first_name') }}" placeholder="First Name" autofocus>
                        @error('first_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input type="text" name="middle_name"
                            class="form-control @error('middle_name') is-invalid @enderror" id="middle_name"
                            value="{{ old('middle_name') }}" placeholder="Middle Name">
                        @error('middle_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" name="last_name"
                            class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                            value="{{ old('last_name') }}" placeholder="Last Name">
                        @error('last_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" value="{{ old('email') }}" placeholder="Email">
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="contact_number" class="form-label">Phone</label>
                        <input type="number" name="contact_number"
                            class="form-control @error('contact_number') is-invalid @enderror" id="contact_number"
                            value="{{ old('contact_number') }}" placeholder="Phone Number">
                        @error('contact_number')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="gender" class="form-label">Gender</label>
                        <select id="gender" name="gender" class="form-select @error('gender') is-invalid @enderror">
                            <option selected disabled>Choose...</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        @error('gender')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="birthdate" class="form-label">Birthdate</label>
                        <input type="date" name="birthdate"
                            class="form-control @error('birthdate') is-invalid @enderror" id="birthdate"
                            value="{{ old('birthdate') }}" placeholder="Date of Birth">
                        @error('birthdate')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="civil_status" class="form-label">Civil Status</label>
                        <select id="civil_status" name="civil_status"
                            class="form-select @error('civil_status') is-invalid @enderror">
                            <option selected disabled>Choose...</option>
                            <option value="1">Single</option>
                            <option value="2">Married</option>
                            <option value="3">Living Together</option>
                            <option value="4">Separated</option>
                            <option value="5">Divorced</option>
                            <option value="6">Widowed</option>
                        </select>
                        @error('civil_status')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="religion" class="form-label">Religion</label>
                        <select id="religion" name="religion"
                            class="form-select @error('religion') is-invalid @enderror">
                            <option selected disabled>Choose...</option>
                            <option value="Roman Catholic">Roman Catholic</option>
                            <option value="Muslim">Muslim</option>
                            <option value="Protestant">Protestant</option>
                            <option value="Iglesia ni Cristo">Iglesia ni Cristo</option>
                            <option value="Seventh Day Adventist">Seventh Day Adventist</option>
                            <option value="Aglipay">Aglipay</option>
                            <option value="Iglesia Filipina Independiente">Iglesia Filipina Independiente</option>
                            <option value="Bible Baptist Church">Bible Baptist Church</option>
                            <option value="UCCP">UCCP</option>
                            <option value="Jehova's Witness">Jehova's Witness</option>
                            <option value="Church of Christ">Church of Christ</option>
                            <option value="None">None</option>
                        </select>
                        @error('religion')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="facebook_url" class="form-label">Facebook Url</label>
                        <input type="text" name="facebook_url"
                            class="form-control @error('facebook_url') is-invalid @enderror" id="facebook_url"
                            value="{{ old('facebook_url') }}" placeholder="Your Facebook URL">
                        @error('facebook_url')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="profile_image" class="form-label">Upload Profile</label>
                        <input type="file" name="profile_image"
                            class="form-control @error('profile_image') is-invalid @enderror" id="profile_image">
                        @error('profile_image')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </fieldset>

            <fieldset class="border p-4 mb-4">
                <legend class="w-auto px-2">Personal Address</legend>
                <div class="row">
                    <div class="col-md-4">
                        <label for="purok" class="form-label">Purok</label>
                        <input type="text" name="purok"
                            class="form-control @error('purok') is-invalid @enderror" id="purok"
                            value="{{ old('purok') }}" placeholder="Purok">
                        @error('purok')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="sitio_street" class="form-label">Street</label>
                        <input type="text" name="sitio_street"
                            class="form-control @error('sitio_street') is-invalid @enderror" id="sitio_street"
                            value="{{ old('sitio_street') }}" placeholder="Street">
                        @error('sitio_street')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="barangay" class="form-label">Barangay</label>
                        <input type="text" name="barangay"
                            class="form-control @error('barangay') is-invalid @enderror" id="barangay"
                            value="{{ old('barangay') }}" placeholder="Barangay">
                        @error('barangay')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="municipality" class="form-label">Municipality</label>
                        <input type="text" name="municipality"
                            class="form-control @error('municipality') is-invalid @enderror" id="municipality"
                            value="{{ old('municipality') }}" placeholder="Municipality">
                        @error('municipality')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="province" class="form-label">Province</label>
                        <input type="text" name="province"
                            class="form-control @error('province') is-invalid @enderror" id="province"
                            value="{{ old('province') }}" placeholder="Province">
                        @error('province')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="zip_code" class="form-label">Zipcode</label>
                        <input type="text" name="zip_code"
                            class="form-control @error('zip_code') is-invalid @enderror" id="zip_code"
                            value="{{ old('zip_code') }}" placeholder="Zipcode">
                        @error('zip_code')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </fieldset>

            <fieldset class="border p-4 mb-4">
                <legend class="w-auto px-2">In case of Emergency</legend>
                <div class="row">
                    <div class="col-md-6">
                        <label for="guardian_name" class="form-label">Guardian Name</label>
                        <input type="text" name="guardian_name"
                            class="form-control @error('guardian_name') is-invalid @enderror" id="guardian_name"
                            value="{{ old('guardian_name') }}" placeholder="Guardian Name">
                        @error('guardian_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="incaseof_emergency" class="form-label">Emergency Number</label>
                        <input type="number" name="incaseof_emergency"
                            class="form-control @error('incaseof_emergency') is-invalid @enderror"
                            id="incaseof_emergency" value="{{ old('incaseof_emergency') }}"
                            placeholder="Phone Number">
                        @error('incaseof_emergency')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </fieldset>

            <fieldset class="border p-4 mb-4">
                <legend class="w-auto px-2">Enrollment</legend>
                <div class="row">
                    <div class="col-md-6">
                        <label for="grade_level" class="form-label">Grade Level</label>
                        <select id="grade_level" name="grade_level"
                            class="form-select @error('grade_level') is-invalid @enderror">
                            <option selected disabled>Choose...</option>
                            <option value="7">Grade 7</option>
                            <option value="8">Grade 8</option>
                            <option value="9">Grade 9</option>
                            <option value="10">Grade 10</option>
                            <option value="11">Grade 11</option>
                            <option value="12">Grade 12</option>
                        </select>
                        @error('grade_level')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-6" id="stranddiv">
                        <label for="strand" class="form-label">Strand</label>
                        <select id="strand" name="strand"
                            class="form-select @error('strand') is-invalid @enderror">
                            <option selected disabled>Choose...</option>
                            @foreach ($strand as $list)
                                <option value="{{ $list->id }}">{{ $list->name }}</option>
                            @endforeach
                        </select>
                        @error('strand')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </fieldset>

            <div class="d-flex justify-content-between mt-4">
                <input type="submit" class="btn btn-primary" value="Apply for enrollment">
                <a href="/" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLX3RK/Qy3pMAznsG6nnAdN18tbFfDl0ovfyklk3pKTN8e4Rx3mgGoF7hE6Jh" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGkjaFfBL5vMXMdNfPtvHws1mdwI8P5EG5srI6caT8qq+gF9bBJd94tDw+T" crossorigin="anonymous">
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const gradeLevelSelect = document.getElementById('grade_level');
            const strandDiv = document.getElementById('stranddiv');

            gradeLevelSelect.addEventListener('change', function() {
                if (this.value === '11' || this.value === '12') {
                    strandDiv.style.display = 'block';
                } else {
                    strandDiv.style.display = 'none';
                }
            });

            if (gradeLevelSelect.value !== '11' && gradeLevelSelect.value !== '12') {
                strandDiv.style.display = 'none';
            }
        });
    </script>
</body>

</html>

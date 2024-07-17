<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>High School Enrollment</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        body {
            background-image: url('image/island.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            font-family: 'Arial', sans-serif;
            /*
            font-family: 'Arial', sans-serif;
   /* Cover the entire background */
            /* Prevent image from repeating */
        }

        .boxform {
            color: white;
            background-color: rgba(0, 0, 0, 0.8);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 2rem;
            margin-top: 2rem;
            transition: transform 0.3s ease-in-out;
        }

        .boxform:hover {
            transform: translateY(-5px);
            /* Example transformation on hover */
        }

        .form-check-label {
            font-weight: 500;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .alert {
            margin-top: 1rem;
        }

        .form-label {
            /* background-color: rgba(255, 255, 255, 0.5); */
            padding: 2px;
        }

        @media (max-width: 576px) {
            .boxform {
                padding: 1.5rem;
                margin-top: 1rem;
            }

            h3 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        @if (session('success_apply'))
            Swal.fire({
                icon: 'success',
                title: 'Successfully Apply for Enrollment',
                showConfirmButton: false,
                timer: 2500
            });
        @endif
        @if (session('update_success'))
            Swal.fire({
                icon: 'success',
                title: 'Successfully Apply for Enrollment',
                showConfirmButton: false,
                timer: 2500
            });
        @endif
    </script>
    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="boxform p-5">
                    <form id="studenttypeform">
                        @if ($errors->any())
                            <div id="error-alert" class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (Session::has('error'))
                            <div id="error-alert" class="alert alert-danger" role="alert">
                                {{ Session::get('error') }}
                            </div>
                        @elseif ($message = Session::get('success'))
                            <div id="success-alert" class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif

                        <div class="align-items-center">
                            <h3 class="text-center mb-4">Choose Your Option</h3>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="studentType" id="studentType1"
                                    checked>
                                <label class="form-check-label" for="studentType1">
                                    New Student
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="studentType" id="studentType2">
                                <label class="form-check-label" for="studentType2">
                                    Old Student
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="studentType" id="studentType3">
                                <label class="form-check-label" for="studentType3">
                                    Transferee
                                </label>
                            </div>
                            <input type="submit" name="proceed" id="proceed" class="btn btn-primary w-100 mt-3"
                                value="Proceed">

                        </div>
                    </form>

                    <form method="GET" id="schoolidform" hidden>
                        @csrf
                        <div class="mb-3">
                            <div class="col-md-12 mb-3">
                                <label for="school_id" class="form-label">Enter your school ID.</label>
                                <input type="text" class="form-control @error('school_id') is-invalid @enderror"
                                    name="school_id" id="school_id" value="{{ old('school_id') }}" autofocus>
                                @error('school_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <input type="submit" id="enterid" class="btn btn-primary w-100 mt-3" value="Look-Up">
                                <a href="/" class="btn btn-danger w-100 mt-3">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script>
        // Function to check for session messages and display SweetAlert
        function displaySessionMessage() {
            // Check if the session has a success_apply message
            @if (session('success_apply'))
                Swal.fire({
                    icon: 'success',
                    title: 'Successfully Applied for Enrollment',
                    showConfirmButton: false,
                    timer: 2500
                });
            @endif

            // Check if the session has an update_success message
            @if (session('update_success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Successfully Updated Enrollment',
                    showConfirmButton: false,
                    timer: 2500
                });
            @endif
        }

        // Call displaySessionMessage function when the document is ready
        document.addEventListener('DOMContentLoaded', function() {
            displaySessionMessage();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function(event) {
            event.preventDefault();

            setTimeout(function() {
                const errorAlert = document.getElementById('error-alert');
                const successAlert = document.getElementById('success-alert');
                if (errorAlert) errorAlert.style.display = 'none';
                if (successAlert) successAlert.style.display = 'none';
            }, 3000);

            document.getElementById('enterid').addEventListener('click', function(event) {
                const schoolid = document.getElementById("school_id").value;
                if (schoolid === '') {
                    alert("Please input your school ID.");
                    document.getElementById('school_id').focus();
                    event.preventDefault();
                }
            });

            // document.getElementById('grade_level').addEventListener('change',function(){
            //     const grade_level = document.getElementById('grade_level').value;
            //     const strandDiv = document.getElementById('stranddiv');
            //     if(grade_level >= 11){
            //         strandDiv.removeAttribute('hidden');
            //     } else {
            //         strandDiv.setAttribute('hidden', 'true');
            //     }
            // });

            document.getElementById('proceed').addEventListener('click', function(event) {
                event.preventDefault();
                window.location.href = "/students";
            });

            const studentTypeForm = document.getElementById('studenttypeform');
            const hiddenForm = document.getElementById('schoolidform');
            const studentType2 = document.getElementById('studentType2');

            function toggleForms() {
                if (studentType2.checked) {
                    hiddenForm.removeAttribute('hidden');
                    studentTypeForm.setAttribute('hidden', true);
                } else {
                    hiddenForm.setAttribute('hidden', true);
                    studentTypeForm.removeAttribute('hidden');
                }
            }

            studentTypeForm.addEventListener('change', toggleForms);
            toggleForms();
        });

        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('schoolidform');

            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                var schoolId = document.getElementById('school_id').value; // Get the school_id input value

                // Construct the URL dynamically with the school_id value
                var actionUrl = '/findschoolid/' + encodeURIComponent(schoolId);


                // Set the action attribute of the form
                form.setAttribute('action', actionUrl);

                // Submit the form
                form.submit();
            });
        });
    </script>
</body>

</html>

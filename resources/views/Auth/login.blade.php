<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management - Login</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .error {
            color: red;
            font-size: 14px;
            font-weight: bold;
        }

        label {
            font-weight: bold;
        }

        .form-group input {
            border: 1px solid black;
        }
        .error-input {
        border: 1px solid red !important;
        }
        .error-message {
        color: red;
        }
    </style>
</head>

<body>
    <div class="container col-lg-8 col-md-8 mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Login
                            <a href="{{ route('register') }}" class="btn btn-danger float-end">Sign Up</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}" id="loginForm"  onsubmit="validate()">
                            @csrf
                            <div class="mb-3">
                                <label for="username">Username or Email:</label>
                                <input type="text" id="username" name="username" class="form-control" />
                                <span id="username_error" class="error-message"></span>
                            </div>
                            <div class="mb-3">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" class="form-control" />
                                <div id="password_error" class="error-message"></div>
                            </div>
                            <div class="text-center">
                                <button type="reset" class="btn btn-secondary">Reset</button>
                                <button type="submit" class="btn btn-info">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        $(document).ready(function () {
            function validate() {
                let valid = true;
                // Username Validation
                if ($('#username').val().trim() === '') {
                    $('#username_error').text('Username is required.');
                    $('#username').addClass('error-input');
                    valid = false;
                } else {
                    $('#username_error').text('');
                    $('#username').removeClass('error-input');
                }

                // Password Validation
                if ($('#password').val().trim() === '') {
                    $('#password_error').text('Password is required.');
                    $('#password').addClass('error-input');
                    valid = false;
                } else {
                    $('#password_error').text('');
                    $('#password').removeClass('error-input');
                }

                return valid;
            }
            $('#loginForm').submit(function (event) {
                event.preventDefault();

                if (!validate()) return; // Stop if custom validation fails

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function (response) {
                        Swal.fire({
                            title: 'Success',
                            text: response.success,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = "{{ route('dashboard') }}";
                        });
                    },
                    error: function (xhr) {
                        let errorMessage = 'An error occurred.';

                        if (xhr.status === 422 && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            errorMessage = Object.values(errors).join('\n');
                        } else if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }

                        Swal.fire({
                            title: 'Error',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>

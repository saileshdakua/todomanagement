<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Task_Management</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    label {
      font-weight: bold;
    }

    .form-group input {
      border: 1px solid black;
    }

    .form-group select {
      border: 1px solid black;
    }

    .table-responsive input {
      border: 1px solid black;
    }

    .form-group textarea {
      border: 1px solid black;
    }

    .error-input {
      border: 1px solid red !important;
    }

    .error-message {
      color: red;
    }

    .success-message {
      color: green;
    }
  </style>
</head>

<body>
  <section>
    <div class="col-lg-8 col-md-8 container-fluid mt-5">
      <div class="card">
        <div class="card-header">
          <h4>Registration</h4>
        </div>
        <div class="card-body w-100 m-0">

          <div class="mt-4" style="background-color: rgba(245, 245, 245, 0.69); padding: 20px; border-radius: 10px;">
            <h2 class="text-center">Student Registration Form</h2>

            <div class="container">
              <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="regemp" onsubmit="validate()">
                @csrf
                <div class="row">
                  <h5 class="text-start mt-4 mb-4"><u>Basic Information</u></h5>
                  <div class="form-group col-md-6">
                    <label for="name">Name:</label>
                    <input id="name" type="text" class="form-control" name="name">
                    <div id="name_error" class="error-message"></div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="email">Email:</label>
                    <input id="email" type="email" class="form-control" name="email">
                    <div id="email_error" class="error-message"></div>
                    <div id="emailStatus"></div>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="phno">Mobile:</label>
                    <input id="phno" type="number" class="form-control" name="phno">
                    <div id="phno_error" class="error-message"></div>
                  </div>
                  <div class="form-group col-md-4">
                    <label>Gender:</label><br>
                    <div class="form-check-inline">
                      <input type="radio" class="form-check-input" id="male" name="gender" value="Male">
                      <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check-inline">
                      <input type="radio" class="form-check-input" id="female" name="gender" value="Female">
                      <label class="form-check-label" for="female">Female</label>
                    </div>
                    <div class="form-check-inline">
                      <input type="radio" class="form-check-input" id="other" name="gender" value="Other">
                      <label class="form-check-label" for="other">Other</label>
                    </div>
                    <div id="gender_error" class="error-message"></div>

                  </div>
                  <div class="form-group col-md-4">
                    <label for="dob">DOB:</label>
                    <input id="dob" type="date" class="form-control" name="dob">
                    <div id="dob_error" class="error-message"></div>
                  </div>
                  <!-- Button to add new rows -->

                  <h5 class="text-start mt-4 mb-4"><u>Credentials</u></h5>
                  <!-- Username -->
                  <div class="form-group col-md-6">
                    <label for="username">Username:</label>
                    <input id="username" type="text" class="form-control" name="username">
                    <span id="username_error" class="error-message"></span>
                    <span id="usernameStatus"></span>
                  </div>

                  <!-- Password -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="password">Password:</label>
                      <input id="password" type="password" class="form-control" name="password" maxlength="16">
                      <div id="password_error" class="error-message"></div>
                    </div>
                  </div>
                  <div class="col-md-12 text-center mt-4">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary" name="register">Submit</button>
                  </div>
                </div>
              </form>
              <p>Already registered? <a href="{{ route('login.form') }}">Login</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $(document).ready(function() {
      // Validate function
      function validate() {
        let valid = true;

        // Name Validation
        if ($('#name').val().trim() === '') {
          $('#name_error').text('Name is required.');
          $('#name').addClass('error-input');
          valid = false;
        } else {
          $('#name_error').text('');
          $('#name').removeClass('error-input');
        }

        // Email Validation
        let emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
        if (!emailPattern.test($('#email').val().trim())) {
          $('#email_error').text('Valid email is required.');
          $('#email').addClass('error-input');
          valid = false;
        } else {
          $('#email_error').text('');
          $('#email').removeClass('error-input');
        }

        // Phone Validation
        if ($('#phno').val().length !== 10) {
          $('#phno_error').text('Mobile number must be 10 digits.');
          $('#phno').addClass('error-input');
          valid = false;
        } else {
          $('#phno_error').text('');
          $('#phno').removeClass('error-input');
        }

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
        let password = $('#password').val();
        let passwordPattern = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;
        if (!passwordPattern.test(password)) {
          $('#password_error').text('Password must contain at least one uppercase, one lowercase, one number, one special character, and be at least 6 characters long.');
          $('#password').addClass('error-input');
          valid = false;
        } else {
          $('#password_error').text('');
          $('#password').removeClass('error-input');
        }

        return valid;
      }

      // Submit Registration Form via AJAX
      $('#regemp').submit(function(event) {
        event.preventDefault();

        if (!validate()) return;

        $.ajax({
          type: 'POST',
          url: $(this).attr('action'),
          data: $(this).serialize(),
          success: function(response) {
            Swal.fire({
              title: 'Success',
              text: response.success,
              icon: 'success',
              confirmButtonText: 'OK'
            }).then(() => {
              window.location.href = "{{ route('login.form') }}";
            });
          },
          error: function(xhr) {
            if (xhr.status === 422) {
              let errors = xhr.responseJSON.errors;
              $('.error-text').html('');
              for (let field in errors) {
                $('#' + field + '_error').text(errors[field][0]);
              }
            } else {
              Swal.fire('Error', 'Something went wrong!', 'error');
            }
          }
        });
      });
    });
  </script>


</body>

</html>
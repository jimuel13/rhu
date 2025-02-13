<!DOCTYPE html>
<html lang="zxx">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="description" content="Orbitor,business,company,agency,modern,bootstrap4,tech,software">
  <meta name="author" content="themefisher.com">

  <title>Register</title>

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico" />

  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
  <!-- Icon Font Css -->
  <link rel="stylesheet" href="plugins/icofont/icofont.min.css">
  <!-- Slick Slider  CSS -->
  <link rel="stylesheet" href="plugins/slick-carousel/slick/slick.css">
  <link rel="stylesheet" href="plugins/slick-carousel/slick/slick-theme.css">

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/register.css">
  <link rel="stylesheet" href="css/output.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src='https://unpkg.com/tesseract.js@v2.1.0/dist/tesseract.min.js'></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/react@17/umd/react.development.js"></script>
  <script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.js"></script>

  <style>
        /* Add scrolling to the form container */
        body, html {
            height: 100%;
            margin: 0;
          }

          .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: auto; /* Allow scrolling */
          }

          #registration-form {
            max-height: 90vh; /* Limit the height to 90% of the viewport height */
            overflow-y: auto; /* Enable vertical scrolling */
            padding-bottom: 20px; /* Ensure there's some space at the bottom */
          }
  </style>
</head>
<body class="hero-section">
    <div class="hero-section flex items-center justify-center">

        <form id="registration-form" action="/register" method="POST" enctype="multipart/form-data" class="space-y-4 mt-4 p-6 mx-auto form-container">
            @csrf
                <h1 class="text-2xl font-bold text-black">Registration</h1>
            <p class="text-black">Fill the information carefully</p>
            <fieldset class="border border-muted rounded-lg p-4">
                <legend class="font-semibold text-black">Personal Information</legend>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-black" for="first-name">First Name *</label>
                        <input class="border border-border rounded-lg p-2 w-full" type="text" name="f_name" placeholder="Enter First Name" required oninput="capitalizeAndValidate(event, this)" />
                    </div>
                    <div>
                        <label class="block text-black" for="middle-initial">M.I.</label>
                        <input class="border border-border rounded-lg p-2 w-full" type="text" name="m_name" placeholder="Middle Initial" oninput="capitalizeAndValidate(event, this)"/>
                    </div>
                    <div>
                        <label class="block text-black" for="last-name">Last Name *</label>
                        <input  class="border border-border rounded-lg p-2 w-full" type="text" name="l_name" placeholder="Enter Last Name" required  oninput="capitalizeAndValidate(event, this)"/>
                    </div>
                    <div>
                        <label class="block text-black" for="suffix">Suffix (Optional)</label>
                        <input class="border border-border rounded-lg p-2 w-full" type="text" name="suffix" placeholder="Jr., Sr." />
                    </div>
                    <div>
                        <label class="block text-black" for="dob">Date of Birth (mm/dd/yy) *</label>
                        <input class="border border-border rounded-lg p-2 w-full" type="date" name="bday" required />
                    </div>
                    <div>
                        <label class="block text-black" for="gender">Gender *</label>
                        <div class="flex items-center">
                            <input type="radio" name="gender" value="male" class="mr-2 -mt-10" required />
                            <label for="male" class="text-black -mt-7">Male</label>
                            <input type="radio" name="gender" value="female" class="ml-3 mr-2 -mt-10" />
                            <label for="female" class="text-black -mt-7">Female</label>
                            <input type="radio" name="gender" value="prefer-not-say" class="ml-3 mr-2 -mt-10" />
                            <label for="prefer-not-say" class="text-black">Prefer not to say</label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-black -mt-9" for="mobile-number">Mobile Number *</label>
                        <input class="border border-border rounded-lg p-2 w-full" type="tel" name="contactNo" placeholder="Enter mobile number" required  oninput="validateMobileNumber(this)" />
                    </div>
                </div>
            </fieldset>

            <fieldset class="border border-muted rounded-lg p-4">
                <legend class="font-semibold text-black">Residential Information</legend>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-black" for="street">Street/Sitio Address *</label>
                        <input class="border border-border rounded-lg p-2 w-full" type="text" name="street" placeholder="Enter your street" required />
                    </div>
                    <div>
                        <label class="block text-black" for="brgy">Barangay *</label>
                        <select class="border border-border rounded-lg p-2 w-full" name="brgy" required>
                            <option value="">Select your barangay</option>
                            <option value="Barangay 1">Barangay 1</option>
                            <option value="Barangay 2">Barangay 2</option>
                            <option value="Barangay 3">Barangay 3</option>
                            <option value="Barangay 4">Barangay 4</option>
                            <option value="Barangay 5">Barangay 5</option>
                            <option value="Barangay 5">Barangay 6</option>
                            <option value="Barangay 5">Barangay 7</option>
                            <option value="Barangay 5">Barangay 8</option>
                            <option value="Barangay 5">Barangay 9</option>
                            <option value="Barangay 5">Barangay 10</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-black" for="zip-code">Zip Code *</label>
                        <input class="border border-border rounded-lg p-2 w-full font-bold text-black" type="text" name="zip_code" value="4328" readonly />
                    </div>
                    <div>
                        <label class="block text-black" for="municipality">Municipality *</label>
                        <input class="border border-border rounded-lg p-2 w-full font-bold text-black" type="text" name="municipality" value="Lucban" readonly />
                    </div>
                    <div>
                        <label class="block text-black" for="province">Province *</label>
                        <input class="border border-border rounded-lg p-2 w-full font-bold text-black" type="text" name="province" value="Quezon" readonly />
                    </div>
                    <div>
                        <label class="block text-black" for="upload-id">Upload Residential ID *</label>
                        <input class="border border-border rounded-lg p-2 w-full" type="file" name="upload_id" required />
                    </div>
                </div>
            </fieldset>

            <fieldset class="border border-muted rounded-lg p-4">
                <legend class="font-semibold text-black">Account Information</legend>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-black" for="username">Username *</label>
                        <input class="border border-border rounded-lg p-2 w-full" type="text" name="username" placeholder="Enter your username" required />
                    </div>
                    <div>
                        <label class="block text-black" for="email">Email Address *</label>
                        <input
                            class="border border-border rounded-lg p-2 w-full"
                            type="email"
                            name="email"
                            id="email"
                            placeholder="Enter your Gmail address"
                            required
                        />
                        <small id="emailError" style="color: red; display: none;">Please enter a valid Gmail address.</small>
                    </div>

                    <div>
                        <label class="block text-black" for="password">Password *</label>
                        <input class="border border-border rounded-lg p-2 w-full" type="password" name="password" placeholder="Enter your password" required />
                    </div>
                    <div>
                        <label for="password_confirmation" class="form-label">Confirm Password *</label>
                        <input type="password" class="border border-border rounded-lg p-2 w-full" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
                    </div>
                </div>
            </fieldset>


            <button type="submit" class="bg-blue-500 text-white hover:bg-blue-600 p-2 rounded-lg w-full">Register</button>

            <p class="text-center text-black mt-4">Already Have an Account? <a href="/login" class="ml-auto text-blue-500 hover:underline">Login</a></p>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        // Validate email on blur
        $('#email').on('blur', function () {
            const email = $(this).val();
            const domain = email.split('@')[1]; // Get the domain part of the email

            if (domain && domain.toLowerCase() === 'gmail.com') {
                $('#emailError').hide(); // Hide the error message if valid
                $(this).css('border-color', ''); // Reset border color
            } else {
                $('#emailError').show(); // Show the error message if invalid
                $(this).css('border-color', 'red'); // Highlight the input with a red border
            }
        });

        // Prevent form submission if the email is not Gmail
        $('#registration-form').on('submit', function (e) {
            const email = $('#email').val();
            const domain = email.split('@')[1]; // Get the domain part of the email

            if (!domain || domain.toLowerCase() !== 'gmail.com') {
                e.preventDefault(); // Prevent form submission
                Swal.fire({
                    title: 'Invalid Email',
                    text: 'Please enter a valid Gmail address.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });
            }
        });
    });
</script>



<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if ($errors->any())
        let errorMessage = '';
        @foreach ($errors->all() as $error)
            if (errorMessage === '') {
                errorMessage = '{{ $error }}';
            }
        @endforeach

        Swal.fire({
            title: 'Validation Error',
            text: errorMessage,
            icon: 'error',
            confirmButtonText: 'OK',
        });
    @endif
</script>

    {{-- for fname, mname and lname validation --}}
    <script>
        function capitalizeAndValidate(event, input) {
            // Keep only letters and spaces
            let inputValue = input.value.replace(/[^a-zA-Z\s]/g, '');

            // Allow only one space between words by replacing multiple spaces with a single space
            inputValue = inputValue.replace(/\s+/g, ' ');

            // Capitalize the first letter of each word
            inputValue = inputValue.replace(/\b\w/g, char => char.toUpperCase());

            // Set the cleaned-up value back to the input field
            input.value = inputValue;
        }
    </script>

{{-- contact no validation --}}
<script>
    function validateMobileNumber(input) {
        // Allow only numeric input
        input.value = input.value.replace(/[^0-9]/g, '');

        // If the input length is less than 2, allow typing the first '0' and '9'
        if (input.value.length === 1 && input.value !== '0') {
            input.value = '';  // Clear if the first digit is not '0'
        }

        // If the user types "09", allow the rest of the digits to be typed
        if (input.value.length === 2 && input.value !== '09') {
            input.value = '09';  // Force '09' as the first two digits
        }

        // Limit the length to 11 digits
        if (input.value.length > 11) {
            input.value = input.value.slice(0, 11);
        }
    }
</script>
</body>
</html>

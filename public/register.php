<?php
// Database connection
$host = "localhost"; // Replace with your host
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$database = "ehealth"; // Replace with your database name

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success_message = '';
$error_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $first_name = $_POST['first_name'];
    $middle_initial = $_POST['middle_initial'];
    $last_name = $_POST['last_name'];
    $suffix = $_POST['suffix'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $mobile_number = $_POST['mobile_number'];
    $street = $_POST['street'];
    $barangay = $_POST['barangay'];
    $zip_code = $_POST['zip_code'];
    $municipality = $_POST['municipality'];
    $province = $_POST['province'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

    // Handle file upload
    $upload_dir = 'uploads_id/';

    // Check if the directory exists, create if not
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);  // Create directory if not exists
    }

    // Check if file was uploaded without errors
    if ($_FILES['upload_id']['error'] != UPLOAD_ERR_OK) {
        switch ($_FILES['upload_id']['error']) {
            case UPLOAD_ERR_INI_SIZE:
                die("The uploaded file exceeds the upload_max_filesize directive in php.ini.");
                break;
            case UPLOAD_ERR_FORM_SIZE:
                die("The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.");
                break;
            case UPLOAD_ERR_PARTIAL:
                die("The uploaded file was only partially uploaded.");
                break;
            case UPLOAD_ERR_NO_FILE:
                die("No file was uploaded.");
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                die("Missing a temporary folder.");
                break;
            case UPLOAD_ERR_CANT_WRITE:
                die("Failed to write file to disk.");
                break;
            case UPLOAD_ERR_EXTENSION:
                die("A PHP extension stopped the file upload.");
                break;
            default:
                die("Unknown upload error.");
                break;
        }
    }

    // Sanitize and process file name
    $filename = basename($_FILES['upload_id']['name']);
    $ext = pathinfo($filename, PATHINFO_EXTENSION); // Get file extension
    $new_filename = uniqid() . '.' . $ext; // Generate a unique file name

    $upload_file = $upload_dir . $new_filename;

    // Validate file extension (Allow JPG, JPEG, PNG, GIF)
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array(strtolower($ext), $allowed_ext)) {
        die("Invalid file type. Only JPG, JPEG, PNG, GIF are allowed.");
    }

    // Validate file size (max 5MB)
    if ($_FILES['upload_id']['size'] > 5 * 1024 * 1024) { // 5MB
        die("File size exceeds the 5MB limit.");
    }

    // Move the uploaded file to the upload directory
    if (move_uploaded_file($_FILES['upload_id']['tmp_name'], $upload_file)) {
        $upload_id = $upload_file; // Save the full path to the database
    } else {
        die("Error uploading file.");
    }

    // Password Confirmation
    if ($_POST['password'] !== $_POST['confirm_password']) {
        die("Passwords do not match.");
    }

    // Error Handling for Duplicate Username/Email
    $check_query = "SELECT * FROM registration WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Output JavaScript alert in the browser
        echo "<script type='text/javascript'>alert('Username or Email already exists.');</script>";
        // Optionally, you can redirect the user to the registration page again
        echo "<script type='text/javascript'>window.location.href='register.php';</script>";
    }


    // Insert data into database
    if (empty($error_message)) {
        $query = "INSERT INTO registration (first_name, middle_initial, last_name, suffix, dob, gender, mobile_number, street, barangay, zip_code, municipality, province, upload_id, username, email, password)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssssssssssss", $first_name, $middle_initial, $last_name, $suffix, $dob, $gender, $mobile_number, $street, $barangay, $zip_code, $municipality, $province, $upload_id, $username, $email, $password);

        if ($stmt->execute()) {
            $success_message = "Registration successful! Please wait for approval.";
        } else {
            $error_message = "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>


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
        <form id="registration-form" method="POST" enctype="multipart/form-data" class="space-y-4 mt-4 p-6 mx-auto form-container">
            <h1 class="text-2xl font-bold text-black">Registration</h1>
            <p class="text-black">Fill the information carefully</p>
            <fieldset class="border border-muted rounded-lg p-4">
                <legend class="font-semibold text-black">Personal Information</legend>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-black" for="first-name">First Name *</label>
                        <input class="border border-border rounded-lg p-2 w-full" type="text" name="first_name" placeholder="Enter First Name" required />
                    </div>
                    <div>
                        <label class="block text-black" for="middle-initial">M.I.</label>
                        <input class="border border-border rounded-lg p-2 w-full" type="text" name="middle_initial" placeholder="Middle Initial" />
                    </div>
                    <div>
                        <label class="block text-black" for="last-name">Last Name *</label>
                        <input class="border border-border rounded-lg p-2 w-full" type="text" name="last_name" placeholder="Enter Last Name" required />
                    </div>
                    <div>
                        <label class="block text-black" for="suffix">Suffix (Optional)</label>
                        <input class="border border-border rounded-lg p-2 w-full" type="text" name="suffix" placeholder="Jr., Sr." />
                    </div>
                    <div>
                        <label class="block text-black" for="dob">Date of Birth (mm/dd/yy) *</label>
                        <input class="border border-border rounded-lg p-2 w-full" type="date" name="dob" required />
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
                        <input class="border border-border rounded-lg p-2 w-full" type="tel" name="mobile_number" placeholder="Enter mobile number" required />
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
                        <label class="block text-black" for="barangay">Barangay *</label>
                        <select class="border border-border rounded-lg p-2 w-full" name="barangay" required>
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
                        <input class="border border-border rounded-lg p-2 w-full" type="email" name="email" placeholder="Enter your email" required />
                    </div>
                    <div>
                        <label class="block text-black" for="password">Password *</label>
                        <input class="border border-border rounded-lg p-2 w-full" type="password" name="password" placeholder="Enter your password" required />
                    </div>
                    <div>
                        <label class="block text-black" for="confirm-password">Confirm Password *</label>
                        <input class="border border-border rounded-lg p-2 w-full" type="password" name="confirm_password" placeholder="Confirm your password" required />
                    </div>
                </div>
            </fieldset>

            <div class="flex items-center mt-4">
                <input type="checkbox" id="terms" class="mr-2 -mt-2" required />
                <label for="terms" class="text-black">
                    <a href="#" class="text-blue-500">I have read and agree to the Terms of Service</a>
                </label>
            </div>

            <button type="submit" class="bg-blue-500 text-white hover:bg-blue-600 p-2 rounded-lg w-full">Register</button>

            <p class="text-center text-black mt-4">Already Have an Account? <a href="login1.php" class="ml-auto text-blue-500 hover:underline">Login</a></p>
        </form>
    </div>

    <?php if ($success_message): ?>
        <script>
            alert("<?= $success_message; ?>");
        </script>
    <?php endif; ?>

    <?php if ($error_message): ?>
        <script>
            alert("Error: <?= $error_message; ?>");
        </script>
    <?php endif; ?>


    <script src="js/Registration.js"></script>
    <!--
    Essential Scripts
    =====================================-->


    <!-- Main jQuery -->
    <script src="plugins/jquery/jquery.js"></script>
    <!-- Bootstrap 4.3.2 -->
    <script src="plugins/bootstrap/js/popper.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/counterup/jquery.easing.js"></script>
    <!-- Slick Slider -->
    <script src="plugins/slick-carousel/slick/slick.min.js"></script>
    <!-- Counterup -->
    <script src="plugins/counterup/jquery.waypoints.min.js"></script>

    <script src="plugins/shuffle/shuffle.min.js"></script>
    <script src="plugins/counterup/jquery.counterup.min.js"></script>
    <!-- Google Map -->
    <script src="plugins/google-map/map.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkeLMlsiwzp6b3Gnaxd86lvakimwGA6UA&callback=initMap"></script>

    <script src="js/script.js"></script>

  </body>
  </html>

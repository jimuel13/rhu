<?php
session_start();

// Include the database connection file
include('../connection.php'); // Make sure this path is correct

// Initialize error message variable
$error_message = "";
$redirect_url = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the inputs
    if (empty($username) || empty($password)) {
        echo "<script>alert('Please enter both username and password.');</script>";
    } else {
        // Query the database for the admin user
        $sql = "SELECT * FROM admin WHERE username = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the admin exists
        if ($result->num_rows > 0) {
            // Fetch admin data
            $admin = $result->fetch_assoc();

            // Check if the password matches
            if (password_verify($password, $admin['password'])) {
                // Check admin status
                if ($admin['status'] === 'Available') {
                    // Set session and redirect based on department
                    $_SESSION['username'] = $username;
                    $department = $admin['department']; // Assuming department column exists

                    // Alert message for successful login
                    echo "<script>alert('Login Successful');</script>";

                    // Redirect based on department
                    switch ($department) {
                        case 'Blood':
                            $redirect_url = "../admin/blood.html";
                            break;
                        case 'Cashier':
                            $redirect_url = "../admin/cashier.html";
                            break;
                        case 'Consultation':
                            $redirect_url = "../admin/consultation.php";
                            break;
                        case 'Inventory':
                            $redirect_url = "../admin/inventory.html";
                            break;
                        case 'IT':
                            $redirect_url = "../admin/it_personnel.html";
                            break;
                        case 'Laboratory':
                            $redirect_url = "../admin/laboratory.php";
                            break;
                        case 'MHO':
                            $redirect_url = "../admin/super_admin.html";
                            break;
                        case 'Vaccination':
                            $redirect_url = "../admin/vaccination.html";
                            break;
                        default:
                            echo "<script>alert('Invalid department.');</script>";
                            exit();
                    }

                    echo "<script>window.location.href = '$redirect_url';</script>";
                    exit();
                } else {
                    // Alert message for unavailable admin account
                    echo "<script>alert('Your admin account is unavailable.');</script>";
                }
            } else {
                // Alert message for incorrect password
                echo "<script>alert('Incorrect password.');</script>";
            }
        } else {
            // Alert message for non-existent admin
            echo "<script>alert('Admin doesn't exist.');</script>";
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="description" content="Orbitor,business,company,agency,modern,bootstrap4,tech,software">
  <meta name="author" content="themefisher.com">

  <title>Login</title>

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

</head>

<body class="bg-gray-100">
    <div class="hero-section">
        <form id="login-form" class="login-container" method="POST">
            <h1 class="login-title">ADMIN LOGIN</h1>
            <div>
                <label class="login-label">Username:</label>
                <input type="text" name="username" id="username" placeholder="Enter your username" required class="login-input" />
            </div>
            <div>
                <label class="login-label">Password:</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required class="login-input" />
            </div>

            <?php if ($error_message != ""): ?>
                <p id="error-message" class="error-message"><?php echo $error_message; ?></p>
                <script>
                    alert("<?php echo $error_message; ?>");
                    window.location.href = "<?php echo $redirect_url; ?>";  // Redirect after alert
                </script>
            <?php endif; ?>

            <button type="submit" class="login-button mb-4">LOGIN</button>
            <a href="login1.php" class="login-button bg-blue-500 text-white hover:bg-blue-600 text-center no-underline inline-block">LOGIN AS PATIENT</a>
            <p class="signup-text">
            <p class="signup-text">
                Don't have an account? <a href="register.php" class="signup-link">Sign Up</a>
            </p>
        </form>
    </div>

    <div id="success-container">
        <div class="text-center p-8 bg-green-100 border border-green-300 text-green-800 rounded-lg">
            <p class="text-lg font-semibold">Login successful!</p>
            <a href="afterlogin.html" class="bg-blue-500 text-white hover:bg-blue-600 p-2 rounded-lg mt-4 inline-block">Go to Home</a>
        </div>
    </div>

    <script src="js/Registration.js"></script>
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

    <script src="js/script.js"></script>

</body>
</html>


<?php
// Database connection
include('../connection.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $department = $conn->real_escape_string($_POST['department']);

    // Validate that passwords match
    if ($_POST['password'] !== $_POST['confirm_password']) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        // Insert the new admin into the database
        $sql = "INSERT INTO admin (name, email, username, password, department) 
                VALUES ('$name', '$email', '$username', '$password', '$department')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New admin added successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Admin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/src/output.css">
    <link rel="stylesheet" href="/src/custom.css">
    <script src="/src/javascript/blood.js" defer></script>
</head>
<body>
    <div class="flex flex-col h-screen">
    <!-- Top navigation -->
    <div class="bg-white p-2 sticky top-0 z-50 shadow-md">
      <div class="flex items-center">
        <img src="/src/img/ehealth.png" alt="ehealth" class="h-12 w-25 sm:h-12 ml-8">
        <div class="ml-auto flex items-center space-x-4">
          <!-- Notification Bell with Dropdown -->
          <div class="relative">
            <button id="notifDropdownToggle" class="ml-2">
              <img aria-hidden="true" alt="notification-bell" src="/src/img/notif.png" class="h-6 w-6" />
            </button>
            <!-- Notification Dropdown -->
            <div id="notifDropdownMenu"
              class="absolute right-0 mt-2 w-80 bg-white border border-zinc-200 rounded-lg shadow-lg hidden z-10">
              <div class="p-4">
                <p class="text-sm font-semibold">Notifications</p>
              </div>
              <div class="border-t border-zinc-200">
                <a href="#" class="block px-4 py-2 text-sm text-zinc-700 hover:bg-zinc-200">🔴 You have a new
                  appointment request.</a>
                <a href="#" class="block px-4 py-2 text-sm text-zinc-700 hover:bg-zinc-200">🔴 Blood bag stock
                  updated.</a>
              </div>
              <div class="text-center py-2 border-t border-zinc-200">
                <a href="#" class="text-blue-500 text-sm">View all notifications</a>
              </div>
            </div>
          </div>
          <span class="text-zinc-800 text-1xl">IT_Personnel</span>
          <!-- User Icon with Dropdown -->
          <div class="relative">
            <button id="userDropdownToggle" class="ml-2">
              <img aria-hidden="true" alt="user-icon" src="/src/img/user.png" class="h-10 w-10" />
            </button>

            <!-- Dropdown Menu -->
            <div id="userDropdownMenu"
              class="absolute text-center right-0 mt-2 w-40 bg-white border border-zinc-200 rounded-lg shadow-lg hidden z-10">
              <a href="/src/admin/it_profile.html" class="block px-4 py-2 text-sm text-zinc-700 hover:bg-blue-500 hover:text-white">Profile</a>
              <a href="/src/homepage.html" class="block px-4 py-2 text-sm text-zinc-700 hover:bg-red-500 hover:text-white">Logout</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  
        <div class="flex flex-1">
          <!--Sidenav-->
          <nav class="w-72 bg-white pt-5 shadow-md">
            <ul class="space-y-5 text-1xl">
                <li><a href="it_personnel.html" class="text-zinc-700 block py-2 pl-10">Dashboard</a></li>
                <li><a href="it_verify.php" class="text-zinc-700 pl-10">Registration Verification</a></li>
                <li><a href="it_admin.php" class="text-zinc-700 pl-10">User Management</a></li>
                <li class="bg-blue-600 rounded-r-full"><a href="add_admin.php" class="text-white block py-2 pl-10">Add New Admin</a></li>
                <li><a href="it_audit.html" class="text-zinc-700 pl-10">Audit Logs</a></li>
            </ul>
            <div class="p-4 text-center">
              <p class="text-sm pt-[200px] font-semibold">Logged in as:</p>
              <p class="text-lg font-bold">Angela P. Madrid</p>
              <p class="text-sm">IT_Personnel</p>
            </div>
        </nav>
        
        <main class="w-full bg-blue-200 p-8">
          <h1 class="text-2xl font-bold mb-6">Add New Admin</h1>
          <form method="POST" action="">
          <div class="flex">
            <div class="w-1/2 space-y-4">
              <div>
                <label class="block text-lg">Name:</label>
                <input type="text" name="name" class="border border-zinc-300 p-2 rounded w-full" placeholder="" />
              </div>
              <div>
                <label class="block text-lg">Email:</label>
                <input type="email" name="email" class="border border-zinc-300 p-2 rounded w-full" placeholder="" />
              </div>
              <div>
                <label class="block text-lg">Username:</label>
                <input type="text" name="username" class="border border-zinc-300 p-2 rounded w-full" placeholder="" />
              </div>
              <div>
                <label class="block text-lg">Password:</label>
                <input type="password" name="password" class="border border-zinc-300 p-2 rounded w-full" placeholder="" />
              </div>
              <div>
                <label class="block text-lg">Confirm Password:</label>
                <input type="password" name="confirm_password" class="border border-zinc-300 p-2 rounded w-full" placeholder="" />
              </div>
            </div>

            <div class="w-1/2 pl-8">
              <label class="block text-lg mb-2">Department:</label>
              <div class="space-y-2">
                <label class="flex items-center">
                  <input type="radio" name="department" value="Dental Clinic" class="mr-2" />
                  Dental Clinic
                </label>
                <label class="flex items-center">
                  <input type="radio" name="department" value="Consultation" class="mr-2" checked />
                  Consultation
                </label>
                <label class="flex items-center">
                  <input type="radio" name="department" value="Vaccination" class="mr-2" />
                  Vaccination
                </label>
                <label class="flex items-center">
                  <input type="radio" name="department" value="Laboratory" class="mr-2" />
                  Laboratory
                </label>
                <label class="flex items-center">
                  <input type="radio" name="department" value="Inventory" class="mr-2" />
                  Inventory
                </label>
                <label class="flex items-center">
                  <input type="radio" name="department" value="Blood Donation" class="mr-2" />
                  Blood Donation
                </label>
              </div>
            </div>
          </div>
          <button type="submit" class="bg-blue-500 text-white p-2 mt-6 rounded">Add Admin</button>
        </form>
        </main>
      </div>
</body>
</html>

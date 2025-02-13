<?php
session_start();
// Include the database connection
include('../connection.php');

// Fetch user information from the session
$username = $_SESSION['username'];  // Make sure the username is set in the session

// Fetch user details from the database
$user_query = "SELECT name, department FROM admin WHERE username = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("s", $username);
$stmt->execute();
$user_result = $stmt->get_result();

if ($user_result && $user_row = $user_result->fetch_assoc()) {
    $name = $user_row['name'];
    $department = $user_row['department'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/src/output.css">
  <link rel="stylesheet" href="/src/custom.css">
  <script src="/src/javascript/blood.js" defer></script>
</head>

<body>
  <div class="flex flex-col h-screen">
    <!-- Top navigation -->
    <div class="bg-white p-2">
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
          <span class="text-zinc-800 text-1xl"><?= $username ?></span> <!-- Username beside the icon -->
          <!-- User Icon with Dropdown -->
          <div class="relative">
            <button id="userDropdownToggle" class="ml-2">
              <img aria-hidden="true" alt="user-icon" src="/src/img/user.png" class="h-10 w-10" />
            </button>

            <!-- Dropdown Menu -->
            <div id="userDropdownMenu"
              class="absolute text-center right-0 mt-2 w-40 bg-white border border-zinc-200 rounded-lg shadow-lg hidden z-10">
              <a href="#" class="block px-4 py-2 text-sm text-zinc-700 hover:bg-blue-500 hover:text-white">Profile</a>
              <a href="/src/homepage.html" class="block px-4 py-2 text-sm text-zinc-700 hover:bg-red-500 hover:text-white">Logout</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="flex flex-1">
      <!-- Side navigation -->
      <nav class="w-60 bg-white pt-5 shadow-md">
        <ul class="space-y-5 text-1xl">
          <li class="bg-blue-600 rounded-r-full"><a href="consultation.html"
              class="text-white block py-2 pl-10">Dashboard</a></li>
          <li><a href="consultation_appointments.html" class="text-zinc-700 pl-10">Appointments</a></li>
          <li><a href="consultation_staff.html" class="text-zinc-700 pl-10">Staff Management</a></li>
          <li><a href="consultation_patient.html" class="text-zinc-700 pl-10">Patient Records</a></li>
          <li><a href="consultation_report.html" class="text-zinc-700 pl-10">Reports</a></li>
        </ul>
        <div class="p-4 text-center">
          <p class="text-sm pt-[220px] font-semibold">Logged in as:</p>
          <p class="text-lg font-bold"><?= $name ?></p> <!-- Display user name -->
          <p class="text-sm"><?= $department ?></p> <!-- Display user department -->
        </div>
      </nav>

      <main class="flex-1 bg-blue-200 p-6">
        <h1 class="text-2xl font-bold mb-6">Overview</h1>
        <div class="grid grid-cols-5 gap-4 mb-6">
          <div class="bg-zinc-100 p-4 rounded-lg flex items-center">
            <img src="/src/img/consult.png" alt="consultation" class="h-16 w-16">
            <div class="text-center flex-1">
              <span class="text-2xl font-bold">54</span>
              <p class="text-sm text-zinc-600">Total Consultation</p>
            </div>
          </div>
          <div class="bg-blue-100 p-4 rounded-lg flex items-center">
            <i class="fas fa-users text-blue-600 text-2xl mr-3"></i>
            <div class="text-center flex-1">
              <span class="text-2xl font-bold">84</span>
              <p class="text-zinc-600">Patients</p>
            </div>
          </div>
          <div class="bg-yellow-100 p-4 rounded-lg flex items-center">
            <i class="fas fa-clock border-black text-yellow-600 text-2xl mr-3"></i>
            <div class="text-center flex-1">
              <span class="text-2xl font-bold">16</span>
              <p class="text-zinc-600">Pending</p>
            </div>
          </div>
          <div class="bg-green-100 p-4 rounded-lg flex items-center">
            <i class="fas fa-check text-green-600 text-2xl mr-3"></i>
            <div class="text-center flex-1">
              <span class="text-2xl font-bold">28</span>
              <p class="text-zinc-600">Approved</p>
            </div>
          </div>
          <div class="bg-blue-300 p-4 rounded-lg flex items-center">
            <i class="fas fa-tasks text-blue-600 text-2xl mr-3"></i>
            <div class="text-center flex-1">
              <span class="text-2xl font-bold">20</span>
              <p class="text-zinc-600">Completed</p>
            </div>
          </div>
        </div>

        <h2 class="mt-8 text-xl font-semibold flex justify-between items-center">
          <span>Consultaion Appointments</span>

          <!-- Search Input for Live Filtering -->
          <input type="text" id="searchInput" placeholder="Search..."
            class="border border-zinc-400 rounded-lg p-2 focus:outline-none focus:ring-blue-500" />
        </h2>
        <table class="min-w-full mt-4 border-collapse border bg-zinc-200 border-zinc-300">
          <thead>
            <tr>
              <th class="bg-blue-300 border border-black px-4 py-2">Appointment Number</th>
              <th class="bg-blue-300 border border-black px-4 py-2">Patient Name</th>
              <th class="bg-blue-300 border border-black px-4 py-2">Doctor</th>
              <th class="bg-blue-300 border border-black px-4 py-2">Appointment Date</th>
              <th class="bg-blue-300 border border-black px-4 py-2">Time Slot</th>
              <th class="bg-blue-300 border border-black px-4 py-2">Contact Number</th>
              <th class="bg-blue-300 border border-black px-4 py-2">Status</th>
            </tr>
          </thead>
          <tbody id="appointmentTable">
            <tr>
              <td class="py-2 px-4 border border-black">1</td>
              <td class="py-2 px-4 border border-black">Jimuel Hipana</td>
              <td class="py-2 px-4 border border-black">Dr. Petronilo Faller</td>
              <td class="py-2 px-4 border border-black">05/29/24</td>
              <td class="py-2 px-4 border border-black">9:00am</td>
              <td class="py-2 px-4 border border-black">09123456789</td>
              <td class="py-2 px-4 border border-black">
                <span class="text-yellow-500">●Pending</span>
              </td>
            </tr>
            <tr>
              <td class="py-2 px-4 border border-black">1</td>
              <td class="py-2 px-4 border border-black">Jims Hipana</td>
              <td class="py-2 px-4 border border-black">Dr. Petronilo Faller</td>
              <td class="py-2 px-4 border border-black">05/29/24</td>
              <td class="py-2 px-4 border border-black">9:00am</td>
              <td class="py-2 px-4 border border-black">09123456789</td>
              <td class="py-2 px-4 border border-black">
                <span class="text-yellow-500">●Pending</span>
              </td>
            </tr>
            <tr>
              <td class="py-2 px-4 border border-black">1</td>
              <td class="py-2 px-4 border border-black">Jimuel Hipana</td>
              <td class="py-2 px-4 border border-black">Dr. Petronilo Faller</td>
              <td class="py-2 px-4 border border-black">05/29/24</td>
              <td class="py-2 px-4 border border-black">9:00am</td>
              <td class="py-2 px-4 border border-black">09123456789</td>
              <td class="py-2 px-4 border border-black">
                <span class="text-yellow-500">●Pending</span>
              </td>
            </tr>
          </tbody>
        </table>
      </main>
    </div>
</body>

</html>
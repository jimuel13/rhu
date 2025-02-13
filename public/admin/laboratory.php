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

// Fetch statistics
$patient_count = 0;
$pending_count = 0;
$approved_count = 0;
$completed_count = 0;
$test_list_count = 0;

// Query to count patients
$result = $conn->query("SELECT COUNT(*) AS patient_count FROM laboratorypatient");
if ($result && $row = $result->fetch_assoc()) {
    $patient_count = $row['patient_count'];
}

// Query to count appointments by status
$result = $conn->query("SELECT COUNT(*) AS pending_count FROM laboratoryappointments WHERE status = 'Pending'");
if ($result && $row = $result->fetch_assoc()) {
    $pending_count = $row['pending_count'];
}

$result = $conn->query("SELECT COUNT(*) AS approved_count FROM laboratoryappointments WHERE status = 'Approved'");
if ($result && $row = $result->fetch_assoc()) {
    $approved_count = $row['approved_count'];
}

$result = $conn->query("SELECT COUNT(*) AS completed_count FROM laboratoryappointments WHERE status = 'Completed'");
if ($result && $row = $result->fetch_assoc()) {
    $completed_count = $row['completed_count'];
}

// Query to count tests
$result = $conn->query("SELECT COUNT(*) AS test_count FROM laboratorytests");
if ($result && $row = $result->fetch_assoc()) {
    $test_list_count = $row['test_count'];
}

// Example: Fetching appointments (for displaying in the table)
$appointments = [];
$appointment_query = "SELECT * FROM laboratoryappointments LIMIT 10";  // Adjust the query to your requirements
$appointment_result = $conn->query($appointment_query);

if ($appointment_result) {
    while ($row = $appointment_result->fetch_assoc()) {
        $appointments[] = [
            'appointment_no' => $row['appointment_no'],
            'patient_name' => $row['patient_name'],
            'test_requested' => $row['test_requested'],
            'appointment_date' => $row['appointment_date'],
            'time_slot' => $row['time_slot'],
            'contact_number' => $row['contact_number'],
            'status' => $row['status']
        ];
    }
}

// Example: Fetching patient records
$patients = [];
$patient_query = "SELECT * FROM laboratorypatient LIMIT 10";  // Adjust the query to your requirements
$patient_result = $conn->query($patient_query);

if ($patient_result) {
    while ($row = $patient_result->fetch_assoc()) {
        $patients[] = [
            'patient_no' => $row['patient_no'],
            'date' => $row['date'],
            'patient_name' => $row['patient_name'],
            'test_requested' => $row['test_requested'],
            'test_result' => $row['test_result']
        ];
    }
}

// Example: Fetching test list
$tests = [];
$test_query = "SELECT * FROM laboratorytests LIMIT 10";  // Adjust the query to your requirements
$test_result = $conn->query($test_query);

if ($test_result) {
    while ($row = $test_result->fetch_assoc()) {
        $tests[] = [
            'test_id' => $row['test_id'],
            'test_name' => $row['test_name'],
            'price' => $row['price'],
            'status' => $row['status']
        ];
    }
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
    <div class="bg-white p-2 sticky top-0 z-50 shadow-md">
        <div class="flex items-center">
            <img src="../img/ehealth.png" alt="ehealth" class="h-12 w-25 sm:h-12 ml-8">
            <div class="ml-auto flex items-center space-x-4">
                <!-- Notification Bell with Dropdown -->
                <div class="relative">
                    <button id="notifDropdownToggle" class="ml-2">
                        <img aria-hidden="true" alt="notification-bell" src="../img/notif.png" class="h-6 w-6" />
                    </button>
                    <div id="notifDropdownMenu" class="absolute right-0 mt-2 w-80 bg-white border border-zinc-200 rounded-lg shadow-lg hidden z-10">
                        <div class="p-4">
                            <p class="text-sm font-semibold">Notifications</p>
                        </div>
                        <div class="border-t border-zinc-200">
                            <?php foreach ($notifications as $notification): ?>
                                <a href="#" class="block px-4 py-2 text-sm text-zinc-700 hover:bg-zinc-200">
                                    🔴 <?= $notification['message'] ?>
                                </a>
                            <?php endforeach; ?>
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
                        <img aria-hidden="true" alt="user-icon" src="../img/user.png" class="h-10 w-10" />
                    </button>
                    <div id="userDropdownMenu" class="absolute text-center right-0 mt-2 w-40 bg-white border border-zinc-200 rounded-lg shadow-lg hidden z-10">
                        <a href="/src/admin/laboratory_profile.html" class="block px-4 py-2 text-sm text-zinc-700 hover:bg-blue-500 hover:text-white">Profile</a>
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
                <li class="bg-blue-600 rounded-r-full"><a href="laboratory.html" class="text-white block py-2 pl-10">Dashboard</a></li>
                <li><a href="laboratory_appointments.php" class="text-zinc-700 pl-10">Appointments</a></li>
                <li><a href="laboratory_staff.html" class="text-zinc-700 pl-10">Staff Management</a></li>
                <li><a href="laboratory_test.html" class="text-zinc-700 pl-10">Test List</a></li>
                <li><a href="laboratory_patient.html" class="text-zinc-700 pl-10">Patient Records</a></li>
                <li><a href="laboratory_report.html" class="text-zinc-700 pl-10">Reports</a></li>
            </ul>
            <div class="p-4 text-center">
                <p class="text-sm pt-[170px] font-semibold">Logged in as:</p>
                <p class="text-lg font-bold"><?= $name ?></p> <!-- Display user name -->
                <p class="text-sm"><?= $department ?></p> <!-- Display user department -->
            </div>
        </nav>

        <!-- Main content -->
        <main class="flex-1 bg-blue-200 p-6">
            <h2 class="text-xl font-semibold mb-4">Overview</h2>
            <div class="grid grid-cols-5 gap-4 mb-6">
                <div class="bg-blue-100 p-4 rounded-lg flex items-center">
                    <i class="fas fa-users text-blue-600 text-2xl mr-3"></i>
                    <div class="text-center flex-1">
                        <span class="text-2xl font-bold"><?= $patient_count ?></span>
                        <p class="text-zinc-600">Patients</p>
                    </div>
                </div>

                <div class="bg-yellow-100 p-4 rounded-lg flex items-center">
                    <i class="fas fa-clock text-yellow-600 text-2xl mr-3"></i>
                    <div class="text-center flex-1">
                        <span class="text-2xl font-bold"><?= $pending_count ?></span>
                        <p class="text-zinc-600">Pending</p>
                    </div>
                </div>

                <div class="bg-green-100 p-4 rounded-lg flex items-center">
                    <i class="fas fa-check text-green-600 text-2xl mr-3"></i>
                    <div class="text-center flex-1">
                        <span class="text-2xl font-bold"><?= $approved_count ?></span>
                        <p class="text-zinc-600">Approved</p>
                    </div>
                </div>

                <div class="bg-blue-300 p-4 rounded-lg flex items-center">
                    <i class="fas fa-tasks text-blue-600 text-2xl mr-3"></i>
                    <div class="text-center flex-1">
                        <span class="text-2xl font-bold"><?= $completed_count ?></span>
                        <p class="text-zinc-600">Completed</p>
                    </div>
                </div>

                <div class="bg-zinc-100 p-4 rounded-lg flex items-center">
                    <i class="fas fa-flask text-zinc-600 text-2xl mr-3"></i>
                    <div class="text-center flex-1">
                        <span class="text-2xl font-bold"><?= $test_list_count ?></span>
                        <p class="text-zinc-600">Test List</p>
                    </div>
                </div>
            </div>

            <h2 class="mt-8 text-xl font-semibold flex justify-between items-center">
                <span>Laboratory Appointments</span>
                <input type="text" id="searchInput" placeholder="Search..." class="border border-zinc-400 rounded-lg p-2 font-normal focus:outline-none focus:ring-blue-500" />
            </h2>
            <table class="min-w-full bg-zinc-200 border border-zinc-300 mt-3">
                <thead>
                    <tr class="bg-zinc-200">
                        <th class="bg-blue-300 border border-black px-4 py-2">Appointment No.</th>
                        <th class="bg-blue-300 border border-black px-4 py-2">Patient Name</th>
                        <th class="bg-blue-300 border border-black px-4 py-2">Test</th>
                        <th class="bg-blue-300 border border-black px-4 py-2">Appointment Date</th>
                        <th class="bg-blue-300 border border-black px-4 py-2">Time Slot</th>
                        <th class="bg-blue-300 border border-black px-4 py-2">Contact Number</th>
                        <th class="bg-blue-300 border border-black px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td class="border border-black px-4 py-2"><?= $appointment['appointment_no'] ?></td>
                            <td class="border border-black px-4 py-2"><?= $appointment['patient_name'] ?></td>
                            <td class="border border-black px-4 py-2"><?= $appointment['test_requested'] ?></td>
                            <td class="border border-black px-4 py-2"><?= $appointment['appointment_date'] ?></td>
                            <td class="border border-black px-4 py-2"><?= $appointment['time_slot'] ?></td>
                            <td class="border border-black px-4 py-2"><?= $appointment['contact_number'] ?></td>
                            <td class="border border-black px-4 py-2"><?= $appointment['status'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</div>
</body>
</html>

<?php
// Include the database connection from connection.php
include('../connection.php'); // Make sure this path is correct

// Fetch appointments data
$sql = "SELECT * FROM laboratoryappointments";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments</title>
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
                        <!-- Notification Dropdown -->
                        <div id="notifDropdownMenu"
                            class="absolute right-0 mt-2 w-80 bg-white border border-zinc-200 rounded-lg shadow-lg hidden z-10">
                            <div class="p-4">
                                <p class="text-sm font-semibold">Notifications</p>
                            </div>
                            <div class="border-t border-zinc-200">
                                <a href="#" class="block px-4 py-2 text-sm text-zinc-700 hover:bg-zinc-200">🔴 You have a
                                    new appointment request.</a>
                                <a href="#" class="block px-4 py-2 text-sm text-zinc-700 hover:bg-zinc-200">🔴 Blood bag stock
                                    updated.</a>
                            </div>
                            <div class="text-center py-2 border-t border-zinc-200">
                                <a href="#" class="text-blue-500 text-sm">View all notifications</a>
                            </div>
                        </div>
                    </div>
                    <span class="text-zinc-800 text-1xl">Admin_Laboratory</span>
                    <!-- User Icon with Dropdown -->
                    <div class="relative">
                        <button id="userDropdownToggle" class="ml-2">
                            <img aria-hidden="true" alt="user-icon" src="../img/user.png" class="h-10 w-10" />
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="userDropdownMenu"
                            class="absolute text-center right-0 mt-2 w-40 bg-white border border-zinc-200 rounded-lg shadow-lg hidden z-10">
                            <a href="/src/admin/laboratory_profile.html"
                                class="block px-4 py-2 text-sm text-zinc-700 hover:bg-blue-500 hover:text-white">Profile</a>
                            <a href="/src/homepage.html"
                                class="block px-4 py-2 text-sm text-zinc-700 hover:bg-red-500 hover:text-white">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-1">
            <!-- Side navigation -->
            <nav class="w-60 bg-white pt-5 shadow-md fixed h-full">
                <ul class="space-y-5 text-1xl">
                    <li><a href="laboratory.html" class="text-zinc-700 pl-10">Dashboard</a></li>
                    <li class="bg-blue-600 rounded-r-full"><a href="laboratory_appointments.php" class="text-white block py-2 pl-10"
                            id="appointments-heading">Appointments</a></li>
                    <li><a href="laboratory_staff.html" class="text-zinc-700 pl-10">Staff Management</a></li>
                    <li><a href="laboratory_test.html" class="text-zinc-700 pl-10">Test List</a></li>
                    <li><a href="laboratory_patient.html" class="text-zinc-700 pl-10">Patient Records</a></li>
                    <li><a href="laboratory_report.html" class="text-zinc-700 pl-10">Reports</a></li>
                </ul>
                <div class="p-4 text-center">
                    <p class="text-sm pt-[170px] font-semibold">Logged in as:</p>
                    <p class="text-lg font-bold">Jimuel V. Hipana</p>
                    <p class="text-sm">Laboratory Admin</p>
                </div>
            </nav>

            <main class="flex-1 bg-blue-200 ml-60 p-6">
                <h2 class="text-2xl font-bold mb-4">Appointments</h2>
                <div class="flex items-center mb-4">
                    <label for="sort" class="mr-2">Sort by:</label>
                    <select id="sort" class="border border-zinc-300 rounded p-2 w-[180px]">
                        <option value="date">Appointment Date</option>
                        <option value="name">Appointment Number</option>
                    </select>
                    <!-- Search Input for Live Filtering -->
                    <input type="text" id="searchInput" placeholder="Search..." class="border border-zinc-400 rounded-lg p-2 focus:outline-none ml-auto focus:ring-blue-500" />
                </div>

                <!-- Appointments Table -->
                <table class="min-w-full bg-white border border-black">
                    <thead>
                        <tr>
                            <th class="bg-blue-300 border border-black px-4 py-2">Appointment No.</th>
                            <th class="bg-blue-300 border border-black px-4 py-2">Patient Name</th>
                            <th class="bg-blue-300 border border-black px-4 py-2">Test</th>
                            <th class="bg-blue-300 border border-black px-4 py-2">Appointment Date</th>
                            <th class="bg-blue-300 border border-black px-4 py-2">Time Slot</th>
                            <th class="bg-blue-300 border border-black px-4 py-2">Contact Number</th>
                            <th class="bg-blue-300 border border-black px-4 py-2">Status</th>
                            <th class="bg-blue-300 border border-black px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="appointmentTable">
                        <?php
                        // Check if there are rows in the result
                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while($row = $result->fetch_assoc()) {
                                // Determine color and action button based on the status
                                $statusColor = '';
                                $statusText = '';
                                $actionButtons = '';
                                switch($row["status"]) {
                                    case 'Pending':
                                        $statusColor = 'text-yellow-500';
                                        $statusText = '● Pending';
                                        $actionButtons = "<button class='bg-green-500 text-white rounded p-1 text-sm'>Approve</button>
                                                          <button class='bg-red-500 text-white rounded p-1 text-sm'>Reject</button>";
                                        break;
                                    case 'Approved':
                                        $statusColor = 'text-green-500';
                                        $statusText = '● Approved';
                                        $actionButtons = "<button class='bg-blue-500 text-white rounded p-1 text-sm'>Completed</button>";
                                        break;
                                    case 'Completed':
                                        $statusColor = 'text-blue-500';
                                        $statusText = '● Completed';
                                        $actionButtons = "<button class='bg-blue-500 text-white rounded p-1 text-sm'>View Record</button>";
                                        break;
                                    case 'Rejected':
                                        $statusColor = 'text-red-500';
                                        $statusText = '● Rejected';
                                        $actionButtons = '';
                                        break;
                                }
                                // Output the row with dynamic status and actions
                                echo "<tr>";
                                echo "<td class='py-2 px-4 border border-black'>" . $row["appointment_no"] . "</td>";
                                echo "<td class='py-2 px-4 border border-black'>" . $row["patient_name"] . "</td>";
                                echo "<td class='py-2 px-4 border border-black'>" . $row["test_requested"] . "</td>";
                                echo "<td class='py-2 px-4 border border-black'>" . date("m/d/y", strtotime($row["appointment_date"])) . "</td>";
                                echo "<td class='py-2 px-4 border border-black'>" . $row["time_slot"] . "</td>";
                                echo "<td class='py-2 px-4 border border-black'>" . $row["contact_number"] . "</td>";
                                echo "<td class='py-2 px-4 border border-black'><span class='$statusColor'>$statusText</span></td>";
                                echo "<td class='py-2 px-3 border border-black'>
                                    <div class='inline-flex space-x-2'>
                                        $actionButtons
                                    </div>
                                </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center py-2'>No appointments found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>

    <!-- JavaScript to handle live search -->
    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#appointmentTable tr');

            rows.forEach(row => {
                const columns = row.querySelectorAll('td');
                let rowText = '';
                columns.forEach(col => {
                    rowText += col.textContent.toLowerCase();
                });

                if (rowText.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>

<?php
// Close the connection if you haven't already closed it in connection.php
$conn->close();
?>

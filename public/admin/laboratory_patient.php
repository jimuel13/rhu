<?php
// Connect to the database
include('../connection.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'];
    $age = $_POST['age'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $date_collected = $_POST['date'];
    $test_requested = $_POST['test_requested'];
    $test_result = $_FILES['test_result']['name']; // File name

// Define the uploads directory path
$uploadDir = __DIR__ . '/../uploads/'; // Use an absolute path

// Check if the uploads directory exists, if not create it
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true); // Make directory if not exists, with read-write permissions
}

$uploadFile = $uploadDir . basename($_FILES['test_result']['name']);

// Check if the file is uploaded successfully
if (move_uploaded_file($_FILES['test_result']['tmp_name'], $uploadFile)) {
    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO laboratorypatient (patient_name, age, date_of_birth, address, gender, contact_number, date, test_requested, test_result) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssssss", $name, $age, $dob, $address, $gender, $contact, $date_collected, $test_requested, $test_result);

    if ($stmt->execute()) {
        echo "<script>alert('Record added successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('File upload failed. Please try again.');</script>";
}
}


// Fetch patient records
$patientRecords = [];
$sql = "SELECT * FROM laboratorypatient"; // Adjust table name if needed
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $patientRecords[] = $row;
    }
}

// Close the connection after data fetch
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Records</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/src/output.css">
    <link rel="stylesheet" href="/src/custom.css">
    <script src="/src/script.js"></script>
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
                        <div id="notifDropdownMenu" class="absolute right-0 mt-2 w-80 bg-white border border-zinc-200 rounded-lg shadow-lg hidden z-10">
                            <div class="p-4">
                                <p class="text-sm font-semibold">Notifications</p>
                            </div>
                            <div class="border-t border-zinc-200">
                                <a href="#" class="block px-4 py-2 text-sm text-zinc-700 hover:bg-zinc-200">🔴 You have a new appointment request.</a>
                                <a href="#" class="block px-4 py-2 text-sm text-zinc-700 hover:bg-zinc-200">🔴 Blood bag stock updated.</a>
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
                            <img aria-hidden="true" alt="user-icon" src="/src/img/user.png" class="h-10 w-10" />
                        </button>
                        <!-- Dropdown Menu -->
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
                    <li><a href="laboratory.html" class="text-zinc-700 pl-10">Dashboard</a></li>
                    <li><a href="laboratory_appointments.html" class="text-zinc-700 pl-10" id="appointments-heading">Appointments</a></li>
                    <li><a href="laboratory_staff.html" class="text-zinc-700 pl-10">Staff Management</a></li>
                    <li><a href="laboratory_test.html" class="text-zinc-700 pl-10">Test List</a></li>
                    <li class="bg-blue-600 rounded-r-full"><a href="laboratory_patient.html" class="text-white block py-2 pl-10">Patient Records</a></li>
                    <li><a href="laboratory_report.html" class="text-zinc-700 pl-10">Reports</a></li>
                </ul>
                <div class="p-4 text-center">
                    <p class="text-sm pt-[170px] font-semibold">Logged in as:</p>
                    <p class="text-lg font-bold">Jimuel V. Hipana</p>
                    <p class="text-sm">Laboratory Admin</p>
                </div>
            </nav>
            <main class="flex-1 bg-blue-200 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold">Patient Records</h1>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded">+ Add New Record</button>
                </div>
                <!-- Sort and Search bar -->
                <div class="flex justify-between mb-4">
                    <!-- Sort Dropdown -->
                    <div class="flex items-center">
                        <label for="sort" class="mr-2">Sort by:</label>
                        <select id="sort" class="border border-zinc-300 rounded p-2 w-[205px]">
                            <option>Equipment Name (A-Z)</option>
                            <option>Equipment Room A</option>
                            <option>Equipment Room B</option>
                            <option>Equipment Room C</option>
                        </select>
                    </div>
                    <!-- Search bar aligned to the right -->
                    <div>
                        <input type="text" id="searchInput" placeholder="Search..." class="border border-zinc-400 rounded-lg p-2 focus:outline-none focus:ring-blue-500" />
                    </div>
                </div>
                <!-- Table -->
                <table class="min-w-full bg-zinc-200 border border-zinc-300">
                    <thead>
                        <tr>
                            <th class="bg-blue-300 border border-black px-4 py-2">Patient No.</th>
                            <th class="bg-blue-300 border border-black px-4 py-2">Date</th>
                            <th class="bg-blue-300 border border-black px-4 py-2">Patient Name</th>
                            <th class="bg-blue-300 border border-black px-4 py-2">Test Requested</th>
                            <th class="bg-blue-300 border border-black px-4 py-2">Test Result</th>
                            <th class="bg-blue-300 border border-black px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="appointmentTable">
                        <?php foreach ($patientRecords as $record): ?>
                        <tr>
                            <td class="border border-black p-2"><?= htmlspecialchars($record['patient_no']) ?></td>
                            <td class="border border-black p-2"><?= htmlspecialchars($record['date']) ?></td>
                            <td class="border border-black p-2"><?= htmlspecialchars($record['patient_name']) ?></td>
                            <td class="border border-black p-2"><?= htmlspecialchars($record['test_requested']) ?></td>
                            <td class="border border-black p-2"><?= htmlspecialchars($record['test_result']) ?></td>
                            <td class="border border-black p-2 text-center">
                                <button class="text-blue-500">✏️</button>
                                <button class="text-green-500">👁️</button>
                                <button class="text-red-500">🗑️</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
  <div class="bg-[#C0BCBC] rounded-lg p-6 w-full max-w-2xl relative">
      <button id="closeModal" class="absolute top-2 right-2 text-gray-800 hover:text-gray-900">
          <i class="fas fa-times"></i>
      </button>
      <h2 class="mb-4 text-center text-xl font-bold text-gray-800">Add New Record</h2>
      <form action="" method="POST" enctype="multipart/form-data">
          <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
              <div class="w-full">
                  <label for="name" class="block mb-2 text-sm font-medium text-gray-800">Name</label>
                  <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Full Name" required>
              </div>
              <div class="w-full">
                  <label for="age" class="block mb-2 text-sm font-medium text-gray-800">Age</label>
                  <input type="number" name="age" id="age" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Age" required>
              </div>
              <div class="w-full">
                  <label for="dob" class="block mb-2 text-sm font-medium text-gray-800">Date of Birth</label>
                  <input type="date" name="dob" id="dob" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
              </div>
              <div class="w-full">
                  <label for="address" class="block mb-2 text-sm font-medium text-gray-800">Address</label>
                  <input type="text" name="address" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Address" required>
              </div>
              <div class="w-full">
                  <label for="gender" class="block mb-2 text-sm font-medium text-gray-800">Gender</label>
                  <div class="flex items-center">
                      <input type="radio" id="male" name="gender" value="male" class="mr-2" required>
                      <label for="male" class="text-sm text-gray-800">Male</label>
                      <input type="radio" id="female" name="gender" value="female" class="ml-4 mr-2">
                      <label for="female" class="text-sm text-gray-800">Female</label>
                  </div>
              </div>
              <div class="w-full">
                  <label for="contact" class="block mb-2 text-sm font-medium text-gray-800">Contact Number</label>
                  <input type="tel" name="contact" id="contact" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Contact Number" required>
              </div>
              <div class="w-full">
                  <label for="date" class="block mb-2 text-sm font-medium text-gray-800">Date Collected</label>
                  <input type="date" name="date" id="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
              </div>
              <div class="w-full">
                  <label for="test_requested" class="block mb-2 text-sm font-medium text-gray-800">Test Requested</label>
                  <input type="text" name="test_requested" id="test_requested" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Test Name" required>
              </div>
              <div class="w-full">
                <label for="test_result" class="block mb-2 text-sm font-medium text-gray-800">Test Result</label>
                <input type="file" name="test_result" id="test_result" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
            </div>            
          </div>
          <div class="flex justify-between mt-4">
            <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-600 rounded-lg focus:ring-4 focus:ring-blue-200 hover:bg-blue-700">
                Add Record
            </button>
            <button type="reset" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-gray-800 bg-gray-200 rounded-lg hover:bg-gray-300">
              Reset
          </button>
        </div>
      </form>
  </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modal');
    const addButton = document.querySelector('button.bg-blue-600'); // Add New Record button
    const closeButton = document.getElementById('closeModal');

    // Show modal on button click
    addButton.addEventListener('click', (e) => {
        e.preventDefault(); // Prevent any default link behavior if button is inside a form or anchor
        modal.classList.remove('hidden');
    });

    // Close modal when close button is clicked
    closeButton.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    // Optional: Close modal when clicking outside of it
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });
});

    document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const appointmentTable = document.getElementById('appointmentTable');

            // Function to filter the table rows based on the search input
            searchInput.addEventListener('input', () => {
                const searchTerm = searchInput.value.toLowerCase();
                const rows = appointmentTable.getElementsByTagName('tr');
                
                for (let i = 0; i < rows.length; i++) {
                    const cells = rows[i].getElementsByTagName('td');
                    let found = false;

                    // Loop through each cell in the row to check if it matches the search term
                    for (let j = 0; j < cells.length; j++) {
                        const cell = cells[j];
                        if (cell) {
                            if (cell.textContent.toLowerCase().includes(searchTerm)) {
                                found = true;
                                break;
                            }
                        }
                    }

                    // Show or hide the row based on whether it matches the search term
                    rows[i].style.display = found ? '' : 'none';
                }
            });
        });
</script>

            </main>
        </div>
    </div>
</body>
</html>

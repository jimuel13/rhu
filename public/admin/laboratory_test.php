<?php
// Include database connection file (replace with your actual connection file)
require_once '../connection.php';

// Handle the form submission to add a new test
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form values
    $name = $_POST['name'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $description = $_POST['description'];

    // Insert new test into the database
    $sql = "INSERT INTO laboratorytests (test_name, price, status, description) 
            VALUES ('$name', '$price', '$status', '$description')";
    
    if ($conn->query($sql) === TRUE) {
        // Successfully inserted, redirect to refresh the page and show the new test
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch all tests from the laboratorytests table
$sql = "SELECT * FROM laboratorytests";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Lists</title>
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
          <span class="text-zinc-800 text-1xl">Admin_Laboratory</span>
          <div class="relative">
            <button id="userDropdownToggle" class="ml-2">
              <img aria-hidden="true" alt="user-icon" src="/src/img/user.png" class="h-10 w-10" />
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
            <nav class="w-60 bg-white pt-5 shadow-md">
              <ul class="space-y-5 text-1xl">
                  <li><a href="laboratory.html" class="text-zinc-700 pl-10">Dashboard</a></li>
                  <li><a href="laboratory_appointments.html" class="text-zinc-700 pl-10">Appointments</a></li>
                  <li><a href="laboratory_staff.html" class="text-zinc-700 pl-10">Staff Management</a></li>
                  <li><a href="laboratory_test.html" class="text-white block py-2 pl-10 bg-blue-600 rounded-r-full">Test List</a></li>
                  <li><a href="laboratory_patient.html" class="text-zinc-700 pl-10">Patient Records</a></li>
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
                  <h1 class="text-2xl font-bold">List of Tests</h1>
                  <button class="bg-blue-600 text-white px-4 py-2 rounded" id="openModalBtn">+ Add New Test</button>
                </div>
              
                <div class="flex justify-between mb-4">
                  <div class="flex items-center">
                    <label for="sort" class="mr-2">Sort by:</label>
                    <select id="sort" class="border border-zinc-300 rounded p-2 w-[205px]">
                      <option>Test Name (A-Z)</option>
                    </select>
                  </div>

                  <div>
                    <input type="text" id="searchInput" placeholder="Search..." class="border border-zinc-400 rounded-lg p-2 focus:outline-none focus:ring-blue-500" />
                  </div>
                </div>

                <!-- Table -->
                <table class="min-w-full bg-zinc-200 border border-zinc-300">
                  <thead>
                    <tr>
                        <th class="bg-blue-300 border border-black px-4 py-2">No.</th>
                        <th class="bg-blue-300 border border-black px-4 py-2">Test Name</th>
                        <th class="bg-blue-300 border border-black px-4 py-2">Price</th>
                        <th class="bg-blue-300 border border-black px-4 py-2">Status</th>
                        <th class="bg-blue-300 border border-black px-4 py-2">Actions</th>
                    </tr>
                  </thead>
                  <tbody id="appointmentTable">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="border border-black p-2"><?php echo $row['test_id']; ?></td>
                                <td class="border border-black p-2"><?php echo $row['test_name']; ?></td>
                                <td class="border border-black p-2">P <?php echo number_format($row['price'], 2); ?></td>
                                <td class="border border-black p-2"><?php echo $row['status']; ?></td>
                                <td class="border border-black p-2 text-center">
                                    <button class="text-blue-500">✏️</button>
                                    <button class="text-green-500">👁️</button>
                                    <button class="text-red-500">🗑️</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center p-2">No tests found</td>
                        </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </main>
      </div>

      <!-- Modal for Adding New Test -->
      <div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
          <div class="bg-[#C0BCBC] rounded-lg p-6 w-full max-w-2xl relative">
              <button id="closeModal" class="absolute top-2 right-2 text-gray-800 hover:text-gray-900">
                  <i class="fas fa-times"></i>
              </button>
              <h2 class="mb-4 text-center text-xl font-bold text-gray-800">Add New Test</h2>
              <form action="" method="POST">
                  <div class="space-y-4">
                      <div class="w-full">
                          <label for="name" class="block mb-2 text-sm font-medium text-gray-800">Name</label>
                          <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Test Name" required="">
                      </div>
                      <div class="w-full">
                          <label for="price" class="block mb-2 text-sm font-medium text-gray-800">Price</label>
                          <input type="number" name="price" id="price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Price" required="">
                      </div>
                      <div class="w-full">
                          <label for="status" class="block mb-2 text-sm font-medium text-gray-800">Status</label>
                          <select name="status" id="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                              <option value="Available">Available</option>
                              <option value="Unavailable">Unavailable</option>
                          </select>
                      </div>
                      <div class="w-full">
                          <label for="description" class="block mb-2 text-sm font-medium text-gray-800">Description</label>
                          <textarea name="description" id="description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Description" required=""></textarea>
                      </div>
                  </div>
                  <div class="mt-6 flex justify-end">
                      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Add Test</button>
                  </div>
              </form>
          </div>
      </div>

      <script>
        const openModalBtn = document.getElementById("openModalBtn");
        const modal = document.getElementById("modal");
        const closeModalBtn = document.getElementById("closeModal");

        openModalBtn.onclick = () => modal.classList.remove("hidden");
        closeModalBtn.onclick = () => modal.classList.add("hidden");
      </script>
</body>
</html>

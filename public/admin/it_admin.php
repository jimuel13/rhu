<?php
// Database connection
include('../connection.php');

// Handle form submission for updating an admin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $department = $_POST['department'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $status = $_POST['status'];

  // Update query
  $sql = "UPDATE admin 
          SET name = ?, department = ?, username = ?, email = ?, status = ? 
          WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssssi", $name, $department, $username, $email, $status, $id);

  if ($stmt->execute()) {
    echo "<script>alert('Admin updated successfully!');</script>";
} else {
    echo "<script>alert('Failed to update admin: " . $stmt->error . "');</script>";
}

  $stmt->close();
}

// Fetch data from the admin table
$sql = "SELECT id, name, department, username, email, created_at, status FROM admin";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
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
          <!-- Side navigation -->
          <nav class="w-60 bg-white pt-5 shadow-md">
            <ul class="space-y-5 text-1xl">
                <li><a href="it_personnel.html" class="text-zinc-700 block py-2 pl-10">Dashboard</a></li>
                <li><a href="it_verify.php" class="text-zinc-700 pl-10">Registration Verification</a></li>
                <li class="bg-blue-600 rounded-r-full"><a href="it_admin.php" class="text-white block py-2 pl-10">User Management</a></li>
                <li><a href="add_admin.php" class="text-zinc-700 pl-10">Add New Admin</a></li>
                <li><a href="it_audit.html" class="text-zinc-700 pl-10">Audit Logs</a></li>
            </ul>
            <div class="p-4 text-center">
              <p class="text-sm pt-[200px] font-semibold">Logged in as:</p>
              <p class="text-lg font-bold">Angela P. Madrid</p>
              <p class="text-sm">IT_Personnel</p>
            </div>
        </nav>
        
          <main class="flex-1 bg-blue-200 p-2">
            <h1 class="text-1xl font-bold mb-8">Admin List</h1>
            <div class="flex justify-between mb-4">
              <select class="border rounded p-2 w-[100px]">
                <option>Admins</option>
                <option>Doctors</option>
                <option>Patients</option>
              </select>
                    <!-- Search Input for Live Filtering -->
          <input type="text" id="searchInput" placeholder="Search..."
            class="border border-zinc-400 rounded-lg p-2 focus:outline-none focus:ring-blue-500" />
            </div>
          <table class="min-w-full bg-white border border-zinc-300">
            <thead>
              <tr class="bg-zinc-200">
                <th class="bg-blue-300 border border-black px-4 py-2">Name</th>
                <th class="bg-blue-300 border border-black px-4 py-2">Department</th>
                <th class="bg-blue-300 border border-black px-4 py-2">Username</th>
                <th class="bg-blue-300 border border-black px-4 py-2">Email</th>
                <th class="bg-blue-300 border border-black px-4 py-2">Date and Time</th>
                <th class="bg-blue-300 border border-black px-4 py-2">Status</th>
                <th class="bg-blue-300 border border-black px-4 py-2">Actions</th>
              </tr>
            </thead>
            <tbody id="appointmentTable">
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td class='border border-black p-2'>" . htmlspecialchars($row['name']) . "</td>";
                                echo "<td class='border border-black p-2'>" . htmlspecialchars($row['department']) . "</td>";
                                echo "<td class='border border-black p-2'>" . htmlspecialchars($row['username']) . "</td>";
                                echo "<td class='border border-black p-2'>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td class='border border-black p-2'>" . htmlspecialchars($row['created_at']) . "</td>";
                                echo "<td class='border border-black p-2'>" . htmlspecialchars($row['status']) . "</td>";
                                echo "<td class='border border-black p-2'>
                                        <button class='text-blue-600 edit-btn' data-id='{$row['id']}' data-name='{$row['name']}' data-department='{$row['department']}' data-username='{$row['username']}' data-email='{$row['email']}' data-status='{$row['status']}'>✏️</button>
                                        <button class='text-red-600'>🗑️</button>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center border border-black p-2'>No records found</td></tr>";
                        }
                        ?>
            </tbody>
          </table>
        </main>
      </div>

          <!-- Modal for Editing Data -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg w-96">
            <h2 class="text-xl font-bold mb-4">Edit Admin</h2>
            <form id="editForm" method="POST">
                <input type="hidden" name="id" id="editId">
                <div class="mb-4">
                    <label for="editName" class="block text-sm font-semibold">Name</label>
                    <input type="text" name="name" id="editName" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="editDepartment" class="block text-sm font-semibold">Department</label>
                    <input type="text" name="department" id="editDepartment" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="editUsername" class="block text-sm font-semibold">Username</label>
                    <input type="text" name="username" id="editUsername" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="editEmail" class="block text-sm font-semibold">Email</label>
                    <input type="email" name="email" id="editEmail" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="editStatus" class="block text-sm font-semibold">Status</label>
                    <select name="status" id="editStatus" class="w-full border p-2 rounded">
                        <option value="Available">Available</option>
                        <option value="Unavailable">Unavailable</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" id="closeModal" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Open modal and populate fields
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', () => {
                const modal = document.getElementById('editModal');
                document.getElementById('editId').value = button.dataset.id;
                document.getElementById('editName').value = button.dataset.name;
                document.getElementById('editDepartment').value = button.dataset.department;
                document.getElementById('editUsername').value = button.dataset.username;
                document.getElementById('editEmail').value = button.dataset.email;
                document.getElementById('editStatus').value = button.dataset.status;
                modal.classList.remove('hidden');
            });
        });

        // Close modal
        document.getElementById('closeModal').addEventListener('click', () => {
            document.getElementById('editModal').classList.add('hidden');
        });
    </script>

</body>
</html>
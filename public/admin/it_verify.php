<?php
// Include database connection
include('../connection.php');

// Handle the approval process
if (isset($_GET['id'])) {
  $user_id = $_GET['id'];

  // Update the user's status to "approved"
  $query = "UPDATE registration SET status = 'approved' WHERE id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, 'i', $user_id);
  $result = mysqli_stmt_execute($stmt);

  // Check if the update was successful
  if ($result) {
      // Redirect to the same page with a success message
      header("Location: it_verify.php?message=User registration approved");
      exit();
  } else {
      // Redirect with an error message if update fails
      header("Location: it_verify.php?message=Error approving user");
      exit();
  }
}

// Fetch registration data from the database
$query = "SELECT * FROM registration WHERE status = 'Pending'"; // Assuming 'registration' is your table
$result = mysqli_query($conn, $query);

// Check if any rows are returned
if (!$result) {
  die("Error retrieving records: " . mysqli_error($conn));
}

// Close the database connection
mysqli_close($conn);

// Get the message from the URL if it exists
$message = isset($_GET['message']) ? $_GET['message'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Verification</title>
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
          <li class="bg-blue-600 rounded-r-full"><a href="it_verify.php"
              class="text-white block py-2 pl-10">Registration Verification</a></li>
          <li><a href="it_admin.php" class="text-zinc-700 pl-10">User Management</a></li>
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
        <h1 class="text-1xl font-bold mb-8">Registration Verification</h1>

              <!-- Check if there's a message and show an alert -->
      <?php if ($message): ?>
        <script type="text/javascript">
          alert("<?php echo addslashes($message); ?>");
        </script>
      <?php endif; ?>

        <div class="flex justify-between mb-4">
          <select class="border rounded p-2 w-[260px]">
            <option>Sort by:</option>
            <option>Sort by: Appointment Number</option>
            <option>Sort by: Appointment Date</option>
          </select>
                    <!-- Search Input for Live Filtering -->
          <input type="text" id="searchInput" placeholder="Search..."
            class="border border-zinc-400 rounded-lg p-2 focus:outline-none focus:ring-blue-500" />
        </div>
        <table class="min-w-full bg-white border border-zinc-300">
          <thead>
            <tr class="bg-zinc-200">
              <th class="bg-blue-300 border border-black px-4 py-2">Name</th>
              <th class="bg-blue-300 border border-black px-4 py-2">Age</th>
              <th class="bg-blue-300 border border-black px-4 py-2">Address</th>
              <th class="bg-blue-300 border border-black px-4 py-2">Contact Number</th>
              <th class="bg-blue-300 border border-black px-4 py-2">Date and Time</th>
              <th class="bg-blue-300 border border-black px-4 py-2">Valid ID</th>
              <th class="bg-blue-300 border border-black px-4 py-2">Status</th>
              <th class="bg-blue-300 border border-black px-4 py-2">Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)) { 
                // Calculate age
                $dob = new DateTime($row['dob']);
                $today = new DateTime();
                $age = $today->diff($dob)->y;
            ?>
            
            <tr class="border-b">
              <td class="border border-black p-2"><?php echo $row['first_name'] . ' ' . $row['middle_initial'] . ' ' . $row['last_name'];  ?></td>
              <td class="border border-black p-2"><?php echo $age  ?></td>
              <td class="border border-black p-2"><?php echo $row['street'] . ' ' . $row['barangay'];  ?></td>
              <td class="border border-black p-2"><?php echo $row['mobile_number']; ?></td>
              <td class="border border-black p-2"><?php echo $row['created_at']; ?></td>
              <td class="border border-black p-2"><a href="/src/uploads_id/<?php echo $row['upload_id']; ?>"><?php echo $row['upload_id']; ?></a></td>
              <td class="border border-black p-2"><span class="text-yellow-500"><?php echo $row['status']; ?></span></td>
              <td class="border border-black p-2">
                <div class="flex space-x-1">
                  <a href="it_verify.php?id=<?php echo $row['id']; ?>" class="bg-green-500 text-white rounded p-1">Approve</a>
                  <a href="#" class="bg-blue-500 text-white rounded p-1 view-btn"
                  data-id="<?php echo $row['id']; ?>"
                  data-first-name="<?php echo $row['first_name']; ?>"
                  data-middle-initial="<?php echo $row['middle_initial']; ?>"
                  data-last-name="<?php echo $row['last_name']; ?>"
                  data-age="<?php echo $age; ?>"
                  data-gender="<?php echo $row['gender']; ?>"
                  data-address="<?php echo $row['street'] . ' ' . $row['barangay']; ?>"
                  data-contact-number="<?php echo $row['mobile_number']; ?>"
                  data-created-at="<?php echo $row['created_at']; ?>"
                  data-status="<?php echo $row['status']; ?>"
                  data-valid-id="<?php echo $row['upload_id']; ?>"
                >View</a>
                  <a href="reject.php?id=<?php echo $row['id']; ?>" class="bg-red-500 text-white rounded p-1">Reject</a>
                </div>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </main>
    </div>
<!-- Modal Structure -->
<div id="userModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
  <div class="bg-white p-6 rounded-lg w-3/4 sm:w-1/2 md:w-1/3">
    <h2 class="text-xl font-semibold mb-4 text-center">User Information</h2>
    <div>
      <p><strong>First Name:</strong> <span id="modalFirstName"></span></p>
      <p><strong>Middle Initial:</strong> <span id="modalMiddleInitial"></span></p>
      <p><strong>Last Name:</strong> <span id="modalLastName"></span></p>
      <p><strong>Age:</strong> <span id="modalAge"></span></p>
      <p><strong>Gender:</strong> <span id="modalGender"></span></p>
      <p><strong>Address:</strong> <span id="modalAddress"></span></p>
      <p><strong>Contact Number:</strong> <span id="modalContactNumber"></span></p>
      <p><strong>Date and Time:</strong> <span id="modalCreatedAt"></span></p>
      <p><strong>Status:</strong> <span id="modalStatus"></span></p>
      <p><strong>Valid ID:</strong> <a id="modalValidId" href="#" target="_blank">View ID</a></p>
    </div>
    <button id="closeModal" class="bg-red-500 text-white py-2 px-4 rounded mt-4">Close</button>
  </div>
</div>

    <script>
      // JavaScript for Modal
document.addEventListener("DOMContentLoaded", function() {
  // Get all 'View' buttons and add click event listeners
  const viewButtons = document.querySelectorAll(".view-btn");

  viewButtons.forEach(button => {
    button.addEventListener("click", function() {
      // Get the user data from the button's data attributes
      const userId = this.getAttribute("data-id");
      const firstName = this.getAttribute("data-first-name");
      const middleInitial = this.getAttribute("data-middle-initial");
      const lastName = this.getAttribute("data-last-name");
      const age = this.getAttribute("data-age");
      const gender = this.getAttribute("data-gender");
      const address = this.getAttribute("data-address");
      const contactNumber = this.getAttribute("data-contact-number");
      const createdAt = this.getAttribute("data-created-at");
      const status = this.getAttribute("data-status");
      const validId = this.getAttribute("data-valid-id");

      // Populate modal fields
      document.getElementById("modalFirstName").textContent = firstName;
      document.getElementById("modalMiddleInitial").textContent = middleInitial;
      document.getElementById("modalLastName").textContent = lastName;
      document.getElementById("modalAge").textContent = age;
      document.getElementById("modalGender").textContent = gender;
      document.getElementById("modalAddress").textContent = address;
      document.getElementById("modalContactNumber").textContent = contactNumber;
      document.getElementById("modalCreatedAt").textContent = createdAt;
      document.getElementById("modalStatus").textContent = status;
      document.getElementById("modalValidId").href = `/src/uploads_id/${validId}`;

      // Show the modal
      document.getElementById("userModal").classList.remove("hidden");
    });
  });

  // Close the modal
  document.getElementById("closeModal").addEventListener("click", function() {
    document.getElementById("userModal").classList.add("hidden");
  });
});

    </script>
</body>

</html>
<?php
session_start();
require_once '../../models/Database.php';
require_once '../../models/User.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: ../common/signin.php");
    exit;
}

$db = (new Database())->getConnection();
$userModel = new User($db);
$users = $userModel->getAllUsers();
?>
<!DOCTYPE html>
<html lang="cz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Users List</title>
</head>
<body class="bg-fixed min-h-screen m-0 bg-gradient-to-br from-black via-gray-700 to-purple-700">
<div class="max-w-7xl mx-auto px-4">
  <!-- Sticky Navbar -->
  <nav class="sticky top-0 z-50 bg-gray-900 bg-opacity-95 backdrop-blur-lg rounded-b-lg shadow-md text-white">
    <div class="flex items-center justify-between py-4 px-6">
      <a href="../common/gallery.php" class="flex items-center space-x-2">
        <img src="../../../public/assets/logo_nightrides.svg" class="w-11 h-11" alt="Car icon" />
      </a>
      <ul class="hidden md:flex space-x-6">
        <li><a href="../common/gallery.php" class="hover:text-purple-400 transition">Home</a></li>
        <li><a href="../SocPosts/socpost_create.php" class="hover:text-purple-400 transition">Add</a></li>
        <li><a href="../admin/socpost_update_delete.php" class="hover:text-purple-400 transition">My posts</a></li>
        <li><a href="../common/About.php" class="hover:text-purple-400 transition">About</a></li>
        <li><a href="users_list.php" class="hover:text-purple-400 transition font-bold">Users</a></li>
      </ul>
      <div class="hidden md:block">
        <?php if (isset($_SESSION['username'])): ?>
          <span class="font-semibold"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
          <a href="../../controllers/logout.php" class="block bg-purple-700 hover:bg-purple-800 text-white font-semibold px-4 py-2 rounded-md transition">Logout</a>
        <?php endif; ?>
      </div>
      <div class="md:hidden">
        <button id="menu-toggle" class="text-white text-2xl focus:outline-none">☰</button>
      </div>
    </div>
    <div id="mobile-menu" class="hidden flex-col space-y-2 pb-4 px-6 md:hidden">
      <a href="../common/gallery.php" class="block py-1 hover:text-purple-400">Home</a>
      <a href="../SocPosts/socpost_create.php" class="block py-1 hover:text-purple-400">Add</a>
      <a href="../admin/socpost_update_delete.php" class="block py-1 hover:text-purple-400">My posts</a>
      <a href="../common/About.php" class="block py-1 hover:text-purple-400">About</a>
      <a href="users_list.php" class="block py-1 hover:text-purple-400 font-bold">Users</a>
      <?php if (isset($_SESSION['username'])): ?>
        <div class="flex flex-col space-y-2">
          <span class="block py-2 font-semibold"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
          <a href="../../controllers/logout.php" class="block bg-purple-700 hover:bg-purple-800 text-white font-semibold px-4 py-2 rounded-md transition">Logout</a>
        </div>
      <?php endif; ?>
    </div>
  </nav>

  <div class="mt-12 space-y-8">
    <h1 class="text-3xl font-bold text-purple-400 mb-6">Users List</h1>
    <div class="overflow-x-auto">
      <table class="min-w-full bg-gray-900 rounded-lg shadow-lg">
        <thead>
          <tr class="text-purple-400 text-left">
            <th class="py-2 px-4">ID</th>
            <th class="py-2 px-4">Username</th>
            <th class="py-2 px-4">Email</th>
            <th class="py-2 px-4">Role</th>
            <th class="py-2 px-4">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
              <tr class="border-b border-gray-800 hover:bg-gray-800">
                <td class="py-2 px-4 text-gray-200"><?php echo htmlspecialchars($user['id']); ?></td>
                <td class="py-2 px-4 text-gray-200"><?php echo htmlspecialchars($user['username']); ?></td>
                <td class="py-2 px-4 text-gray-200"><?php echo htmlspecialchars($user['email']); ?></td>
                <td class="py-2 px-4 text-gray-200"><?php echo htmlspecialchars($user['role']); ?></td>
                <td class="py-2 px-4 flex gap-2">
                  <a href="user_edit.php?id=<?php echo htmlspecialchars($user['id']); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded ml-1">Edit</a>
                  <form action="../../controllers/UserDelete.php" method="GET" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">Delete</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="5" class="text-center text-gray-400 py-4">No users found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script>
  const menuToggle = document.getElementById('menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');
  if(menuToggle && mobileMenu) {
    menuToggle.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  }
</script>
</body>
</html>

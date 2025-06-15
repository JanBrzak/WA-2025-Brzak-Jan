<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: gallery.php');
    exit;
}

require_once '../../models/Database.php';
require_once '../../models/User.php';

$db = (new Database())->getConnection();

?>
<!DOCTYPE html>
<html lang="cz">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login</title>
</head>
<body class="bg-fixed min-h-screen m-0 bg-gradient-to-br from-black via-gray-700 to-purple-700">

   <div class="max-w-7xl mx-auto px-4">
  <!-- Sticky Navbar inside container -->
  <nav class="sticky top-0 z-50 bg-gray-900 bg-opacity-95 backdrop-blur-lg rounded-b-lg shadow-md text-white">
  <div class="flex items-center justify-between py-4 px-6">
    <a href="gallery.php" class="flex items-center space-x-2">
      <img src="../../../public/assets/logo_nightrides.svg" class="w-11 h-11" alt="Car icon" />
    </a>
    <ul class="hidden md:flex space-x-6">
      <li><a href="gallery.php" class="hover:text-purple-400 transition">Home</a></li>
      <li><a href="../SocPosts/socpost_create.php" class="hover:text-purple-400 transition">Add</a></li>
      <li><a href="../admin/socpost_update_delete.php" class="hover:text-purple-400 transition">My posts</a></li>
      <li><a href="About.php" class="hover:text-purple-400 transition">About</a></li>
      <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <li><a href="../admin/users_list.php" class="hover:text-purple-400 transition">Users</a></li>
      <?php endif; ?>
    </ul>
    <div class="hidden md:block">
      <?php if (isset($_SESSION['username'])): ?>
        <span class="font-semibold"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
        <a href="../../controllers/logout.php" class="block bg-purple-700 hover:bg-purple-800 text-white font-semibold px-4 py-2 rounded-md transition">Logout</a>
      <?php else: ?>
        <a href="signin.php" class="bg-purple-700 hover:bg-purple-800 text-white font-semibold px-4 py-2 rounded-md transition">Login</a>
      <?php endif; ?>
    </div>
    <div class="md:hidden">
      <button id="menu-toggle" class="text-white text-2xl focus:outline-none">☰</button>
    </div>
  </div>
  <div id="mobile-menu" class="hidden flex-col space-y-2 pb-4 px-6 md:hidden">
    <a href="gallery.php" class="block py-1 hover:text-purple-400">Home</a>
    <a href="../SocPosts/socpost_create.php" class="block py-1 hover:text-purple-400">Add</a>
    <a href="../admin/socpost_update_delete.php" class="block py-1 hover:text-purple-400">My posts</a>
    <a href="About.php" class="block py-1 hover:text-purple-400">About</a>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
      <a href="../admin/users_list.php" class="block py-1 hover:text-purple-400">Users</a>
    <?php endif; ?>
    <?php if (isset($_SESSION['username'])): ?>
      <div class="flex flex-col space-y-2">
        <span class="block py-2 font-semibold"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
        <a href="../../controllers/logout.php" class="block bg-purple-700 hover:bg-purple-800 text-white font-semibold px-4 py-2 rounded-md transition">Logout</a>
      </div>
    <?php else: ?>
      <a href="signin.php" class="block bg-purple-700 hover:bg-purple-800 text-white font-semibold px-4 py-2 rounded-md transition">Login</a>
    <?php endif; ?>
  </div>
</nav>
  <!-- Login Form Card inserted here -->
  <div class="mt-16 flex justify-center">
    <div class="w-full max-w-md p-6 bg-gray-900 rounded-2xl shadow-lg">
      <div class="text-center mb-6">
        <h2 class="text-3xl font-bold text-purple-500">User Log-in</h2>
      </div>

      <form action="../../controllers/login.php" method="post" class="space-y-5">
        <div>
          <label for="username" class="text-white block text-sm font-semibold mb-1">Username:</label>
          <input type="text" id="username" name="username" required
                 class="form-control w-full px-4 py-2 rounded bg-gray-800 border border-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-600">
        </div>

        <div>
          <label for="password" class="text-white block text-sm font-semibold mb-1">Password:</label>
          <input type="password" id="password" name="password" required
                 class="form-control w-full px-4 py-2 rounded bg-gray-800 border border-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-600 ">
        </div>

        <button type="submit"
                class="w-full py-2 bg-purple-700 hover:bg-purple-800 text-white font-semibold rounded transition">Log-in</button>
      </form>
      <div class="text-center mb-6">
        <a href="signup.php"class="text-white font-bold py-1   hover:text-purple-400">Sign-up</a>
      </div>
    </div>
    
  </div>



  
  
</div>

<script>
  const menuToggle = document.getElementById('menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');

  menuToggle.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
  });
</script>



</body>
</html>
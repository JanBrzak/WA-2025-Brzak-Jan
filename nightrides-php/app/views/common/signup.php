<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: gallery.php');
    exit;
}

require_once '../../models/Database.php';
require_once '../../models/User.php';

$db = (new Database())->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];

    // BEZPEČNÁ VERZE – připravený dotaz s pojmenovaným placeholderem
    $sql = "INSERT INTO users_demo (username) VALUES (:username)";

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute(['username' => $username]);
        echo "<div style='color:green;'>Uživatelské jméno uloženo (BEZPEČNĚ – pojmenovaný placeholder)</div>";
    } catch (PDOException $e) {
        echo "<div style='color:red;'>Výjimka: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="cz">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Sign up</title>
</head>
<body class="bg-fixed min-h-screen m-0 bg-gradient-to-br from-black via-gray-700 to-purple-700">

   <div class="max-w-7xl mx-auto px-4">
  <!--  Navbar  -->
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
    <div class="mt-16 flex justify-center">
        <div class="w-full max-w-md p-6 bg-gray-900 rounded-2xl shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center text-purple-500">Registrace uživatele</h2>
     <!-- Formulář karta -->
    <form action="../../controllers/register.php" method="POST" class="space-y-4">
      <div>
        <label for="username" class="block text-sm font-medium text-white">Username *</label>
        <input type="text" name="username" id="username" required class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300" />
      </div>

      <div>
        <label for="email" class="block text-sm font-medium text-white">Email</label>
        <input type="email" name="email" id="email" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300" />
      </div>

      <div>
        <label for="name" class="block text-sm font-medium text-white">Name</label>
        <input type="text" name="name" id="name" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300" />
      </div>

      <div>
        <label for="surname" class="block text-sm font-medium text-white">Surname</label>
        <input type="text" name="surname" id="surname" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300" />
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-white">Password *</label>
        <input type="password" name="password" id="password" required class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300" />
      </div>

      <div>
        <label for="password_confirm" class="block text-sm font-medium text-white">Confirm Password *</label>
        <input type="password" name="password_confirm" id="password_confirm" required class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300" />
      </div>

      <div class="flex items-center mb-2">
        <input type="checkbox" id="accept_rules" name="accept_rules" required class="mr-2">
        <label for="accept_rules" class="text-sm text-white select-none">I have read and accept the <a href="rules.php" target="_blank" class="text-purple-400 underline hover:text-purple-300">Site Rules & Community Guidelines</a> *</label>
      </div>
      <button type="submit" class="w-full bg-purple-700 text-white py-2 rounded-lg hover:bg-purple-800 transition">Sign-Up</button>
    </form>
    <p class="text-center text-sm text-gray-600 mt-4">
      Already have and account? <a href="signup.php"class="text-white font-bold py-1   hover:text-purple-400">Log in</a>
    </p>
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
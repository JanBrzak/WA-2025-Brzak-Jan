<?php
session_start();
require_once '../../models/Database.php';
require_once '../../models/SocPost.php';
require_once '../../models/User.php';

if (!isset($_GET['user_id']) || !is_numeric($_GET['user_id'])) {
    die('Invalid user ID.');
}

$db = (new Database())->getConnection();
$userModel = new User($db);
$socpostModel = new SocPost($db);

$user = $userModel->getUserById((int)$_GET['user_id']);
if (!$user) {
    die('User not found.');
}

$socposts = $socpostModel->getByUserId($user['id']);
$isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
?>
<!DOCTYPE html>
<html lang="cz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title><?php echo htmlspecialchars($user['username']); ?>'s Posts | CarMeet Central</title>
</head>
<body class="bg-fixed min-h-screen m-0 bg-gradient-to-br from-black via-gray-700 to-purple-700">
<div class="max-w-7xl mx-auto px-4">
  <!-- Navbar (reuse unified navbar) -->
  <nav class="sticky top-0 z-50 bg-gray-900 bg-opacity-95 backdrop-blur-lg rounded-b-lg shadow-md text-white mb-8">
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
  <div class="mt-12 space-y-8">
    <h1 class="text-3xl font-bold text-purple-400 mb-6">Posts by <?php echo htmlspecialchars($user['username']); ?></h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php if (!empty($socposts)): ?>
        <?php foreach ($socposts as $post): ?>
          <div class="bg-gray-900 bg-opacity-90 rounded-lg shadow-lg p-6 flex flex-col">
            <?php
              $imagePaths = array_filter(explode(',', $post['images'] ?? ''));
              foreach ($imagePaths as $img):
                $img = trim($img, "\" \t\n\r\0\x0B[]");
                if ($img):
            ?>
              <img src="/WA-2025-Brzak-Jan/nightrides-php/<?php echo htmlspecialchars($img); ?>" alt="Post Image" class="w-full h-48 object-cover rounded mb-4">
            <?php endif; endforeach; ?>
            <h3 class="text-xl font-bold mb-2 text-purple-400"><?php echo htmlspecialchars($post['title']); ?></h3>
            <div class="text-purple-300 mb-1">By: <span class="font-medium"><?php echo htmlspecialchars($post['author']); ?></span></div>
            <span class="text-xs text-gray-400 mb-2">Created: <?php echo htmlspecialchars($post['created_at']); ?></span>
            <a href="../SocPosts/socpost_detail.php?id=<?php echo htmlspecialchars($post['id']); ?>" class="text-purple-400 hover:underline mt-auto">View Details</a>
            <?php if ($isAdmin): ?>
              <div class="flex gap-2 mt-2">
                <a href="../admin/socpost_edit.php?id=<?php echo htmlspecialchars($post['id']); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded">Edit</a>
                <form action="../../controllers/SocPostDelete.php" method="GET" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this post?');">
                  <input type="hidden" name="id" value="<?php echo htmlspecialchars($post['id']); ?>">
                  <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">Delete</button>
                </form>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="col-span-3 text-center text-gray-300">No posts found for this user.</p>
      <?php endif; ?>
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

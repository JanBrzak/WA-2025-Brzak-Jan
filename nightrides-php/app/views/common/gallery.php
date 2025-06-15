<?php
session_start();


require_once '../../models/Database.php';
require_once '../../models/SocPost.php';

$db = (new Database())->getConnection();
$socpostModel = new SocPost($db);
$socposts = $socpostModel->getAll(12); // Fetch last 12 posts
?>
<!DOCTYPE html>
<html lang="cz">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Galerie</title>
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
        <li><a href="about.php" class="hover:text-purple-400 transition">About</a></li>
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
      <a href="about.php" class="block py-1 hover:text-purple-400">About</a>
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

  <!-- Start text -->
  <div class="mt-12 space-y-8">
    <h1 class="text-4xl font-bold text-white">Welcome to the Gallery!</h1>
    <p class="text-gray-300">You can watch latest posts from users across the platform.</p>
    <!-- Gallerie -->
    <div class="mt-10">
      <h2 class="text-2xl font-semibold text-white mb-6">Latest 12 Posts</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php if (!empty($socposts)): ?>
          <?php foreach ($socposts as $post): ?>
            <a href="../SocPosts/socpost_detail.php?id=<?php echo urlencode($post['id']); ?>" class="block hover:scale-105 transition-transform duration-200">
            <div class="bg-gray-900 bg-opacity-90 rounded-lg shadow-lg p-5 flex flex-col border border-gray-800 hover:border-purple-700 transition-colors">
              <?php
                // Handle images
                $imagePaths = array_filter(explode(',', $post['images'] ?? ''));
                foreach ($imagePaths as $img):
                  $img = trim($img, "\" \t\n\r\0\x0B[]"); // Remove quotes/brackets
                  if ($img):
              ?>
                <img src="/WA-2025-Brzak-Jan/nightrides-php/<?php echo htmlspecialchars($img); ?>" alt="Post Image" class="w-full h-48 object-cover rounded mb-4">
              <?php endif; endforeach; ?>
              <h3 class="text-xl font-bold mb-2 text-purple-400"><?php echo htmlspecialchars($post['title']); ?></h3>
              <div class="text-purple-300 mb-1">By: <span class="font-medium"><?php echo htmlspecialchars($post['author']); ?></span></div>
              <span class="text-xs text-gray-400 mt-auto">Created: <?php echo htmlspecialchars($post['created_at']); ?></span>
            </div>
            </a>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="col-span-3 text-center text-gray-300">No posts found.</p>
        <?php endif; ?>
      </div>
    </div>
    <!-- Konec Galerie -->
    <div class="h-[1500px]"></div>
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
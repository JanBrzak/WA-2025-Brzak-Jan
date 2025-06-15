<?php
session_start();


require_once '../../models/Database.php';
require_once '../../models/SocPost.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../common/signin.php");
    exit;
}

$db = (new Database())->getConnection();
$socpostModel = new SocPost($db);

$isAdmin = ($_SESSION['role'] ?? '') === 'admin';
$currentUserId = $_SESSION['user_id'];

if ($isAdmin) {
    $socposts = $socpostModel->getAll();
} else {
    // Only show posts by the logged-in user
    $allPosts = $socpostModel->getAll();
    $socposts = array_filter($allPosts, function($post) use ($currentUserId) {
        return $post['user_id'] == $currentUserId;
    });
}

// Fetch all users for admin username display
$usernames = [];
if ($isAdmin) {
    require_once '../../models/User.php';
    $userModel = new User($db);
    foreach ($userModel->getAllUsers() as $user) {
        $usernames[$user['id']] = $user['username'];
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
    <title>My Posts</title>
</head>
<body class="bg-fixed min-h-screen m-0 bg-gradient-to-br from-black via-gray-700 to-purple-700">

   <div class="max-w-7xl mx-auto px-4">
  <!-- Sticky Navbar inside container -->
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
      <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <li><a href="../admin/users_list.php" class="hover:text-purple-400 transition">Users</a></li>
      <?php endif; ?>
    </ul>
    <div class="hidden md:block">
      <?php if (isset($_SESSION['username'])): ?>
        <span class="font-semibold"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
        <a href="../../controllers/logout.php" class="block bg-purple-700 hover:bg-purple-800 text-white font-semibold px-4 py-2 rounded-md transition">Logout</a>
      <?php else: ?>
        <a href="../common/signin.php" class="bg-purple-700 hover:bg-purple-800 text-white font-semibold px-4 py-2 rounded-md transition">Login</a>
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
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
      <a href="../admin/users_list.php" class="block py-1 hover:text-purple-400">Users</a>
    <?php endif; ?>
    <?php if (isset($_SESSION['username'])): ?>
      <div class="flex flex-col space-y-2">
        <span class="block py-2 font-semibold"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
        <a href="../../controllers/logout.php" class="block bg-purple-700 hover:bg-purple-800 text-white font-semibold px-4 py-2 rounded-md transition">Logout</a>
      </div>
    <?php else: ?>
      <a href="../common/signin.php" class="block bg-purple-700 hover:bg-purple-800 text-white font-semibold px-4 py-2 rounded-md transition">Login</a>
    <?php endif; ?>
  </div>
</nav>

  <!-- Page Content -->
  <div class="mt-12 space-y-8">
    <h1 class="text-3xl font-bold text-purple-400 mb-6"><?php echo $isAdmin ? 'All Posts' : 'My Posts'; ?></h1>
    <div class="overflow-x-auto">
      <table class="min-w-full bg-gray-900 rounded-lg shadow-lg">
        <thead>
          <tr class="text-purple-400 text-left">
            <th class="py-2 px-4">ID</th>
            <th class="py-2 px-4">Title</th>
            <th class="py-2 px-4">Author</th>
            <th class="py-2 px-4">Created</th>
            <th class="py-2 px-4">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($socposts)): ?>
            <?php foreach ($socposts as $post): ?>
              <tr class="border-b border-gray-800 hover:bg-gray-800">
                <td class="py-2 px-4 text-gray-200"><?php echo htmlspecialchars($post['id']); ?></td>
                <td class="py-2 px-4 text-gray-200"><?php echo htmlspecialchars($post['title']); ?></td>
                <td class="py-2 px-4 text-gray-200">
                  <?php
                    if ($isAdmin) {
                      echo isset($usernames[$post['user_id']]) ? htmlspecialchars($usernames[$post['user_id']]) : 'Unknown';
                    } else {
                      echo htmlspecialchars($post['author']);
                    }
                  ?>
                </td>
                <td class="py-2 px-4 text-gray-400"><?php echo htmlspecialchars($post['created_at']); ?></td>
                <td class="py-2 px-4 flex gap-2">
                  <a href="socpost_edit.php?id=<?php echo htmlspecialchars($post['id']); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded">Edit</a>
                  <form action="../../controllers/SocPostDelete.php" method="GET" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this post?');">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($post['id']); ?>">
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">Delete</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="5" class="text-center text-gray-400 py-4">No posts found.</td></tr>
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
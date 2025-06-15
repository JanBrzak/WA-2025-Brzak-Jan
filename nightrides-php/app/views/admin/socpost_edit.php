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

// Get post ID from GET or POST
$postId = $_GET['id'] ?? $_POST['id'] ?? null;
if (!$postId || !is_numeric($postId)) {
    die('Invalid post ID.');
}

// Fetch the post
$post = $socpostModel->getById((int)$postId);
if (!$post) {
    die('Post not found.');
}

// Check permissions
$isAdmin = ($_SESSION['role'] ?? '') === 'admin';
if (!$isAdmin && $_SESSION['user_id'] != $post['user_id']) {
    die('Nemáte oprávnění upravovat tento příspěvek.');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $author = htmlspecialchars($_POST['author']);
    $text = htmlspecialchars($_POST['text']);
    $success = $socpostModel->update($post['id'], $title, $author, $text);
    if ($success) {
        header("Location: socpost_update_delete.php");
        exit;
    } else {
        $error = 'Chyba při aktualizaci příspěvku.';
    }
}
?>
<!DOCTYPE html>
<html lang="cz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../common/output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Post</title>
</head>
<body class="bg-fixed min-h-screen m-0 bg-gradient-to-br from-black via-gray-700 to-purple-700">
<div class="max-w-7xl mx-auto px-4">
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

<div class="mt-16 flex justify-center">
    <div class="w-full max-w-lg p-8 bg-gray-900 rounded-2xl shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center text-purple-500">Edit Post</h2>
        <?php if (!empty($error)): ?>
            <div class="text-red-500 mb-4"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="" method="POST" class="space-y-4">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($post['id']); ?>">
            <div>
                <label for="title" class="block text-sm font-medium text-white">Název příspěvku</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($post['title']); ?>" required class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300" />
            </div>
            <div>
                <label for="author" class="block text-sm font-medium text-white">Autor</label>
                <input type="text" name="author" id="author" value="<?php echo htmlspecialchars($post['author']); ?>" required class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300" />
            </div>
            <div>
                <label for="text" class="block text-sm font-medium text-white">Text příspěvku</label>
                <textarea name="text" id="text" rows="5" required class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300"><?php echo htmlspecialchars($post['text']); ?></textarea>
            </div>
            <button type="submit" class="w-full bg-purple-700 text-white py-2 rounded-lg hover:bg-purple-800 transition">Save changes</button>
        </form>
        <a href="socpost_update_delete.php" class="block text-center text-purple-400 mt-4 hover:underline">Back to the list of posts</a>
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

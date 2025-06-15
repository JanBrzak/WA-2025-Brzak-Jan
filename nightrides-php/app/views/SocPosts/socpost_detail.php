<?php
session_start();

require_once '../../models/Database.php';
require_once '../../models/SocPost.php';
require_once '../../models/Comment.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid post ID.');
}

$db = (new Database())->getConnection();
$socpostModel = new SocPost($db);
$commentModel = new Comment($db);
$post = $socpostModel->getById((int)$_GET['id']);
$comments = $commentModel->getBySocPostId((int)$_GET['id']);

if (!$post) {
    die('Post not found.');
}
?>
<!DOCTYPE html>
<html lang="cz">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../common/output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Detail příspěvku</title>
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

  <!-- Detail Content -->
  <div class="mt-12 space-y-8">
    <a href="../common/gallery.php" class="text-purple-400 hover:underline">&larr; Back to gallery</a>
    <div class="max-w-2xl mx-auto bg-gray-900 bg-opacity-90 rounded-lg shadow-lg p-8 flex flex-col mb-8">
      <?php
        $imagePaths = array_filter(explode(',', $post['images'] ?? ''));
        foreach ($imagePaths as $img):
          $img = trim($img, "\" \t\n\r\0\x0B[]");
          if ($img):
      ?>
        <img src="/WA-2025-Brzak-Jan/nightrides-php/<?php echo htmlspecialchars($img); ?>" alt="Post Image" class="w-full h-72 object-cover rounded mb-6">
      <?php endif; endforeach; ?>
      <h1 class="text-3xl font-bold mb-4 text-purple-400"><?php echo htmlspecialchars($post['title']); ?></h1>
      <div class="text-purple-300 mb-2">By: <span class="font-medium">
        <a href="../common/user_socposts.php?user_id=<?php echo urlencode($post['user_id']); ?>" class="hover:underline text-purple-300 hover:text-purple-400"><?php echo htmlspecialchars($post['author']); ?></a>
      </span></div>
      <p class="text-gray-200 mb-4 text-lg"><?php echo nl2br(htmlspecialchars($post['text'])); ?></p>
      <span class="text-xs text-gray-400 mt-auto">Created: <?php echo htmlspecialchars($post['created_at']); ?></span>
    </div>

    <!-- Comment Form -->
    <div class="max-w-2xl mx-auto bg-gray-900 bg-opacity-80 rounded-lg shadow p-6 mb-8">
      <?php if (isset($_SESSION['user_id'])): ?>
        <form action="../../controllers/CommentController.php" method="POST" class="space-y-4">
          <input type="hidden" name="socpost_id" value="<?php echo (int)$_GET['id']; ?>">
          <label for="text" class="block text-gray-200 font-semibold">Add a comment:</label>
          <textarea name="text" id="text" rows="3" required class="w-full p-2 rounded border border-gray-700 bg-gray-800 text-gray-100 focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
          <button type="submit" class="bg-purple-700 hover:bg-purple-800 text-white font-semibold px-4 py-2 rounded transition">Submit</button>
        </form>
      <?php else: ?>
        <p class="text-center text-gray-300">You must be <a href="../common/signin.php" class="text-purple-400 underline">logged in</a> to comment.</p>
      <?php endif; ?>
    </div>

    <!-- Comments List -->
    <div class="max-w-2xl mx-auto bg-gray-900 bg-opacity-80 rounded-lg shadow p-6">
      <h2 class="text-xl font-bold mb-4 text-purple-400">Comments</h2>
      <?php if (!empty($comments)): ?>
        <ul class="space-y-4">
          <?php foreach ($comments as $comment): ?>
            <li class="border-b border-gray-800 pb-2">
              <div class="flex items-center justify-between">
                <div class="text-purple-300 font-semibold mb-1">
                  <?php echo isset($comment['username']) ? htmlspecialchars($comment['username']) : 'Unknown user'; ?>
                </div>
                <?php
                  $canDelete = false;
                  if (isset($_SESSION['user_id'], $_SESSION['role'])) {
                    // If admin, or if user is the comment author
                    if ($_SESSION['role'] === 'admin' || (isset($comment['user_id']) && $_SESSION['user_id'] == $comment['user_id'])) {
                      $canDelete = true;
                    }
                  }
                ?>
                <?php if ($canDelete): ?>
                  <form action="../../controllers/CommentDelete.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                    <input type="hidden" name="comment_id" value="<?php echo htmlspecialchars($comment['id'] ?? ''); ?>">
                    <input type="hidden" name="socpost_id" value="<?php echo (int)$_GET['id']; ?>">
                    <button type="submit" class="text-red-400 hover:text-red-600 font-bold">Delete</button>
                  </form>
                <?php endif; ?>
              </div>
              <div class="text-gray-200 mb-1"><?php echo nl2br(htmlspecialchars($comment['text'])); ?></div>
              <div class="text-xs text-gray-400"><?php echo htmlspecialchars($comment['created_at']); ?></div>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p class="text-gray-400">No comments yet.</p>
      <?php endif; ?>
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

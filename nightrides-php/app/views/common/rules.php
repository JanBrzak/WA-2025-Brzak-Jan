<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Site Rules & Community Guidelines | Night Rides</title>
</head>
<body class="bg-fixed min-h-screen m-0 bg-gradient-to-br from-black via-gray-700 to-purple-700">
<div class="max-w-3xl mx-auto px-4">
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
        <li><a href="rules.php" class="hover:text-purple-400 transition font-bold">Rules</a></li>
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
      <a href="rules.php" class="block py-1 hover:text-purple-400 font-bold">Rules</a>
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
  <!-- Rules Content -->
  <div class="bg-gray-900 bg-opacity-90 rounded-lg shadow-lg p-8 mb-12">
    <h1 class="text-3xl font-bold text-purple-400 mb-6">Site Rules & Community Guidelines</h1>
    <p class="text-gray-200 mb-6">To keep Night Rides a fun, respectful, and inspiring place for all car lovers, we’ve created a set of rules that every user must follow. These guidelines are designed to support a safe, inclusive, and passionate environment where gearheads from all backgrounds can share their rides and enjoy the community.</p>
    <ol class="list-decimal list-inside text-gray-200 space-y-4 mb-6">
      <li>
        <b>Respect Others</b><br>
        We’re all here because we love cars. Treat others the way you want to be treated:
        <ul class="list-disc list-inside ml-6">
          <li>No personal attacks, harassment, or bullying.</li>
          <li>No racism, sexism, homophobia, or any form of hate speech.</li>
          <li>Critique builds respectfully. You can give feedback, but keep it constructive.</li>
        </ul>
        <div class="mt-2">
          <span class="text-red-400">🚫 Example of what not to do:</span><br>
          <span class="italic text-gray-400">“Your car is trash. What were you thinking?”</span><br>
          <span class="text-green-400">✅ Better:</span><br>
          <span class="italic text-gray-400">“I think a different wheel setup might suit the car better, but props for the unique approach!”</span>
        </div>
      </li>
      <li>
        <b>Content Must Be Relevant to Car Culture</b><br>
        Night Rides is dedicated to automotive content. Please keep your uploads focused on:
        <ul class="list-disc list-inside ml-6">
          <li>Cars, motorcycles, trucks, and other vehicles</li>
          <li>Parts and modifications</li>
          <li>Car meets, shows, and track events</li>
          <li>Builds in progress</li>
          <li>Garage work and DIY upgrades</li>
        </ul>
        <span class="text-gray-400">Unrelated content, spam, or off-topic posts (like random selfies, politics, or memes not related to cars) may be removed.</span>
      </li>
      <li>
        <b>No NSFW or Inappropriate Material</b><br>
        This is a community for all ages. Do not post or share:
        <ul class="list-disc list-inside ml-6">
          <li>Nudity or sexually suggestive content</li>
          <li>Gore or violent imagery</li>
          <li>Illegal activities (e.g., street racing videos in active traffic, drugs, etc.)</li>
        </ul>
        <span class="text-gray-400">If your post contains strong language or intense content (e.g., race crashes), use a warning in the caption.</span>
      </li>
      <li>
        <b>Use Accurate & Honest Descriptions</b><br>
        When uploading a post:
        <ul class="list-disc list-inside ml-6">
          <li>Use clear and descriptive titles (e.g., “Turbo Civic B18 Build” instead of “My car”).</li>
          <li>Don’t mislead users about what they’re seeing.</li>
          <li>If it's not your car, give credit when possible.</li>
        </ul>
        <span class="text-gray-400">This builds trust and improves the quality of the platform.</span>
      </li>
      <li>
        <b>No Spam or Self-Promotion Without Permission</b><br>
        We welcome content creators, YouTubers, and shops—but spam will not be tolerated.
        <ul class="list-disc list-inside ml-6">
          <li>No flooding the platform with links or ads.</li>
          <li>You may promote your channel, garage, or merch in your bio or one dedicated post.</li>
          <li>If you’re a business and want to advertise, please reach out to the admins.</li>
        </ul>
      </li>
      <li>
        <b>Respect Copyright & Ownership</b><br>
        Only upload content that you:
        <ul class="list-disc list-inside ml-6">
          <li>Own the rights to (your photos, your car, etc.)</li>
          <li>Have permission to post (e.g., from the photographer or owner)</li>
        </ul>
        <span class="text-gray-400">Do not reupload content from Instagram, YouTube, or other platforms unless you are the original creator or have clear consent.</span>
      </li>
      <li>
        <b>Be Safe & Responsible</b><br>
        This platform does not encourage or glorify illegal or reckless driving. Sharing burnout videos or race content is okay—only if it's done legally and safely.
        <ul class="list-disc list-inside ml-6">
          <li>Do not post street racing in traffic</li>
          <li>Dangerous stunts on public roads</li>
          <li>Encouragement of illegal activities</li>
        </ul>
        <span class="text-gray-400">Let’s promote the right side of car culture—the one that celebrates skill, not recklessness.</span>
      </li>
      <li>
        <b>Profiles & Usernames</b><br>
        <ul class="list-disc list-inside ml-6">
          <li>No offensive or impersonating usernames.</li>
          <li>No fake accounts or bots.</li>
          <li>Do not pretend to be someone else or impersonate a known creator or shop.</li>
        </ul>
      </li>
      <li>
        <b>Reporting & Moderation</b><br>
        Our moderators work hard to keep the community clean and respectful. You can help by:
        <ul class="list-disc list-inside ml-6">
          <li>Reporting inappropriate content</li>
          <li>Flagging spam</li>
          <li>Reaching out with concerns</li>
        </ul>
        <span class="text-gray-400">We review all reports manually to ensure fair moderation.</span>
      </li>
      <li>
        <b>Violation Consequences</b><br>
        Breaking these rules can lead to:
        <ul class="list-disc list-inside ml-6">
          <li>A warning</li>
          <li>Temporary suspension</li>
          <li>Permanent ban</li>
        </ul>
        <span class="text-gray-400">We take rule violations seriously—but we’re also fair. If you think you were banned unfairly, you can appeal through our contact form or by messaging an admin.</span>
      </li>
    </ol>
    <h2 class="text-2xl font-semibold text-purple-300 mt-8 mb-2">Final Word</h2>
    <p class="text-gray-300 mb-4">Night Rides  is more than just a website. It’s a reflection of the car culture we all love—built on respect, creativity, and a shared passion for machines.</p>
    <p class="text-gray-300 mb-4">Let’s keep it clean, cool, and full of energy.<br>If we all follow these guidelines, this community will only grow stronger—and more fun—for everyone.</p>
    <p class="text-gray-200 font-bold">Thank you for being part of the ride.<br>Stay classy, stay tuned, and keep those engines running. 🏁</p>
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

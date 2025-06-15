<?php
session_start(); // Required for user session in navbar
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>About | Night Rides</title>
</head>
<body class="bg-fixed min-h-screen m-0 bg-gradient-to-br from-black via-gray-700 to-purple-700">
<div class="max-w-4xl mx-auto px-4">
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
        <li><a href="About.php" class="hover:text-purple-400 transition font-bold">About</a></li>
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
      <a href="About.php" class="block py-1 hover:text-purple-400 font-bold">About</a>
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
  <!-- About Content -->
  <div class="bg-gray-900 bg-opacity-90 rounded-lg shadow-lg p-8 mb-12">
    <h1 class="text-4xl font-bold text-purple-400 mb-6">About</h1>
    <p class="text-lg text-gray-200 mb-6">Welcome to Night Rides, the ultimate digital garage for car enthusiasts around the globe.</p>
    <p class="text-gray-300 mb-4">Whether you're a JDM fanatic, a Euro performance lover, or a muscle car purist, this is your space to share your builds, discover others, and connect with like-minded people who live for the roar of engines and the shine of freshly waxed paint.</p>
    <h2 class="text-2xl font-semibold text-purple-300 mt-8 mb-2">What We’re About</h2>
    <p class="text-gray-300 mb-4">At our core, we’re about community. Night Rides was created out of a love for cars and the culture that surrounds them—from casual weekend meets in empty parking lots to full-blown track days and custom car shows. We wanted to build a platform where every type of gearhead could come together and showcase what makes their ride unique.</p>
    <ul class="list-disc list-inside text-gray-200 mb-4">
      <li>Share photos of your latest mods, custom builds, or just a clean wash job.</li>
      <li>Connect with others who appreciate craftsmanship, performance, and aesthetics as much as you do.</li>
      <li>Discover cars from all around the world—classic restorations, sleeper builds, drift missiles, exotics, and more.</li>
      <li>Organize meets, track days, or local events with fellow members.</li>
      <li>Get inspired by unique builds, rare parts, or just cool ideas you never thought of before.</li>
    </ul>
    <h2 class="text-2xl font-semibold text-purple-300 mt-8 mb-2">Features</h2>
    <ul class="list-disc list-inside text-gray-200 mb-4">
      <li>🔧 <b>User Posts:</b> Upload your car photos and details—whether it’s a complete build, a new part install, or a meet you just attended.</li>
      <li>🚗 <b>Latest Rides Gallery:</b> Browse the freshest uploads from the community. Stay up to date with what’s trending in the scene.</li>
      <li>🌍 <b>User Profiles:</b> Check out other members' builds and track their journey over time.</li>
      <li>🧭 <b>Events & Meets (Coming Soon):</b> We're working on features to help you find and create real-life car meets near you. Stay tuned!</li>
    </ul>
    <h2 class="text-2xl font-semibold text-purple-300 mt-8 mb-2">Who It's For</h2>
    <p class="text-gray-300 mb-4">This site is for everyone with motor oil in their veins:</p>
    <ul class="list-disc list-inside text-gray-200 mb-4">
      <li>DIY garage warriors</li>
      <li>Drift kings and queens</li>
      <li>Restoration artists</li>
      <li>Tuners, modders, painters, and polishers</li>
      <li>Newbies looking to learn</li>
      <li>Veterans of the car scene who want to document their journey</li>
    </ul>
    <p class="text-gray-300 mb-4">You don’t need the fastest car or the rarest parts—just passion and the willingness to share it.</p>
    <h2 class="text-2xl font-semibold text-purple-300 mt-8 mb-2">Our Vision</h2>
    <p class="text-gray-300 mb-4">We envision a world where car culture lives beyond Instagram hashtags and parking lot small talk. Here, your build has context. Your meet has purpose. Your passion has a home.</p>
    <p class="text-gray-300 mb-4">We aim to create not just another car feed—but a hub where passion is shared, creativity is encouraged, and respect is mutual.</p>
    <h2 class="text-2xl font-semibold text-purple-300 mt-8 mb-2">Get Involved</h2>
    <p class="text-gray-300 mb-4">Creating your profile is easy, and posting takes just seconds. You can comment, react, and even follow users whose rides inspire you. New features are always in the works, and your feedback helps shape the future of the site.</p>
    <p class="text-gray-200">So whether you’re wrenching in your garage or polishing your pride and joy for tonight’s meet—Night Rides is your place. <b>Upload. Connect. Cruise.</b></p>
    <h2 class="text-2xl font-semibold text-purple-300 mt-8 mb-2">Our Story</h2>
    <p class="text-gray-300 mb-4">Night Rides was born in the late-night parking lots, under streetlights where car lovers gathered not just to show off builds—but to share stories, trade advice, and build friendships. What started as a few photos in group chats and endless DMs turned into the idea:<br>"Why not build a platform just for us?"</p>
    <p class="text-gray-300 mb-4">No algorithms. No noise. Just cars and the people who love them.</p>
    <p class="text-gray-300 mb-4">We knew the community deserved more than scattered Facebook groups or short-lived Instagram posts. So we built a dedicated home—designed by car enthusiasts, for car enthusiasts.</p>
    <h2 class="text-2xl font-semibold text-purple-300 mt-8 mb-2">Why We Built This</h2>
    <p class="text-gray-300 mb-4">There’s something special about the car community. It’s not just about horsepower or carbon fiber—it’s about expression, passion, and the bond that forms between people who get excited over engine bays and body lines.</p>
    <p class="text-gray-300 mb-4">We were tired of mainstream social platforms not giving builds the attention they deserve. Posts vanish in feeds. Comments get lost. Meets are hard to organize.<br>We wanted to change that.</p>
    <p class="text-gray-300 mb-4">So we created this space where:</p>
    <ul class="list-disc list-inside text-gray-200 mb-4">
      <li>Your car can have a permanent place to shine.</li>
      <li>Your builds are part of your story—not just content.</li>
      <li>You can actually meet the people behind the machines.</li>
    </ul>
    <h2 class="text-2xl font-semibold text-purple-300 mt-8 mb-2">The Culture</h2>
    <p class="text-gray-300 mb-4">We're not just a site. We’re a movement.</p>
    <p class="text-gray-300 mb-4">Car culture is diverse. It’s the slammed Civics, the bagged Benzes, the spotless engine bays, the track-ready WRXs, the hand-built V8s, the rare JDM imports. It’s the road trips, the dyno pulls, the failed mods that turned into better ideas.</p>
    <p class="text-gray-300 mb-4">Respect comes first here. Whether you’re just starting with a stock daily or you’ve poured five years into your widebody showstopper, every car tells a story—and every story belongs.</p>
    <h2 class="text-2xl font-semibold text-purple-300 mt-8 mb-2">What’s Next?</h2>
    <p class="text-gray-300 mb-4">We’re constantly building. Here’s what’s coming soon:</p>
    <ul class="list-disc list-inside text-gray-200 mb-4">
      <li>📅 Meet/Event scheduling tools</li>
      <li>🛠️ Build logs & part lists</li>
      <li>📊 Performance tracking & dyno sheets</li>
      <li>🗺️ Location-based community features</li>
      <li>🎖️ Verified builds & community highlights</li>
    </ul>
    <p class="text-gray-300 mb-4">Our roadmap is built around what you want—so keep sharing ideas, and let’s grow this together.</p>
    <h2 class="text-2xl font-semibold text-purple-300 mt-8 mb-2">Thank You for Being Here</h2>
    <p class="text-gray-300 mb-4">To every enthusiast who’s taken the time to sign up, share their story, or even just scroll through a few builds—thank you.</p>
    <p class="text-gray-300 mb-4">This platform was born out of a simple idea: that the car scene deserves more than quick posts, scattered chats, and disappearing stories. It deserves a space where every photo, every meet, and every late-night ride lives on—not just as a memory, but as part of a living, breathing culture.</p>
    <p class="text-gray-300 mb-4">You, the community, are the soul of this site. Whether you're building your first project car, daily-driving your pride and joy, attending your hundredth meet, or just here for inspiration—your presence fuels everything we do.</p>
    <p class="text-gray-300 mb-2">Thank you for:</p>
    <ul class="list-disc list-inside text-gray-200 mb-4">
      <li>Sharing your ride, no matter the stage it’s in.</li>
      <li>Supporting other builders with encouragement, advice, or just a 🔥 emoji.</li>
      <li>Respecting the culture, the craft, and each other.</li>
      <li>Being part of something that goes beyond likes and followers.</li>
    </ul>
    <p class="text-gray-300 mb-4">We know the car scene isn’t just about horsepower or polished paint—it’s about people. It’s about friendships forged over engine bays, midnight drives that turn into lifelong memories, and builds that reflect personality and perseverance.</p>
    <p class="text-gray-300 mb-4">We’re proud to host a place where all of that lives. And we’re even prouder that you chose to be a part of it.</p>
    <p class="text-gray-300 mb-4">So again—thank you. For your time, your passion, and your trust. We’re just getting started, and we’re glad you’re riding with us.</p>
    <p class="text-gray-200 font-bold">See you at the next meet. 👊<br>—The Night Rides Team</p>
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

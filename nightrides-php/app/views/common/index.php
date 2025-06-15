<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  header("Location: gallery.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="cz">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>WELCOME TO NIGHTRIDES</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-black via-gray-700 to-purple-700 flex items-center justify-center p-6">
 <!-- Basic text -->
  <div class="flex flex-col items-center space-y-8 max-w-5xl w-full">
    <h1 class="font-bold text-white text-center text-2xl sm:text-4xl md:text-5xl lg:text-6xl leading-snug sm:leading-tight">
      HELLO PETROLHEADS, THIS IS A WEBPAGE FOR SHARING YOUR EXPERIENCE FROM CAR EVENTS, MEETS, AND LATE NIGHT RIDES
    </h1>
     <!-- redirect button -->
    <form method="POST" class="w-full flex justify-center">
      <button
        type="submit"
        class="w-full sm:w-auto text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300
               font-semibold rounded-xl text-base sm:text-lg md:text-xl px-6 py-3 md:px-10 md:py-4
               transition duration-300 ease-in-out"
      >
        Start
      </button>
    </form>
  </div>

</body>
</html>
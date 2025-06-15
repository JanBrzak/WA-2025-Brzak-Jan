<?php
session_start();
require_once '../../models/Database.php';
require_once '../../models/User.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: ../common/signin.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid user ID.');
}

$db = (new Database())->getConnection();
$userModel = new User($db);
$user = $userModel->getUserById((int)$_GET['id']);
if (!$user) {
    die('User not found.');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'] ?? $user['role'];
    $name = $_POST['name'] ?? $user['name'];
    $surname = $_POST['surname'] ?? $user['surname'];
    $email = $_POST['email'] ?? $user['email'];
    $userModel->updateUser($user['id'], $name, $surname, $email, $role);
    header('Location: users_list.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="cz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit User</title>
</head>
<body class="bg-fixed min-h-screen m-0 bg-gradient-to-br from-black via-gray-700 to-purple-700">
<div class="max-w-7xl mx-auto px-4">
<?php // ...navbar code as unified on other admin pages... ?>
<div class="mt-16 flex justify-center">
    <div class="w-full max-w-lg p-8 bg-gray-900 rounded-2xl shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center text-purple-500">Edit User</h2>
        <form action="" method="POST" class="space-y-4">
            <div>
                <label for="username" class="block text-sm font-medium text-white">Username</label>
                <input type="text" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" disabled class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-700 text-gray-300" />
            </div>
            <div>
                <label for="name" class="block text-sm font-medium text-white">Name</label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['name']); ?>" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg" />
            </div>
            <div>
                <label for="surname" class="block text-sm font-medium text-white">Surname</label>
                <input type="text" name="surname" id="surname" value="<?php echo htmlspecialchars($user['surname']); ?>" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg" />
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-white">Email</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg" />
            </div>
            <div>
                <label for="role" class="block text-sm font-medium text-white">Role</label>
                <select name="role" id="role" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="user" <?php if($user['role']==='user') echo 'selected'; ?>>user</option>
                    <option value="admin" <?php if($user['role']==='admin') echo 'selected'; ?>>admin</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-purple-700 text-white py-2 rounded-lg hover:bg-purple-800 transition">Save Changes</button>
        </form>
        <a href="users_list.php" class="block text-center text-purple-400 mt-4 hover:underline">Back to Users List</a>
    </div>
</div>
</div>
</body>
</html>

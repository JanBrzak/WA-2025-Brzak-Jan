<?php
require_once '../models/Database.php';
require_once '../models/User.php';

session_start();

// Připojení k databázi a model
$db = (new Database())->getConnection();
$userModel = new User($db);

// Validace POST dat
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $name = !empty($_POST['name']) ? trim($_POST['name']) : null;
    $surname = !empty($_POST['surname']) ? trim($_POST['surname']) : null;
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if (empty($username) || empty($password) || empty($password_confirm)) {
        die('Vyplňte prosím všechna povinná pole.');
    }
    // Kontrola hesla
    if ($password !== $password_confirm) {
        die('Hesla se neshodují.');
    }
    // Kontrola zda je uživatelské jméno obsazené
    if ($userModel->existsByUsername($username)) {
        die('Uživatelské jméno je již obsazené.');
    }
    // Hashování hesla
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    if ($userModel->register($username, $email, $hashedPassword, $name, $surname)) {
        header("Location: ../views/common/signin.php");
        exit();
    } else {
        die('Registrace se nezdařila.');
    }
} else {
    die('Neplatný požadavek.');
}
<?php
require_once '../models/Database.php';
require_once '../models/User.php';

session_start();

if (($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: ../views/common/signin.php");
    exit;
}

if (isset($_GET['id'])) {
    $userId = (int)$_GET['id'];
    $db = (new Database())->getConnection();
    $userModel = new User($db);
    $userModel->delete($userId);
}

header("Location: ../views/admin/users_edit_delete.php");
exit;
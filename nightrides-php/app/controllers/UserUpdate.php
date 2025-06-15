<?php
require_once '../models/Database.php';
require_once '../models/User.php';

session_start();

if (($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: ../views/common/index.php");
    exit;
}

if (isset($_POST['id'], $_POST['role'])) {
    $userId = (int)$_POST['id'];
    $role = $_POST['role'];

    $db = (new Database())->getConnection();
    $userModel = new User($db);
    $userModel->updateRole($userId, $role);
}

header("Location: ../views/admin/users_edit_delete.php");
exit;
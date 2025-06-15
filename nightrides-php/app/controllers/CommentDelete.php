<?php
session_start();
require_once '../models/Database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/common/signin.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_id'], $_POST['socpost_id'])) {
    $comment_id = (int)$_POST['comment_id'];
    $socpost_id = (int)$_POST['socpost_id'];
    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['role'] ?? '';

    $db = (new Database())->getConnection();
    // získání autora komentáře
    $stmt = $db->prepare("SELECT user_id FROM comments WHERE id = ?");
    $stmt->execute([$comment_id]);
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($comment) {
        // zjistit, zda je uživatel admin nebo autor komentáře
        if ($role === 'admin' || $comment['user_id'] == $user_id) {
            $stmt = $db->prepare("DELETE FROM comments WHERE id = ?");
            $stmt->execute([$comment_id]);
        } else {
            // Neoprávněný přístup
            header("Location: ../views/common/gallery.php?error=unauthorized");
            exit;
        }
    }
    header("Location: ../views/SocPosts/socpost_detail.php?id=" . $socpost_id);
    exit;
} else {
    header("Location: ../views/common/gallery.php");
    exit;
}
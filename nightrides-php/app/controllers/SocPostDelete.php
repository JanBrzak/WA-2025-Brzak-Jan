<?php
    session_start();
    require_once '../models/Database.php';
    require_once '../models/SocPost.php';

    if (!isset($_SESSION['user_id'])) {
        die('Nepřihlášený uživatel.');
    }
    $currentUserId = $_SESSION['user_id'];
    $isAdmin = ($_SESSION['role'] ?? '') === 'admin';

    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];

        $db = (new Database())->getConnection();
        $socpostModel = new SocPost($db);

        $socpost = $socpostModel->getById($id);
        $ownsSocPost = $currentUserId == $socpost['user_id'];
        // Kontrola oprávnění
        if (!$isAdmin && !$ownsSocPost) {
            die("Nemáte oprávnění smazat tento článek.");
        }

        if ($socpostModel->delete($id)) {
            header("Location: ../views/admin/socpost_update_delete.php");
            exit();
        } else {
            echo "Chyba při mazání článku.";
        }
    } else {
        echo "Neplatný požadavek.";
    }
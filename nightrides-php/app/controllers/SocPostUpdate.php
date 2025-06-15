
<?php
    require_once '../models/Database.php';
    require_once '../models/SocPost.php';
    session_start();

    // Ověření, že uživatel je přihlášen
    if (!isset($_SESSION['user_id'])) {
        die('Nepřihlášený uživatel.');
    }

    $currentUserId = $_SESSION['user_id'];
    $isAdmin = ($_SESSION['role'] ?? '') === 'admin';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = (int)$_POST['id'];

        $db = (new Database())->getConnection();
        $socpostModel = new SocPost($db);
        $socpost = $socpostModel->getById($id); // Nacteni clanku, ziskani ID

        // Kontrola oprávnění
        $ownsSocPost = $currentUserId == $socpost['user_id'];
        if (!$isAdmin && !$ownsSocPost) {
            die("Nemáte oprávnění upravovat tento článek.");
        }

        $title = htmlspecialchars($_POST['title']);
        $author = htmlspecialchars($_POST['author']);
        $text = htmlspecialchars($_POST['text']);

        $db = (new Database())->getConnection();
        $socpostModel = new SocPost($db);

        //aktualizace
        $success = $socpostModel->update(
            $id,
            $title,
            $author,
            $text
        );

        if ($success) {
            header("Location: ../views/admin/socposts_edit_delete.php");
            exit();
        } else {
            echo "Chyba při aktualizaci socpostu.";
        }
    } else {
        echo "Neplatný požadavek.";
    }
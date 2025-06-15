<?php
session_start();

require_once '../models/Database.php';
require_once '../models/Comment.php';

class CommentController {
    private $db;
    private $commentModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->commentModel = new Comment($this->db);
    }

    public function createComment() {
        if (!isset($_SESSION['user_id']) || $_SERVER["REQUEST_METHOD"] !== "POST") {
            exit("Neautorizovaný přístup.");
        }

        $user_id = $_SESSION['user_id'];
        $text = htmlspecialchars($_POST['text']);
        $socpost_id = (int)$_POST['socpost_id'];

        if ($this->commentModel->create($user_id, $socpost_id, $text)) {
            header("Location: ../views/SocPosts/socpost_detail.php?id=" . $socpost_id);
            exit();
        } else {
            echo "Chyba při ukládání komentáře.";
        }
    }
}

$controller = new CommentController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $controller->createComment();
}
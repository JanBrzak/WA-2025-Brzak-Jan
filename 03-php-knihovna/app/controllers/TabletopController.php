<?php
require_once '../models/Database.php';
require_once '../models/Tabletop.php';

class TabletopController {
    private $db;
    private $tabletopModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->tabletopModel = new Tabletop($this->db);
    }

    public function createTabletop() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = htmlspecialchars($_POST['title']);
            $author = htmlspecialchars($_POST['author']);
            $category = htmlspecialchars($_POST['category']);
            $price = floatval($_POST['price']);
            $description = htmlspecialchars($_POST['description']);
            $link = htmlspecialchars($_POST['link']);

            // Zpracování nahraných obrázků
            $imagePaths = [];
            if (!empty($_FILES['images']['name'][0])) {
                $uploadDir = '../public/images/';
                foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                    $filename = basename($_FILES['images']['name'][$key]);
                    $targetPath = $uploadDir . $filename;

                    if (move_uploaded_file($tmp_name, $targetPath)) {
                        $imagePaths[] = '/public/images/' . $filename; // Relativní cesta
                    }
                }
            }

            // Uložení knihy do DB - dočasné řešení, než budeme mít výpis knih
            if ($this->tabletopModel->create($title, $author, $category,$price, $description, $link, $imagePaths)) {
                header("Location: ../app/controllers/tabletops_list.php");
                exit();
            } else {
                echo "Chyba při ukládání deskovky.";
            }
        }
    }

    public function listTabletops() {
        $tabletops = $this->tabletopModel->getAll();
        include '../views/tabletops/tabletops_list.php'; 
    }
}

// Volání metody při odeslání formuláře
$controller = new TabletopController();
$controller->createTabletop();
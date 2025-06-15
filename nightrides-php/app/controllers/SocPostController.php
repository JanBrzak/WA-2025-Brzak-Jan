<?php
session_start();


require_once '../models/Database.php';
require_once '../models/SocPost.php';

class SocPostController {
    private $db;
    private $socpostModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->socpostModel = new SocPost($this->db);
    }

    private function removeDiacritics($string) {
        $transliterationTable = [
            'á'=>'a','č'=>'c','ď'=>'d','é'=>'e','ě'=>'e','í'=>'i','ň'=>'n','ó'=>'o','ř'=>'r','š'=>'s','ť'=>'t','ú'=>'u','ů'=>'u','ý'=>'y','ž'=>'z',
            'Á'=>'A','Č'=>'C','Ď'=>'D','É'=>'E','Ě'=>'E','Í'=>'I','Ň'=>'N','Ó'=>'O','Ř'=>'R','Š'=>'S','Ť'=>'T','Ú'=>'U','Ů'=>'U','Ý'=>'Y','Ž'=>'Z'
        ];
        $string = strtr($string, $transliterationTable);
        $string = preg_replace('/[^A-Za-z0-9_.-]/', '', $string); // Remove any other special chars
        return $string;
    }

    public function createSocPost() {
        //kontrola prihlaseni
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../views/common/gallery.php");
            die("Uživatel není přihlášen.");
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userId = $_SESSION['user_id'];
            $title = htmlspecialchars($_POST['title']);
            $author = htmlspecialchars($_POST['author']);
            $text = htmlspecialchars($_POST['text']);


            // Získání ID přihlášeného uživatele
            $user_id = $_SESSION['user_id'];

            // Zpracování nahraných obrázků
            $imagePaths = [];
            if (!empty($_FILES['images']['name'][0])) {
                $uploadDir = __DIR__ . '/../../public/img/'; // Absolute path to public/img
                foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                    $origFilename = basename($_FILES['images']['name'][$key]);
                    $filename = $this->removeDiacritics($origFilename);
                    $targetPath = $uploadDir . $filename;

                    if (move_uploaded_file($tmp_name, $targetPath)) {
                        // Store relative path for DB (for example: 'public/img/filename.jpg')
                        $imagePaths[] = 'public/img/' . $filename;
                    }
                }
            }

            //odeslani dat do databaze
            if ($this->socpostModel->create(
                $title, $author,  $text, 
                $imagePaths, $user_id
            )) {
                header("Location: ../views/common/gallery.php");
                exit();
            } else {
                echo "Chyba při ukládání článku.";
            }  
        }
    }
}

$controller = new SocPostController();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $controller->createSocPost();
}


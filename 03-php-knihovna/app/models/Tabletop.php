<?php

class Tabletop {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($title, $author, $category, $price, $description, $link, $images) {
        
        // Dvojtečka označuje pojmenovaný parametr => Místo přímých hodnot se používají placeholdery.
        // PDO je pak nahradí skutečnými hodnotami při volání metody execute().
        // Chrání proti SQL injekci (bezpečnější než přímé vložení hodnot).
        $sql = "INSERT INTO tabletops (title, author, category, price, description, link, images) 
                VALUES (:title, :author, :category, :price, :description, :link, :images)";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':category' => $category,
            ':price' => $price,
            ':description' => $description,
            ':link' => $link,
            ':images' => json_encode($images) // Ukládání obrázků jako JSON
        ]);
    }

    public function getAll() {
        $sql = "SELECT * FROM tabletops ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }
}
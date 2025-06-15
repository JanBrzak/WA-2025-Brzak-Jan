<?php

class SocPost {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    //ulozeni Socialnich postu do datbaze
    public function create($title, $author, $text, $images, $user_id) {
        
       $sql = "INSERT INTO socposts (
                title, author, text, images, user_id
            ) VALUES (
                :title, :author, :text, :images, :user_id
            )";
        
        $stmt = $this->db->prepare($sql);
        
        $result = $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':text' => $text,
            ':images' => json_encode($images),
            ':user_id' => $user_id
        ]);

        if (!$result) {
            $error = $stmt->errorInfo();
            echo "Chyba při vkládání: " . $error[2]; 
        }

        return $result;
    }

    //ziskani SocPostu, moznost limitu
    public function getAll(int $limit = null): array {
        $sql = "SELECT * FROM socposts ORDER BY created_at DESC";
        if ($limit !== null) {
            
            $sql .= " LIMIT " . (int)$limit;
        }
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //ziskani socpostu pomocí id
    public function getById($id) {
        $sql = "SELECT * FROM socposts WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //nahrani novych dat
    public function update($id, $title, $author, $text) {
        $sql = "UPDATE socposts
                SET title = :title,
                    author = :author,
                    text = :text
                WHERE id = :id";
    
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':author' => $author,
            ':text' => $text,
           
        ]);
    }

    //smazani konkretniho socpostu
    public function delete($id) {
        $sql = "DELETE FROM socposts WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    //vybere 3 socposty podle ID
    public function getLastFreeSocPosts($limit = 3) {
        $stmt = $this->db->prepare("SELECT id FROM socposts ORDER BY created_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    //Vybere Socposty podle ID uzivatele
    public function getByUserId($userId) {
        $stmt = $this->db->prepare("SELECT * FROM socposts WHERE user_id = :user_id ORDER BY created_at DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
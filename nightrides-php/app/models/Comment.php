<?php

class Comment {
    private $db;

    //__construct() automaticky se spusti pri vytvoreni objektu
    public function __construct($db) {
        $this->db = $db;
    }

    //vytvoreni komentare, ulozeni do databaze
    public function create($user_id, $socpost_id, $text) {
        $sql = "INSERT INTO comments (user_id, socpost_id, text) 
                VALUES (:user_id, :socpost_id, :text)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id' => $user_id,
            ':socpost_id' => $socpost_id,
            ':text' => $text
        ]);
    }

    //komentare ke konkretnimu Socialniho postu
    public function getBySocPostId($socpost_id) {
        $sql = "SELECT c.id, c.user_id, c.text, c.created_at, u.username 
                FROM comments c
                JOIN users u ON c.user_id = u.id
                WHERE c.socpost_id = :socpost_id
                ORDER BY c.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':socpost_id' => $socpost_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //vsechny komentare
    public function getAll() {
        $sql = "SELECT c.id, c.socpost_id, c.text, c.created_at, u.username 
                FROM comments c
                JOIN users u ON c.user_id = u.id
                ORDER BY c.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
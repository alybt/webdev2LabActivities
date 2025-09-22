<?php

require_once "database.php";

class book{
    public $title = "";
    public $author = "";
    public $genre = "";
    public $publication_year ="";

    protected $db;


    public function __construct(){
        $this->db = new Database();
    }

    public function addBook(){
        $sql = "INSERT INTO book(title, author, genre,publication_year) VALUES ( :title, :author, :genre, :publication_year )";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":publication_year", $this->publication_year);

        return $query->execute();
    }

    public function viewBook($search = "", $genre = "") {
    $sql = "SELECT * FROM book WHERE title LIKE :search";
    $params = [":search" => "%$search%"]; // keep :search

    if (!empty($genre)) {
        $sql .= " AND genre = :genre";
        $params[":genre"] = $genre; 
    }

    $sql .= " ORDER BY title ASC";

    $stmt = $this->db->connect()->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function getGenre(){
        $sql = "SELECT DISTINCT genre FROM book ORDER BY genre ASC";
        $params = [];
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    
    


}
<?php

require_once "databases.php";
class Book extends Database {
    public $id="";
    public $title="";
    public $author="";
    public $genre="";
    public $publication_year="";
     

    public function addBook(){
        $sql = "INSERT INTO book(title, author,genre,publication_year) VALUE(:title, :author, :genre, :publication_year)";
        $query = $this->connect()->prepare($sql);
        
        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":publication_year", $this->publication_year);

        return $query->execute();
    }

     public function viewBook($search="", $genre_filter=""){
     if (!empty($search) && !empty($genre_filter)) {
        $sql = "SELECT * FROM book WHERE title LIKE CONCAT('%', :search, '%') AND genre = :genre ORDER BY title ASC";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":search", $search);
        $query->bindParam(":genre", $genre_filter);

        } elseif (!empty($search)) {
        $sql = "SELECT * FROM book WHERE title LIKE CONCAT('%', :search, '%') ORDER BY title ASC";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":search", $search);

        } elseif (!empty($genre_filter)) {
        $sql = "SELECT * FROM book WHERE genre = :genre ORDER BY title ASC";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":genre", $genre_filter);

        } else {
        $sql = "SELECT * FROM book ORDER BY title ASC";
        $query = $this->connect()->prepare($sql);
        }

        if ($query->execute()) {
        return $query->fetchAll();
        } else {
        return null;
        }
    }

    public function isBookExist($btitle){
        $sql = "SELECT COUNT(*) as total FROM book WHERE title = :title AND id =:id";
        $query= $this->connect()->prepare($sql);
        $query->bindParam(":title", $btitle);
        $query->bindParam(":id", $id);
        $record = null;
        if($query->execute()){
            $record = $query->fetch();
        }

        if($record["total"] > 0){
            return true;
        }else{
            return false;
        }
    }

    public function fetchBook($bid){
        $sql = "SELECT * FROM book WHERE id=:id";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":id", $bid);

        if ($query->execute()) {
            return $query->fetch();
        } else {
            return null;
        }

    }

    public function editBook($bid){
        $sql = "UPDATE book SET title=:title, author=:author, genre=:genre, publication_year=:publication_year WHERE id=:id";
        $query = $this->connect()->prepare($sql);

        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":publication_year", $this->publication_year);
        $query->bindParam(":id", $bid);

        return $query->execute();
    }

    public function deleteBook($bid){
        $sql = "DELETE FROM book WHERE id=:id";
        $query = $this->connect()->prepare($sql);

        $query->bindParam(":id", $bid);
        
        return $query->execute();
    }

    

}


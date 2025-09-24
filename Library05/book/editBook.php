<?php

require_once "../classes/library.php";
$bookObj = new Book();
 
$errors=[];

$search = "";
$genre_filter ="";
if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET["id"])){
        $bid = trim(htmlspecialchars($_GET["id"]));
        $book = $bookObj->fetchBook($bid);
        if(!$book){
            echo "<a href='viewbook.php'> View Book </a>";
            exit ("Book");
        } 
    } else {
        echo "<a href='viewbook.php'> View Book </a>";
        exit ("Book");
    }


} elseif($_SERVER["REQUEST_METHOD"] == "POST"){
    $book["title"] = trim(htmlspecialchars($_POST["title"]));
    $book["author"] = trim(htmlspecialchars($_POST["author"]));
    $book["genre"] = trim(htmlspecialchars($_POST["genre"]));
    $book["publication_year"] = trim(htmlspecialchars($_POST["publication_year"]));

      if(empty($book["title"])){
        $errors["title"] = "Book name is required";
      }else if($bookObj->isBookExist($book["title"])){
        $errors["title"] = "Title already exist";
      }
      
      if(empty($book["author"])){
        $errors["author"] = "author name is required";
      }

      if(empty($book["genre"])){
        $errors["genre"] = "genre required";
      }

      if(empty($book["publication_year"])){
        $errors["publication_year"] = "publication year is required";
      }

      else if($book["publication_year"] > 2025){
        $errors["publication_year"] = "publication year cant be in the future";

      }
      
      if(empty(array_filter($errors))){
        $bookObj->title = $book["title"];
        $bookObj->author = $book["author"];
        $bookObj->genre = $book["genre"];
        $bookObj->publication_year = $book["publication_year"];

        if($bookObj->editBook($_GET["id"])){
            header("Location: viewbook.php");
        }
        else{
            echo "failed";
        }
      }
      


}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>

    <style>
        .error{
            color:red;
        }
    </style>
</head>
<body>
    <h1>Edit Book</h1>
    <form action="" method="post">
    <label for="title">Book name </label>
    <input type="text" name="title" id="title" value="<?= $book["title"] ?? ""?>">
    <p class="error"><?= $errors["title"] ?? ""?></p>

    <label for="author">Author name</label>
    <input type="text" name="author" id="" value="<?= $book["author"] ?? "" ?>">
    <p class="error"><?= $errors["author"] ?? "" ?></p>

    <label for="genre">Genre</label>
    <select name="genre" id="genre">
        <option value="">--Select Genre</option>
        <option value="History" <?= (isset($book["genre"]) && $book["genre"] == "History")? "selected":""?>>History</option>
        <option value="Science" <?= (isset($book["genre"]) && $book["genre"] == "Science")? "selected":""?>>Science</option>
        <option value="Fiction" <?= (isset($book["genre"]) && $book["genre"] == "Fiction")? "selected":""?>>Fiction</option>
    </select>
    <p class="error"><?= $errors["genre"] ?? ""?></p>


    <label for="publication_year">Publicaiton year</label>

    <input type="number" name="publication_year" id="publication_year" value="<?= $book["publication_year"] ?? "" ?>">
    <p class="error"><?= $errors["publication_year"] ?? "" ?></p>
    
    <input type="submit" value="Save Book">
   </form>
</body>
</html>
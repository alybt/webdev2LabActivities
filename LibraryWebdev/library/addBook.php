<?php

    require_once "../classes/book.php";
    $bookObj = new Book();

    $book = ["title"=>"", "author"=>"", "genre"=>"", "publication_year"=>""];
    $errors = ["title"=>"", "author"=>"", "genre"=>"", "publication_year"=>""];


    if ($_SERVER["REQUEST_METHOD"]=="POST"){
        $book["title"] = trim(htmlspecialchars($_POST["title"]));
        $book["author"] = trim(htmlspecialchars($_POST["author"]));
        $book["genre"] = trim(htmlspecialchars($_POST["genre"]));
        $book["publication_year"] = trim(htmlspecialchars($_POST["publication_year"]));
    
        if(empty($book["title"])){
            $errors["title"]="*Title is required";
        } else {$errors["title"]="";}
        
        if(empty($book["author"])){
            $errors["author"]="* Author is required";
        } else {$errors["author"]="";}
        
        if(empty($book["genre"])){
            $errors["genre"]="* Genre is required";
        } 
        
        if(empty($book["publication_year"])){
            $errors["publication_year"]="Publication Year is required";
        }

        if($book["publication_year"]>2025){
            $errors["publication_year"]="It cannot written in the future";
        }
        
        if (!array_filter($errors)){
            $bookObj->title = $book["title"];
            $bookObj->author = $book["author"];
            $bookObj->genre = $book["genre"];
            $bookObj->publication_year = $book["publication_year"];
            
            if ($bookObj->addBook()){
                header("Location: viewBook.php");
                exit;
            } else {echo "failed";}
        
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
</head>
<body>
    <form action="addBook.php" method="POST">
        <label for="title">Title</label>
    <input type="text" required name="title" id="title" value ="<?= $book["title"] ?? '' ?>">
    <span class="error"> <?= $errors["title"] ?> </span>
    <br><br>

    <label for="author">Author: </label>
    <input type="text" required name="author" id="author" value = "<?= $book["author"]?>">
    <span class="error"> <?= $errors["author"]?></span>
    <br><br>

    <label for="genre">Genre</label>
    <select name="genre" id="genre">
        <option value="">-- SELECT OPTION --</option>
        <option value="history" <?= ($book["genre"] == 'history') ? 'selected' : '' ?>>History</option>
        <option value="science" <?= ($book["genre"] == 'science') ? 'selected' : '' ?>>Science</option>
        <option value="fiction" <?= ($book["genre"] == 'fiction') ? 'selected' : '' ?>>Fiction</option>
    </select>
    <span><?= $errors["genre"] ?></span>
    <br><br>

    <label for="publication_year">Publication Year</label>
    <input type="number" required name="publication_year" id="publication_year" value ="<?= $book["publication_year"]?>">
    <span><?= $errors["publication_year"]?></span>
    <br><br>

    <input type="submit" value="Save Book">
    </form>
</body>
</html>
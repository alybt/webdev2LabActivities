<?php
require_once "../classes/book.php"; 
$bookObj = new Book();


$search = "";
$genre = "";


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $search = isset($_GET["search"]) ? trim(htmlentities($_GET["search"])) : "";
    $genre = isset($_GET["genre"]) ? trim(htmlentities($_GET["genre"])) : "";
}


$genres = $bookObj->getGenre();
var_dump($genres);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Book</title>
    <link rel="stylesheet" href="">
</head>
<body>
    <h1>List of Books</h1>
    <form action="" method="get">
        <label for=""> Search: </label>
        <input type="search" name="search" id="search" value="<?= $search?>">
        
       <label for="genre">Genre:</label>
        <select name="genre" id="genre">
            <option value="">-- All Genres --</option>
            <?php foreach ($genres as $g){ $g = trim($g) ?>
                <option value="<?= htmlspecialchars($g) ?>" <?= $genre === $g ? 'selected' : '' ?>>
                    <?= htmlspecialchars($g) ?>
                </option>
        <?php }?>

        <input type="submit" value="Search">
        
    </form>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Genre</th>
                <th>Publication Year</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $no = 1;
            foreach($bookObj->viewBook($search, $genre) as $book){
        ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($book["title"]) ?></td>
                        <td><?= htmlspecialchars($book["author"]) ?></td>
                        <td><?= htmlspecialchars($book["genre"]) ?></td>
                        <td><?= htmlspecialchars($book["publication_year"]) ?></td>
                    </tr>
        <?php
                }
        
        ?>
        </tbody>
    </table>
</body>
</html>

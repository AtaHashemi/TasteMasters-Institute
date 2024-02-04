<?php

/*******w******** 
    
    Name: Amir Ata Hashemi Nazemi
    Date: 2023-12-28
  

****************/

require('connect.php');
$query = "SELECT * 
            FROM mypages ORDER BY timee DESC";

$statement=$db->prepare($query);
$statement->execute();
$pages=$statement->fetchAll();

if (isset($_GET['keyword'])) {
    $keyword = '%' . filter_input(INPUT_GET, 'keyword', FILTER_SANITIZE_STRING) . '%' ;

    $query = "SELECT * 
              FROM mypages 
              WHERE title LIKE :keyword 
              ORDER BY timee DESC";

    $statement = $db->prepare($query);
    $statement->bindParam(':keyword', $keyword, PDO::PARAM_STR);
    $statement->execute();
    $searchResults = $statement->fetchAll();
} else {
    $searchResults = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Search Box</title>
</head>

<body>
<nav class="navbar1">
        <ul>
            <li id="firstitem">
                <a href="index.php">TasteMasters Institute</a>
            </li>
            <li id="seconditem">
                <form action="search.php" method="GET" class="searchbox">
                    <input id="searchinput" type="text" name="keyword" placeholder="Search by keyword">
                    <button id="searchbutton" type="submit">Search</button>
                </form>
            </li>
            <li id="thirditem"><a href="admin.php">Admin</a></li>
        </ul>
    </nav>
    <nav class="navbar2">
    <h4>List of our workshops:</h4>
        <ul>
            <?php foreach($pages as $page):?>
            <li>
                <a href="pages.php?id=<?=$page['id']?>"> <?= $page['title'] ?></a>
            </li>
            <?php endforeach?>
        </ul>
    </nav>
    <main>
        <div class="main">
            <ul>
                <?php foreach ($searchResults as $result): ?>

                <?php if (!empty($result['image_filename'])): ?>
                <img src="<?= $result['new_image_path'] ?>" alt="Uploaded Image">
                <?php endif ?>
                <h2><?= $result['title'] ?></h2>
                <p class="edit"><?= date("F d, Y, h:i a", strtotime($result['timee'])) ?> </p>
                <p><?= $result['content'] ?></p>
                <h3>Instructor Information:</h3>
                <p><?= $result['name'] ?></p>


                <?php endforeach ?>
            </ul>
        </div>
      
    </main>
</body>

</html>
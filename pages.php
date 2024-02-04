<?php

/*******w******** 
    
    Name: Amir Ata Hashemi Nazemi
    Date: 2023-12-28
  

****************/

require('connect.php');
// $query = "SELECT p.*, c.* 
//             FROM mypages p
//             JOIN comment c ON p.comment_id = c.comment_id";
// $query = "SELECT * 
//             FROM mypages ORDER BY timee DESC";
$query = "SELECT * 
            FROM mypages ORDER BY timee DESC";

$statement=$db->prepare($query);
$statement->execute();
$pages=$statement->fetchAll();

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM mypages WHERE id = :id";
    // $query = "SELECT p.*, c.* 
    //         FROM mypages p
    //         JOIN comment c ON p.comment_id = c.comment_id
    //         WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $p = $statement->fetch();
} else {
    $id = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Ingredient</title>
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

                <?php if ($id): ?>
                <?php if (!empty($p['image_filename'])): ?>
                <img src="<?= $p['new_image_path'] ?>" alt="Uploaded Image">
                <?php endif ?>
                <h2><?= $p['title'] ?></h2>
                <p class="edit"><?= date("F d, Y, h:i a", strtotime($p['timee'])) ?> </p>
                <p><?= $p['content'] ?></p>
                <h3>Instructor Information:</h3>
                <p><?= $p['name'] ?></p>


                <?php endif ?>
            </ul>
        </div>
        <!-- <div class="comment">
            <h3>Your Comment:</h3>
            <p><?= $p['comment'] ?></p>
        </div> -->
    </main>
</body>

</html>
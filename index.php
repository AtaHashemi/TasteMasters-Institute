<?php

/*******w******** 
    
    Name: Amir Ata Hashemi Nazemi
    Date: 2023-12-28
  

****************/

require('connect.php');
// $query = "SELECT p.*, i.* 
//             FROM mypages p
//             JOIN myinstructors i ON p.instructor_id = i.instructor_id";
$query = "SELECT * 
            FROM mypages ORDER BY timee DESC";

$statement=$db->prepare($query);
$statement->execute();
$pages=$statement->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>TasteMaster Institute!</title>
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
            <h1 class="header">On our website, you can find all the ingredients needed for the related workshop.</h1>
            <h3 class="header">Before attending the workshop, please ensure that you have all the necessary ingredients
                from our website.</h3>

        </div>
    </main>
</body>

</html>
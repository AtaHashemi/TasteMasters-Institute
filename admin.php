<?php

/*******w******** 
    
    Name: Amir Ata Hashemi Nazemi
    Date: 2023-12-28
  

****************/

require('connect.php');
require('authenticate.php');
// $query = "SELECT p.*, i.* 
//             FROM mypages p
//             JOIN myinstructors i ON p.instructor_id = i.instructor_id";
$query = "SELECT * FROM mypages ORDER BY timee DESC";

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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var bodyElement = document.body;
            bodyElement.innerHTML = bodyElement.innerHTML.replace(/&nbsp;/g, '');
        });
    </script>
    <title>Admin Page</title>
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
            <ul class="administration">
                <li>
                    <h1 class="header">Page Administration</h1>
                </li>
                <li><a href="control.php">Create a new page</a></li>
            </ul>


            <?php foreach($pages as $page):?>
            <ul class="delete">
                <li>
                    <a href="control.php?id=<?=$page['id']?>"> <?= $page['title'] ?></a>
                </li>
                <li class="adminpagetime"><?= $page['timee'] ?></li>
                <li>
                    <div>
                        <form action="control.php" method="post">
                            <input type="submit" name="delete" value="Delete">
                            <input type="hidden" name="id" value="<?= $page['id'] ?>">
                        </form>

                    </div>
                </li>
            </ul>
            <?php endforeach?>


        </div>
    </main>
</body>
</html>
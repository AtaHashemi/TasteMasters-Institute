<?php

/*******w******** 
    
    Name: Amir Ata Hashemi Nazemi
    Date: 2023-12-30
   

****************/

require('connect.php');
require('authenticate.php');
require 'vendor/autoload.php';
$query = "SELECT * 
            FROM mypages ORDER BY timee DESC";

$statement=$db->prepare($query);
$statement->execute();
$pages=$statement->fetchAll();

// image  *******************************************************************
function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
    $path_segments = [$upload_subfolder_name, basename($original_filename)];
    return join(DIRECTORY_SEPARATOR, $path_segments);
 }
 
 function file_is_an_image($temporary_path, $new_path) {
     $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
     $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
     
     $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
     $actual_mime_type        = getimagesize($temporary_path)['mime'];
     
     $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
     $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
     
     return $file_extension_is_valid && $mime_type_is_valid;
 }
 
 $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
 $upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);

 if ($image_upload_detected) { 
     $image_filename        = $_FILES['image']['name'];
     $temporary_image_path  = $_FILES['image']['tmp_name'];
     $new_image_path        = file_upload_path($image_filename);

     $image = new \Gumlet\ImageResize($temporary_image_path);
     $image->resizeToWidth(300); 
     $image->save($new_image_path);
     if (file_is_an_image($temporary_image_path, $new_image_path)) {
        move_uploaded_file($resized_medium_path, $resized_medium_path);

         if (isset($_POST['id'])) {
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
         $sql = "UPDATE mypages SET image_filename = :image_filename, new_image_path = :new_image_path WHERE id = :id";
         $statement = $db->prepare($sql);
   
         $statement->bindValue(':image_filename', $image_filename);
         $statement->bindValue(':new_image_path', $new_image_path);
         $statement->bindValue(':id', $id, PDO::PARAM_INT);
         $statement->execute();}
     }
 }

$e=false;
// for Updating *******************************************************************
if ($_POST && isset($_POST['content']) && isset($_POST['title']) && isset($_POST['id'])&& !empty($_POST['title']) && !empty($_POST['content'])) {
    $title  = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id      = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
   $name= filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = "UPDATE mypages SET title = :title, content = :content, name=:name WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':title', $title);        
    $statement->bindValue(':content', $content);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->bindValue(':name',$name);
    $statement->execute();
    header("Location: control.php?id=$id");
}
// for Deleting  *******************************************************************
if  (isset($_POST['delete']) ) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    
        $query = "SELECT * FROM mypages WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $page = $statement->fetch();
    
        // Remove from uploads folder
        if (!empty($page['new_image_path']) && file_exists($page['new_image_path'])) {
            unlink($page['new_image_path']);
        }
        // updating database after removing the image
        $query = "UPDATE mypages SET image_filename = NULL, new_image_path = NULL WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

    $query = "DELETE FROM mypages WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    if($statement->execute()){
        header("Location: admin.php");
    }}

// for Deleting image *******************************************************************
if (isset($_POST['remove_image']) && isset($_POST['id'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM mypages WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $page = $statement->fetch();

    // Remove from uploads folder
    if (!empty($page['new_image_path']) && file_exists($page['new_image_path'])) {
        unlink($page['new_image_path']);
    }
    // updating database after removing the image
    $query = "UPDATE mypages SET image_filename = NULL, new_image_path = NULL WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    // Redirect
    header("Location: admin.php");
    exit;
}

// For editing  *******************************************************************
  if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    // $query = "SELECT p.*, c.* 
    //         FROM mypages p
    //         JOIN comment c ON p.comment_id = c.comment_id
    //         WHERE id = :id";
    $query = "SELECT * FROM mypages WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $p = $statement->fetch();
} 
// for posting a new page  *******************************************************************
else {
    $id=false;
        if ($_POST && !empty($_POST['title']) && !empty($_POST['content'])) {

            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $image_filename = '';
            $new_image_path = '';
            if ($image_upload_detected) {
                $image_filename = $_FILES['image']['name'];
                $temporary_image_path = $_FILES['image']['tmp_name'];
                $new_image_path = file_upload_path($image_filename);
                if (file_is_an_image($temporary_image_path, $new_image_path)) {
                    move_uploaded_file($temporary_image_path, $new_image_path);
                }
            }
            $query="INSERT INTO mypages (title, content, name,image_filename,new_image_path) VALUES (:title,:content,:name,:image_filename,:new_image_path)";
            $statement=$db->prepare($query);
            $statement->bindValue(':title',$title);
            $statement->bindValue(':content',$content);
            $statement->bindValue(':name',$name);
            $statement->bindValue(':image_filename', $image_filename);
            $statement->bindValue(':new_image_path', $new_image_path);
            if($statement->execute()){
                header("Location:index.php");
                exit;
            }
        }   
    }
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
    <!-- WYSIWYG -->
   


    <title>Admin Control</title>
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
    <div class="main">
        <?php if ($id): ?>
        <!-- for editing and deleting  *******************************************************************-->
        <?php if (!empty($p['image_filename'])): ?>
        <img src="<?= $p['new_image_path'] ?>" alt="Uploaded Image">
        <?php endif ?>


        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $p['id'] ?>">
            <label for="title">Title</label><br>
            <input id="title" name="title" value="<?= $p['title'] ?>"><br>
            <label for="content">Ingredients:</label><br>
            <textarea id="content" name="content" rows="4" cols="50"><?= $p['content'] ?></textarea><br>

            <label for="name">Instructor:</label><br>
            <input id="name" name="name" value="<?= $p['name'] ?>"><br>
            <label for="image">Image Filename:</label><br>
            <input type="file" name="image" id="image">

            <?php if (!empty($p['image_filename'])): ?>
            <p>Current Image: <?= $p['image_filename'] ?></p>
            <input type="submit" name="remove_image" value="Remove Image">
            <?php endif ?>


            <?php if (isset($_FILES['image']) && $_FILES['image']['error'] > 0): ?>
            <p>Error Number: <?= $_FILES['image']['error'] ?></p>
            <?php elseif (isset($_FILES['image'])): ?>
            <?php print_r($_FILES['image'])?>
            <p>Client-Side Filename: <?= $_FILES['image']['name'] ?></p>
            <p>Apparent Mime Type: <?= $_FILES['image']['type'] ?></p>
            <p>Size in Bytes: <?= $_FILES['image']['size'] ?></p>
            <p>Temporary Path: <?= $_FILES['image']['tmp_name'] ?></p>
            <?php endif ?>

            <input type="submit" name="update" value="Update">
            <?php else:?>


        </form>
        <!-- for posting a new page  ******************************************************************* -->

        <?php if ($id && !empty($p['image_filename'])): ?>
        <?= $p['new_image_path']; ?>
        <img src="<?= $p['new_image_path'] ?>" alt="Uploaded Image">
        <?php endif ?>

        <form method="post" enctype="multipart/form-data">
            <label for="title">Title</label><br>
            <input type="text" id="title" name="title"><br>
            <label for="content">Ingredients:</label><br>
            <textarea id="content" name="content" rows="4" cols="50"></textarea><br>

            <label for="name">Instructor:</label><br>
            <input id="name" type="text" name="name"><br>
            <label for="image">Image Filename:</label><br>
            <input type="file" name="image" id="image">
            <input type="submit" name="submit" value="create">

            <?php if (isset($_FILES['image']) && $_FILES['image']['error'] > 0): ?>
            <p>Error Number: <?= $_FILES['image']['error'] ?></p>
            <?php elseif (isset($_FILES['image'])): ?>
            <p>Client-Side Filename: <?= $_FILES['image']['name'] ?></p>
            <p>Apparent Mime Type: <?= $_FILES['image']['type'] ?></p>
            <p>Size in Bytes: <?= $_FILES['image']['size'] ?></p>
            <p>Temporary Path: <?= $_FILES['image']['tmp_name'] ?></p>
            <?php endif ?>
        </form>
        <?php endif ?>
    </div>
    
</body>

</html>
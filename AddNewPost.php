<?php require_once './includes/db.php';
require_once './includes/fucntion.php';
require_once './includes/sessions.php';
require_once 'dateTime.php';

$_SESSION["trackengURL"] = $_SERVER['PHP_SELF'];
confirm_login();

if (isset($_POST['submit'])) {
    $postTitle = $_POST['PostTitle'];
    $category = $_POST['Category'];
    $image = $_FILES['image']['name'];
    $postText = $_POST['postDesc'];
    $target = "./upload/".basename($_FILES['image']['name']);
    $admin = $_SESSION['user_name'];

    if (empty($postTitle)) {
        $_SESSION['ErrorMassage'] = 'Title cant be empty';
        redirect("AddNewPost.php");
    } else if (strlen($postTitle) < 5) {
        $_SESSION['ErrorMassage'] = 'Too short post title sorry! retard';
        redirect("AddNewPost.php");
    } else if (strlen($postTitle) > 49) {
        $_SESSION['ErrorMassage'] = 'Too big title common fc retard!11';
        redirect("AddNewPost.php");
    } else if (strlen($postText) > 9999) {
        $_SESSION['ErrorMassage'] = 'Too big post cant upload on pager!11';
        redirect("AddNewPost.php");
    } else {
        // Добавление поста в бд!
        $sql = "INSERT INTO posts(datetime, title, author, category, image, post)";
        $sql .= "VALUES(:data, :title, :author, :category, :image, :post)";
        $stmt = $connecting->prepare($sql);
        $stmt->bindValue(':data', $datatime);
        $stmt->bindValue(':title', $postTitle);
        $stmt->bindValue(':author', $admin);
        $stmt->bindValue(':category', $category);
        $stmt->bindValue(':image', $image);
        $stmt->bindValue(':post', $postText);
        $execute = $stmt->execute();
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        if ($execute) {
            $_SESSION['SuccessMassage'] = "Post with id: " . $connecting->lastInsertId() . " Added";
            redirect("AddNewPost.php"); 
        } else {
            $_SESSION['ErrorMassage'] = 'Something wrong. Try !';
            redirect("AddNewPost.php");
        }
    }
}


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <title>AddNewPost</title>
  </head>
  <body>
    <div style="height: 10px; background: #27aae1;"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand">IgorBackEndBezSMS</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbarcollapseCMS">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="MyProfile.php" class="nav-link">
                        <i class="fas fa-user text-success"></i>My Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a href="Dashboard.php" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="Posts.php" class="nav-link">Posts</a>
                </li>
                <li class="nav-item">
                    <a href="Categories.php" class="nav-link">Categories</a>
                </li>
                <li class="nav-item">
                    <a href="Admins.php" class="nav-link">Manage Admins</a>
                </li>
                <li class="nav-item">
                    <a href="Comments.php" class="nav-link">Comments</a>
                </li>
                <li class="nav-item">
                    <a href="Blog.php?page=1" class="nav-link">Live Blog</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-danger" href="Logout.php"> <i class="fas fa-user-times"></i> Logout</a>
                </li>
            </ul>
        </div>
        </div>
    </nav>
    <div style="height: 10px; background: #27aae1;"></div>

    <header class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                <h1> <i class="fas fa-edit" style="color: skyblue;"></i> Add New Post</h1>
                </div>
            </div>
        </div>
    </header>

    <!-- Main area -->

    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-lg-1 col-lg-10">
            <?php echo error_massage(); echo success_massage();?>
                <form action="AddNewPost.php" method="post" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light">
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="PostTitle"><span class="fieldinfo"> Post Title: </span></label>
                                <input class="form-control" type="text" name="PostTitle" id="title">
                            </div>
                            <div class="form-group">
                                <label for="CategoryTitle"><span class="fieldinfo"> Chose Title: </span></label>
                                <select class="from-control" name="Category" id="CategoryTitle">
                                    <?php 
                                    // получение всех категорий
                                    $sql = "SELECT id, title FROM category";
                                    $stmt = $connecting->query($sql);
                                    ?>
                                    <?php while ($rows = $stmt->fetch()):?>
                                    <?php 
                                    $id = $rows['id'];
                                    $category_name = $rows['title'];
                                    ?>
                                    <option><?php echo $category_name; ?></option>
                                    <?php endwhile;?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="imageSelect"><span class="fieldinfo">Select Image</span></label>
                                <input type="file" name="image" id="imageSelect"> 
                            </div>
                            <div class="form-group">
                                <label for="post"><span class="fieldinfo">Post :</span></label>
                                <textarea class="form-control" name="postDesc" id="post" cols="30" rows="10"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Dashboard.php" class="btn btn-warning btn-block">
                                        <i class="fas fa-arrow-left"></i>
                                        Back to Dashboard
                                    </a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                   <button type='submit' name="submit" class="btn btn-success btn-block">
                                   <i class="fas fa-check"></i>
                                   Publish
                                   </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Main area END-->


    <?php require_once 'footer.php';?>
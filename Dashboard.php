<?php 
require_once './includes/db.php';
require_once './includes/fucntion.php';
require_once './includes/sessions.php';
require_once 'dateTime.php';

$_SESSION["trackengURL"] = $_SERVER['PHP_SELF']; // трек
confirm_login();

if (isset($_POST['submit'])) {
    $image = $_FILES['image']['name'];
    $postText = $_POST['postDesc'];
    $target = "./images/".basename($_FILES['image']['name']);
    $admin = $_SESSION['user_name'];

    if (strlen($postText) > 999) {
        $_SESSION['ErrorMassage'] = 'Too big post cant upload on pager!11';
        redirect("Dashboard.php");
    } else {
        // Добавление поста в бд!
        $sql = "INSERT INTO sidebar(addedby, simage, stext)";
        $sql .= "VALUES(:author, :simage, :stext)";
        $stmt = $connecting->prepare($sql);
        $stmt->bindValue(':author', $admin);
        $stmt->bindValue(':simage', $image);
        $stmt->bindValue(':stext', $postText);
        $execute = $stmt->execute();
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        if ($execute) {
            $_SESSION['SuccessMassage'] = "Sidebar content added";
            redirect("Dashboard.php"); 
        } else {
            $_SESSION['ErrorMassage'] = 'Something wrong. Try !';
            redirect("Dashboard.php");
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
    <title>Dashboard</title>
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
                <h1> <i class="fas fa-cog" style="color: skyblue;"></i> Dashboard</h1>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="AddNewPost.php" class="btn-primary btn btn-block">
                        <i class="fas fa-edit"></i>
                        Add new Post
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Categories.php" class="btn-info btn btn-block">
                        <i class="fas fa-folder-plus"></i>
                        Add new Category
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Admins.php" class="btn-warning btn btn-block">
                        <i class="fas fa-user-plus"></i>
                        Add new Admin
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Comments.php" class="btn-success btn btn-block">
                        <i class="fas fa-check"></i>
                        Aprowe Comments
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main area -->

    <section class="container py-2 mb-4">
    <?php 
        echo error_massage(); 
        echo success_massage();
        ?>
        <div class="row">
  
            <div class="col-lg-2">
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">
                            Posts
                        </h1>
                        <h4 class="display-5">
                            <i class="fab fa-readme"></i>
                            <?php 
                            echo returned_counts_elements_DB('posts');
                            ?>
                        </h4>
                    </div>
                </div>

                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">
                            Categories
                        </h1>
                        <h4 class="display-5">
                            <i class="fas fa-folder"></i>
                            <?php 
                            echo returned_counts_elements_DB('category');
                            ?>
                        </h4>
                    </div>
                </div>

                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">
                            Admins
                        </h1>
                        <h4 class="display-5">
                            <i class="fas fa-users"></i>
                            <?php 
                            echo returned_counts_elements_DB('Admins');
                            ?>
                        </h4>
                    </div>
                </div>

                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">
                            Comments
                        </h1>
                        <h4 class="display-5">
                            <i class="fas fa-comments"></i>
                            <?php 
                            echo returned_counts_elements_DB('comments');
                            ?>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-10">
                <h1>Top Posts</h1>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Date&Time</th>
                            <th>Author</th>
                            <th>Comments</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <?php 
                    global $connecting;
                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                    $stmt = $connecting->query($sql);
                    $count = 0;
                    while($row = $stmt->fetch()): ?>
                    <?php    
                        $postID = $row['id'];
                        $datetime = $row['datetime'];
                        $author = $row['author'];
                        $post_title = $row['title'];
                        $count++;
                    ?>
                    <tbody>
                        <tr>
                            <td><?php echo htmlentities($count); ?></td>
                            <td><?php echo htmlentities($post_title); ?></td>
                            <td><?php echo htmlentities($datetime); ?></td>
                            <td><?php echo htmlentities($author); ?></td>
                            <td>
                                <?php
                                    $total = approve_comments_acording_to_post($postID, 'ON');  
                                    if ($total > 0):?>
                                    <span class="badge badge-success"><?php echo $total;?></span>
                                    <?php endif;?>
                                <?php 
                                    $total_un = approve_comments_acording_to_post($postID, 'OFF');
                                    if ($total_un > 0):?>
                                    <span class="badge badge-danger"><?php echo $total_un;?></span>
                                    <?php endif;?>
                            </td>
                            <td><a href="FullPost.php?id=<?php echo $postID;?>" target="_blank"><span class="btn btn-info">Preview</span></a></td>
                        </tr>
                    </tbody>
                    <?php endwhile;?>
                </table>

                <form action="Dashboard.php" method="post" enctype="multipart/form-data">
                    <?php 
                    global $connecting;
                    $sql = "SELECT * FROM sidebar";
                    $stmt = $connecting->query($sql);
                    while ($row = $stmt->fetch()) {
                        $sidebar_image = $row['simage'];
                        $sidebar_text = $row['stext'];
                        $sidebar_id = $row['id'];
                    }
                    $sql2 = "DELETE FROM sidebar WHERE id < $sidebar_id";
                    $stmt2 = $connecting->query($sql2);
                    ?>
                    <div class="card bg-secondary text-light">
                    <div class="card-header">
                    <h2>Sidebar Content</h2>
                    </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <span class="fieldinfo">Existing Image: </span>
                                <img src="./images/<?php echo $sidebar_image; ?>" width="170px;" alt="post-image"><br><br>
                                <label for="imageSelect"><span class="fieldinfo">Select Image</span></label>
                                <input type="file" name="image" id="imageSelect"> 
                            </div>
                            <div class="form-group">
                                <label for="post"><span class="fieldinfo">Post :</span></label>
                                <textarea class="form-control" name="postDesc" id="post" cols="30" rows="10">
                                    <?php echo $sidebar_text; ?>
                                </textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                   <button type='submit' name="submit" class="btn btn-success btn-block">
                                   <i class="fas fa-check"></i>
                                   Publish
                                   </button>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </section>

    <!-- Main area END-->

    <?php require_once 'footer.php';?>
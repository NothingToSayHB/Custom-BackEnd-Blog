<?php 
require_once './includes/db.php';
require_once './includes/fucntion.php';
require_once './includes/sessions.php';
require_once 'dateTime.php';
?>
<?php 
$_SESSION["trackengURL"] = $_SERVER['PHP_SELF']; // трек
confirm_login(); ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <title>Post</title>
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
                <h1> <i class="fas fa-blog" style="color: skyblue;"></i> Blog Posts</h1>
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
        <div class="row">
            <div class="col-lg-12">
            <?php 
            echo error_massage(); 
            echo success_massage();
            ?>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Data&time</th>
                        <th>Author</th>
                        <th>Banner</th>
                        <th>Comments</th>
                        <th>Action</th>
                        <th>Live Preview</th>
                    </tr>
                    </thead>
                    <?php 
                        global $connecting;
                        $sql = "SELECT * FROM posts";
                        $stmt = $connecting->query($sql);
                        $count = 0;
                        while ($row = $stmt->fetch()) {
                            $id = $row['id'];
                            $dataTime = $row['datetime'];
                            $postTitle = $row['title'];
                            $categoryPost = $row['category'];
                            $admin = $row['author'];
                            $image = $row['image'];
                            $postText = $row['post'];
                            $count++;
                    ?>
                    <tbody>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td class="table-danger">
                            <?php if (strlen($postTitle) > 20) {
                                $postTitle = substr($postTitle, 0, 15) . "..";
                                }
                         echo $postTitle;?>
                        </td>
                        <td><?php if (strlen($categoryPost) > 10) {
                            $categoryPost = substr($categoryPost, 0, 10) . '..';
                        }
                         echo $categoryPost; 
                         ?></td>
                        <td><?php if (strlen($dataTime) > 12) {
                            $dataTime = substr($dataTime, 0, 12) . '..';
                        } 
                        echo $dataTime; 
                        ?></td>
                        <td><?php if (strlen($admin) > 6) {
                            $admin = substr($admin, 0, 6);
                        }
                         echo $admin; 
                         ?></td>
                        <td>
                            <img class="post-image" src="./upload/<?php echo $image; ?>" width="170px" alt="post-image"> 
                        </td>
                        <td>
                            <?php
                            $total = approve_comments_acording_to_post($id, 'ON');
                            if ($total > 0):
                            ?>
                            <span class="badge badge-success">
                                <?php echo $total;?>
                            </span>
                            <?php endif;?>
                            <?php 
                            $total_un = approve_comments_acording_to_post($id, 'OFF');
                            if ($total_un > 0):
                            ?>                        
                            <span class="badge badge-danger">
                                <?php echo $total_un;?>
                            </span>
                            <?php endif;?>
                        </td>
                        <td>
                            <a href="EditPost.php?id=<?php echo $id;?>"><span class="btn btn-warning">Edit</span></a>
                            <a href="DeletePost.php?id=<?php echo $id;?>"><span class="btn btn-danger">Delete</span></a>
                        </td>
                        <td><a href="FullPost.php?id=<?php echo $id;?>" target="_blank"><span class="btn btn-primary">Live priview</span></td>
                    </tr>
                    </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>
    </section>

    <!-- Main area END-->

    <?php require_once 'footer.php';?>
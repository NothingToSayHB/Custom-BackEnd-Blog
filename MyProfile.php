<?php require_once './includes/db.php';
require_once './includes/fucntion.php';
require_once './includes/sessions.php';
require_once 'dateTime.php';

$_SESSION["trackengURL"] = $_SERVER['PHP_SELF'];
confirm_login();

// текущий админ
$adminID = $_SESSION['user_id'];

global $connecting;
$sql = "SELECT * FROM Admins WHERE id = '$adminID'";
$stmt = $connecting->query($sql);
while ($row = $stmt->fetch()) {
    $existing_name = $row['aname'];
    $existing_username = $row['username'];
    $existing_headline = $row['aheadline'];
    $existing_bio = $row['abio'];
    $existing_image = $row['aimage'];
}
// текущий админ END


if (isset($_POST['submit'])) {
    $aname = $_POST['name'];
    $aheadline = $_POST['headline'];
    $aBIO = $_POST['bio'];
    $image = $_FILES['image']['name'];
    $target = "./images/".basename($_FILES['image']['name']);
    if (strlen($aheadline) > 30) {
        $_SESSION['ErrorMassage'] = 'Headline shoot be less than 12 char';
        redirect("MyProfile.php");
    } else if (strlen($aBIO) > 500) {
        $_SESSION['ErrorMassage'] = 'Too big bio common fc retard!11';
        redirect("MyProfile.php");
    } else {
        if (!empty($_FILES["image"]["name"])) {
            $sql = "UPDATE Admins 
                    SET aname ='$aname', aheadline = '$aheadline', abio='$aBIO', aimage='$image'
                    WHERE id='$adminID'";
        } else {
            $sql = "UPDATE Admins 
                    SET aname ='$aname', aheadline = '$aheadline', abio='$aBIO'
                    WHERE id='$adminID'";
        }

        $execute = $connecting->query($sql);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);

        if ($execute) {
            $_SESSION['SuccessMassage'] = "Updated !1!1!!";
            redirect("MyProfile.php"); 
        } else {
            $_SESSION['ErrorMassage'] = 'Something wrong. Try !';
            redirect("MyProfile.php");
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
    <title>My Pfofile</title>
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
                <h1><i class="fas fa-user mr-2 text-success" style="color: skyblue;"></i>&commat;<?php echo htmlentities($existing_username);?></h1>
                <small>
                    <?php echo htmlentities($existing_headline); ?>
                </small>
                </div>
            </div>
        </div>
    </header>

    <!-- Main area -->

    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h3><?php echo (empty($existing_name)) ? $existing_username : $existing_name;?></h3>
                    </div>
                    <div class="card-body">
                       <img class="img-fluid d-block m-auto" src="./images/<?php echo $existing_image;?>" alt="admin-iamge" width="100%;">
                        <div class="">
                            <?php echo htmlentities($existing_bio); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
            <?php echo error_massage(); echo success_massage();?>
                <form action="MyProfile.php" method="post" enctype="multipart/form-data">
                    <div class="card bg-dark bg-secondary text-light">
                        <div class="card-header bg-secondary text-light">
                            <h4>Edit Profile</h4>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                              <input class="form-control" type="text" name="name" id="title" placeholder="Name">
                            </div>
                            <div class="form-group">
                              <input class="form-control" placeholder="Headline" type="text" name="headline" id="title">
                              <small class="muted">Add proffesional headline</small>
                              <span class="text-danger">Not more then 30 chars</span>
                            </div>
                            <div class="form-group">
                                <textarea placeholder="Bio" class="form-control" name="bio" id="post" cols="30" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="imageSelect"><span class="fieldinfo">Select Image</span></label>
                                <input type="file" name="image" id="imageSelect"> 
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
<?php 
require_once './includes/db.php';
require_once './includes/fucntion.php';
require_once './includes/sessions.php';
require_once 'dateTime.php';

$_SESSION["trackengURL"] = $_SERVER['PHP_SELF'];
confirm_login();

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmpasswrord'];
    $admin = $_SESSION['user_name'];
  
    // var_dump($username);
    // var_dump($name);
    // var_dump($password);
    // var_dump($confirm_password);
    // var_dump($admin);

    if (empty($username) || empty($password) || empty($confirm_password)) {
        $_SESSION['ErrorMassage'] = 'All fiels must be no empty';
        redirect("Admins.php");
    } else if (strlen($password) < 4 || strlen($password) > 49) {
        $_SESSION['ErrorMassage'] = 'unvalided password';
        redirect("Admins.php");
    } else if ($password !== $confirm_password) {
        $_SESSION['ErrorMassage'] = 'passwordu dolwni butb odinakoviue ALO';
        redirect("Admins.php");
    } else if (Check_userName_exists_or_not($username)) {
        $_SESSION['ErrorMassage'] = "Etoto username uwe zan9t poprobui \"retard\" esli i on zan9t ... kill urself";
        redirect("Admins.php");
    } else {
        global $connecting;
        $sql = "INSERT INTO Admins(datetime, username, password, addedby, aname) 
                VALUES(:data, :username, :passwrord, :adminName, :aname)";
        $stmt = $connecting->prepare($sql);
        $stmt->bindValue(':data', $datatime);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':passwrord', $password);
        $stmt->bindValue(':aname', $name);
        $stmt->bindValue(':adminName', $admin);
        $execute = $stmt->execute();
        
        if ($execute) {
            $_SESSION['SuccessMassage'] = "New admin is already in DB name for new Retard - $name";
            redirect("Admins.php"); 
        } else {
            //var_dump($execute);
            $_SESSION['ErrorMassage'] = 'Something wrong. Try More!';
            redirect("Admins.php");
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
    <title>Admin Page</title>
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
                <h1> <i class="fas fa-user" style="color: skyblue;"></i> Manage Admins</h1>
                </div>
            </div>
        </div>
    </header>

    <!-- Main area -->

    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-lg-1 col-lg-10">
                <?php echo error_massage(); echo success_massage();?>
                <form action="Admins.php" method="post">
                    <div class="card bg-secondary text-light">
                        <div class="card-header">
                            <h1>Add new Admin</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="username"><span class="fieldinfo"> Username: </span></label>
                                <input class="form-control" type="text" name="username" id="username">
                            </div>
                            <div class="form-group">
                                <label for="name"><span class="fieldinfo"> Name: </span></label>
                                <input class="form-control" type="text" name="name" id="name">
                                <small class="text-muted">*Optional</small>
                            </div>
                            <div class="form-group">
                                <label for="password"><span class="fieldinfo"> Password: </span></label>
                                <input class="form-control" type="password" name="password" id="passwrod">
                            </div>
                            <div class="form-group">
                                <label for="confirmpasswrord"><span class="fieldinfo"> Confirm Password: </span></label>
                                <input class="form-control" type="password" name="confirmpasswrord" id="confirmpasswrord">
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
                <h1>Existing Admins</h1>
                <hr>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Date&Time</th>
                            <th>Username</th>
                            <th>Admin name</th>
                            <th>Edded by</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                
                <?php 
                global $connecting;
                $sql = "SELECT * FROM Admins ORDER BY id desc";
                $execute = $connecting->query($sql);
                $count = 0;
                while($row = $execute->fetch()):?> 
                <?php
                    $adminID = $row['id'];
                    $create_date = $row['datetime'];
                    $admin_username = $row['username'];
                    $admin_name = $row['aname'];
                    $edded_by = $row['addedby'];
                    $count++;
                    if (strlen($commenter_name) > 10) {
                        $commenter_name = substr($commenter_name, 0, 10) . '..';
                    }
                ?>
                    <tbody>
                        <tr>
                            <td><?php echo htmlentities($count);?></td>
                            <td><?php echo htmlentities($create_date);?></td>
                            <td><?php echo htmlentities($admin_username);?></td>
                            <td><?php echo (empty(htmlentities($admin_name))) ? "NoName" : htmlentities($admin_name);?></td>
                            <td><?php echo htmlentities($edded_by)?></td>
                            <td><a class="btn btn-danger" href="DeleteAdmin.php?id=<?php echo $adminID;?>">Delete</a></td>
                        </tr>
                    </tbody>
                <?php endwhile;?>
                </table>
            </div>
        </div>
    </section>

    <!-- Main area END-->


    <?php require_once 'footer.php';?>
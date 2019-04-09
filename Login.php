<?php
require_once './includes/db.php';
require_once './includes/fucntion.php';
require_once './includes/sessions.php';
require_once 'dateTime.php';

if (isset($_SESSION['user_id'])) {
    redirect("Dashboard.php");
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (empty($username) || empty($password)) {
        $_SESSION['ErrorMassage'] = "All feilds wiil no empty";
        redirect("Login.php");
    } else {
       $fount_account = login_poputka($username, $password);
       if ($fount_account) {
           $_SESSION['user_id'] = $fount_account["id"];
           $_SESSION['user_name'] = $fount_account["username"];
           $_SESSION['admin_name'] = $fount_account["aname"];
           $_SESSION['SuccessMassage'] = "Welcome Admin " .  $_SESSION['user_name'];
           if (isset($_SESSION["trackengURL"])) {
               redirect($_SESSION["trackengURL"]);
           } else {
               redirect("Dashboard.php");
           }
       } else {
           $_SESSION['ErrorMassage'] = "Incorect data";
           redirect("Login.php");
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
    <title>Login</title>
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
        </div>
        </div>
    </nav>
    <div style="height: 10px; background: #27aae1;"></div>

    <header class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                <h1></h1>
                </div>
            </div>
        </div>
    </header>

    <!-- Main area -->

    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-sm-3 col-sm-6" style="min-height: 500px">
            <?php 
                echo error_massage(); 
                echo success_massage();?>
            <br><br><br>
                <div class="card bg-secondary text-light">
                    <div class="card-header">
                        <h4>Welcome Back!</h4>
                        </div>
                        <div class="card-body bg-dark">
                        <form action="Login.php" method="post">
                            <div class="form-group">
                                <label for="username"><span class="fieldinfo">Username:</span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password"><span class="fieldinfo">Password:</span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>
                            <input type="submit" name="submit" class="btn btn-info btn-block" value="Login">
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main area END-->


    <?php require_once 'footer.php';?>
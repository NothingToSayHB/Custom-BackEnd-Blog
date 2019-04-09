<?php
require_once './includes/db.php';
require_once './includes/fucntion.php';
require_once './includes/sessions.php';
require_once 'dateTime.php';

$search_query_parametr = $_GET['username'];

global $connecting;
$sql = "SELECT aname, abio, aheadline, aimage 
        FROM Admins WHERE username = :username";
$stmt = $connecting->prepare($sql);
$stmt->bindValue(':username', $search_query_parametr);
$stmt->execute();

$res = $stmt->rowcount();
if ($res == 1) {
    while ($row = $stmt->fetch()) {
        $existing_name = $row['aname'];
        $existing_bio = $row['abio'];
        $existing_image = $row['aimage'];
        $existing_headline = $row['aheadline'];
    }
} else {
    $_SESSION['ErrorMassage'] = "Bad Request";
    redirect('Blog.php?page=1');
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
    <title>Profile</title>
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
                    <a href="Blog.php?page=1" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">About Us</a>
                </li>
                <li class="nav-item">
                    <a href="Blog.php?page=1" class="nav-link">Blog</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Futures</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
            <form class="form-inline" action="Blog.php">
                <div class="form-group">
                <input class="form-control mr-2" type="text" name="search" placeholder="search">
                <button name="searchButton" class="btn btn-primary">Go</button>
                </div>
            </form>
            </ul>
        </div>
        </div>
    </nav>
    <div style="height: 10px; background: #27aae1;"></div>

    <header class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                <h1> <i class="fas fa-user text-success" style="color: skyblue;"></i><?php echo htmlentities($existing_name); ?></h1>
                <h3><?php echo htmlentities($existing_headline); ?></h3>
                </div>
            </div>
        </div>
    </header>

    <!-- Main area -->

    <section class="container py-2 mb-4 mt-4">
        <div class="row">
            <div class="col-lg-3">
                <img src="./images/<?php echo $existing_image; ?>" class="d-block m-auto img-fluid rounded-circle" alt="img">
            </div>
            <div class="col-lg-9" style="min-height: 350px;">
                <div class="card">
                    <div class="card-body">
                        <p class="lead"><?php echo htmlentities($existing_bio); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main area END-->


    <?php require_once 'footer.php';?>
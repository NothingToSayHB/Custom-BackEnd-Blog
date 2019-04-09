<?php
require_once './includes/db.php';

function redirect($new_location) {
    header("Location:".$new_location);
    die;
}
function redirect_with_delay($new_location, $time = 2) {
    header("refresh:".$time."url=".$new_location);
    die;
}
function Check_userName_exists_or_not(string $name) {
    global $connecting;
    $sql = "SELECT username FROM Admins WHERE username = :name";
    $stmt = $connecting->prepare($sql);
    $stmt->bindValue(":name", $name);
    $stmt->execute();
    $result = $stmt->rowcount();
    if ($result == 1) {
        return true;
    } else {
        return false;
    }
}

function login_poputka($username, $password) {
    global $connecting;
    $sql = "SELECT * FROM Admins WHERE username=:userName AND password=:passWord LIMIT 1";
    $stmt = $connecting->prepare($sql);
    $stmt->bindValue(":userName", $username);
    $stmt->bindValue(":passWord", $password);
    $stmt->execute();
    $result = $stmt->rowcount();
    if ($result == 1) {
        return $fount_account = $stmt->fetch();
    } else {
        return null;
    }
}

function confirm_login() {
    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        $_SESSION['ErrorMassage'] = "Nelzya potomywo eto tolko dlya geniusov i maxima (hes retard)";
        redirect("Login.php");
    }
}

function returned_counts_elements_DB(string $str):string {
    global $connecting;
    $sql = "SELECT COUNT(*) FROM $str";
    $stmt = $connecting->query($sql);
    $total_rows = $stmt->fetch();
    $total_posts = array_shift($total_rows);
    return $total_posts;
}

function approve_comments_acording_to_post(string $postID, string $mode):string {
    global $connecting;
    $sql_approve = "SELECT COUNT(*) FROM comments WHERE post_id = '$postID' AND status='$mode'";
    $stmt_approve = $connecting->query($sql_approve);
    $rows_total = $stmt_approve->fetch();
    return $total = array_shift($rows_total);
}

function page_title() {
    $correct_link = $_SERVER['REQUEST_URI'];
    $new_title = stristr($correct_link, '.', true);
    $trimmed = trim($new_title, "/");
    return $trimmed;
}

function admin_title_header() {
    switch(page_title()) {
        case page_title() == "Categories":
        return "<h1><i class='fas fa-edit' style='color: skyblue;'></i> Manage Categories</h1>";
        break;
        case page_title() == "Admins":
        return "<h1> <i class='fas fa-user' style='color: skyblue;'></i> Manage Admins</h1>";
        break;
        case page_title() == "Comments":
        return "<h1> <i class='fas fa-comments' style='color: skyblue;'></i> Manage Comments</h1>";
        break;
        default: 
        return null;
    }
}
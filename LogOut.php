<?php 
require_once './includes/fucntion.php';
require_once './includes/sessions.php';
?>
<?php

$_SESSION['user_id'] = null;
$_SESSION['user_name'] = null;
$_SESSION['admin_name'] = null;
session_destroy();
redirect("Login.php");
?>
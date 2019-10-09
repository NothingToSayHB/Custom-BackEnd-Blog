<?php


session_start();


function error_massage() {
    if (isset($_SESSION['ErrorMassage'])) {
        $out = "<div class=\"alert alert-danger\">";
        $out .= htmlentities($_SESSION["ErrorMassage"]); 
        $out .= "</div>";
        $_SESSION['ErrorMassage'] = null; 
        return $out;
    }
}

function success_massage() {
    if (isset($_SESSION['SuccessMassage'])) {
        $out = "<div class=\"alert alert-success\">";
        $out .= htmlentities($_SESSION["SuccessMassage"]); 
        $out .= "</div>";
        $_SESSION['SuccessMassage'] = null; 
        return $out;
    }
}

<?php

/*Файл где стартует сессия*/

session_start();

//ф-я сообщение об ошибке
function error_massage() {
    if (isset($_SESSION['ErrorMassage'])) {
        $out = "<div class=\"alert alert-danger\">";
        $out .= htmlentities($_SESSION["ErrorMassage"]); // htmlentities преобразует все символы в сущности хтмл
        $out .= "</div>";
        $_SESSION['ErrorMassage'] = null; // очищаем сессию чтобы при перезаргрузке не оставалось сообщение
        return $out;
    }
}

//ф-я сообщение об успешном действии
function success_massage() {
    if (isset($_SESSION['SuccessMassage'])) {
        $out = "<div class=\"alert alert-success\">";
        $out .= htmlentities($_SESSION["SuccessMassage"]); 
        $out .= "</div>";
        $_SESSION['SuccessMassage'] = null; 
        return $out;
    }
}
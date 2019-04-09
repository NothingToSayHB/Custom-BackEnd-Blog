<?php
date_default_timezone_set('Europe/Kiev');

$time = time();
$datatime = strftime('%B-%d-%Y %H:%M:%S', $time); // % для того чтобы оно записывалось в базу без них не будет
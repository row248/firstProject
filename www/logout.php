<?php

error_reporting(-1);
session_start();

require '../hide/config.php';

if ( isset($_SESSION) ) {
    unset($_SESSION['login']);
    unset($_SESSION['right']);
}

if ( isset($_COOKIE) ) {
    setcookie('login', '', time()-3600);
    setcookie('right', '', time()-3600);
}

header("Location: index.php");
?>
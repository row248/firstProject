<?php

error_reporting(-1);

function getAccessRights() {
    if ( isset($_SESSION['right']) && $_SESSION['right'] === ACCESS_ADMIN ) {
        if ( $_SERVER['PHP_SELF'] !== "/messages.php" ) { 
            return true;
        }
    }
}


//nav
function drawBar() {

    if ( $_SERVER['PHP_SELF'] !== "/index.php" ) {
        $links['index.php'] = 'На главную'; //'<li><a class="back" href="index.php">На главную</a></li>'
    }

    if ( $_SERVER['PHP_SELF'] == "/index.php" ) {
        $links['form-msg.php'] = 'Заполнить форму'; //'<li><a href="form-msg.php">Заполнить форму</a></li>'
    }

    if ( getAccessRights() ) { // Are you admin?
        $links['messages.php'] = 'Посмотреть сообщения';
    } 

    return $links;
}


//nav pull-right
function drawRightBar() {

    if ( isset($_SESSION['login']) ) {
        $links['index.php'] = "Привет, <strong>" . $_SESSION['login'] . "</strong>";
        $links['logout.php'] = 'Выйти';

    } else {

        if ( $_SERVER['PHP_SELF'] !== '/register.php') {
            $links['register.php'] = 'Зарегистрироваться';
        }

        if ( $_SERVER['PHP_SELF'] !== '/login.php') {
            $links['login.php'] = 'Войти';

        }
    }

    return $links;
}

$navLinks = array();
$otherLinks = array();

$navLinks = drawBar();
$otherLinks = drawRightBar();

require 'templates/nav-menu.phtml';



<?php

error_reporting(-1);

function makeNavBar($links) {
echo '<div class="navbar">';
    echo '<div class="navbar-inner">';
        echo '<ul class="nav">';
            foreach ( $links as $value ) {
            echo "$value";
            }
        echo '</ul>';

        if ( isset($_SESSION['login']) ) {
            echo '<ul class="nav pull-right">';
            echo '<li><a href="index.php">Привет, ' . '<strong>' . $_SESSION['login'] . '</strong>' . '</a></li>';
            echo '<li><a href="logout.php">Выйти</a></li>';
            echo '</ul>';
        } else {
            echo '<ul class="nav pull-right">';
            if ( $_SERVER['PHP_SELF'] !== "/register.php" ) {
                echo '<li><a href="register.php">Зарегистрироваться?</a></li>';
            }
            if ( $_SERVER['PHP_SELF'] !== "/login.php" ) {
                echo '<li><a href="login.php">Войти</a></li>';
            }
            echo '</ul>';
        }

    echo '</div>';
echo '</div>';
}


function getAccessRights() {
    if ( isset($_SESSION['right']) && $_SESSION['right'] === ACCESS_ADMIN ) {
        if ( $_SERVER['PHP_SELF'] !== "/messages.php" ) {
            $links = '<li><a href="messages.php">Посмотреть сообщения</a></li>';
            return $links;
        }
    }
}

function drawNavBar() {

    if ( $_SERVER['PHP_SELF'] !== "/index.php" ) {
        $links[] = '<li><a class="back" href="index.php">На главную</a></li>';
    }

    if ( $_SERVER['PHP_SELF'] == "/index.php" ) {
        $links[] = '<li><a href="form-msg.php">Заполнить форму</a></li>';
    }

    $links[] = getAccessRights(); // Are you admin?
    makeNavBar($links);
}

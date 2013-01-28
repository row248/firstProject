<?php
error_reporting(-1);

session_start();

require '../hide/config.php';
require 'nav-menu.php';
require 'includes/functions.php';

$error = '';

/**** CSRF *****/

getToken(); 

/**** CSRF ****/

if ( isset($_POST['submit']) && checkTokens($_POST['csrf_token']) ) {

    isset($_POST['login']) ? $login = trim($_POST['login']) : $login = '';
    $password = $_POST['password'];
    $password = md5($password);

    try{
        $dbh = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
        $sth = $dbh->prepare(" SELECT `login`, `password`, `right` FROM `users` WHERE `login` = ? AND `password` = ? ");
        $sth->bindParam(1, $login);
        $sth->bindParam(2, $password);

        if ( $sth->execute() ) {

            $row = $sth->fetch(PDO::FETCH_ASSOC);

            if ( $row ) {

                $_SESSION['login'] = $row['login'];
                setcookie('login', $row['login'], time() +  7 * 24 * 60 * 60); 

                if ( $row['right'] === ACCESS_ADMIN ) {
                    $_SESSION['right'] = $row['right']; 
                    setcookie('right', $row['right'], time() +  7 * 24 * 60 * 60); // Cookie is dangerous for right like ACCESS_ADMIN?
                }

                header("Location: index.php");

            } else {
                $error = "Неверный логин или парль";
            }
        }
        

    } catch(PDOException $e) {
        echo "<h2>Если ты адмни, то почини сайт. Он не работает!</h2>";

        recordError($e);
    }

} else {

    $login = '';
}

require 'templates/login.phtml';
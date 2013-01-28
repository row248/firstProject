<?php

error_reporting(-1);

require '../hide/config.php';
require 'nav-menu.php';
require 'includes/functions.php';

session_start();

/**** CSRF *****/

getToken(); 

/**** CSRF ****/

$deleteMsg = "";

if ( isset($_GET['notify']) && $_GET['notify'] == 'delete' ) {
    $deleteMsg = "Сообщение успешно удалено!";
}

if ( isset($_SESSION['right']) && $_SESSION['right'] === ACCESS_ADMIN ) {

    try {
        $dbh = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
        $sth = $dbh->query('SELECT * FROM `form` ');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "<h2>Возникла тех. неполадка, зайдите на сайт позже</h2>";
        recordError($e);
        exit();
    }

    if ( isset($_POST['delete']) && checkTokens($_POST['csrf_token']) ) {
        $id = $_POST['id'];

        try {
            $sth = $dbh->prepare(" DELETE from `form` WHERE id = ? LIMIT 1");
            $sth->bindParam(1, $id);
            $sth->execute();

            header("Location: messages.php?notify=delete");
        } catch (PDOException $e) {
            echo "<h2>Возникла тех. неполадка, зайдите на сайт позже</h2>";
            recordError($e);
            exit();
        }
    }

} else {
    header("Location: index.php");
    exit();
}

require 'templates/messages.phtml';
<?php
error_reporting(-1);
session_start();

require_once '../hide/config.php';
require_once 'includes/functions.php';
require_once 'nav-menu.php';

$login = 'anonym'; // Select all logins but only not it

try {
$dbh = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
$sth = $dbh->prepare('SELECT * FROM `form` WHERE login != ? ORDER BY id DESC LIMIT 5  ');
$sth->bindParam(1, $login);
$sth->execute();
$sth->setFetchMode(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "<h2>Возникла тех. неполадка, зайдите на сайт позже</h2>";
    recordError($e);
}

require 'templates/main.phtml';
require 'footer.php';
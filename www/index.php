<?php
error_reporting(-1);

require_once '../hide/config.php';
require_once 'includes/functions.php';
require_once 'nav-menu.php';

session_start();

try {
$dbh = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
$sth = $dbh->query('SELECT * FROM `form` WHERE login IS NOT NULL ');
$sth->setFetchMode(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    recordError($e);
}

require 'templates/main.phtml';
require 'footer.php';
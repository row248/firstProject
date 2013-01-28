<?php
error_reporting(-1);

require_once '../hide/config.php';
require_once 'includes/functions.php';

try {
$dbh = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
$sth = $dbh->prepare('SELECT COUNT(*) FROM `users` ');
$sth->execute();
} catch(PDOException $e) {
    recordError($e);
}

// count users in db
$count = $sth->fetchColumn();

require 'templates/footer.phtml';



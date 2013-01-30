<?php

$dbHost = 'localhost';
$dbName = 'cobaka';
$dbUser = 'root';
$dbPassword = '';

if (!defined('ACCESS_ADMIN')) define('ACCESS_ADMIN', 'admin');
if (!defined('ACCESS_USER')) define('ACCESS_USER', 'user');

/*** Where save logs ***/

if ($_SERVER['HTTP_HOST'] === "scenario.leehoan.com") {
    define('PATH', '/home/scenar/domains/scenario.leehoan.com/logs/');
} else {
    define('PATH', 'Z:/home/home/logs/');
}
    


?>
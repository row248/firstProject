<?php
header('Content-Type: text/html; charset=utf-8');

error_reporting(-1);

session_start();

require_once '../hide/config.php';
require_once 'nav-menu.php';
require_once 'includes/functions.php';

/**** CSRF *****/

//getToken(); Я наверно запутался. Здесь это незачем вызывать же? Получается это лишний вызов. Достаточно в шаблоке в скрытом поле вызвать эту фунцию

/**** CSRF ****/

/* Errors */
$nameError = '';
$emailError = '';
$messageError = '';
$phoneError = '';
$csrfError = '';

$loginName = "Вы не вошли в систему";

if ( isset($_SESSION['login']) ) {
    $loginName = "Вы вошли в систему, как " . $_SESSION['login'];
    $login = $_SESSION['login'];
} else {
    $login = 'anonym';
}

/* Variables */
isset($_POST['name'])   ? $name    = trim($_POST['name'])   :    $name = '';
isset($_POST['email'])  ? $email   = trim($_POST['email'])  :   $email = '';
isset($_POST['message'])? $message = trim($_POST['message']): $message = '';
isset($_POST['phone'])  ? $phone   = trim($_POST['phone'])  :   $phone = '';
isset($_POST['link'])   ? $link    = trim($_POST['link'])   :    $link = '';


if ( isset($_POST['submit']) && checkTokens($_POST['csrf_token']) ) {

    if ( empty($email) ) {
        $emailError = "Введите емаил";
    }

    if ( empty($message) ) {
        $messageError = "Введите сообщение";
    }

    if ( !empty($email) && !empty($message) ) {
     
        $errorMsg = array(); // Массив будующих ошибок

        if ( !empty($name) ) {

            if ( !preg_match('!^[а-яА-Я]+$!u', $name) ) {
                $nameError = "Некорректное имя";
            }
        }
        
        if ( !empty($phone) ) {

            if ( !preg_match('!^[0-9()-\\s+]+$!u', $phone) ) {
                $phoneError = "Некорректный тел.";
            }
        }

        if ( !preg_match('!^[\\w\\+\\.\\-]+@([a-zA-Z\\d\\-]+\\.[\\da-zA-Z]+\\.?)+$!', $email) ) {
     
            $emailError = "Некорректный емаил";
        }



        if ( empty($phoneError) && empty($emailError) && empty($nameError) ) {
     
        try {
            $dbh = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
     
            $sth = $dbh->prepare("INSERT INTO `form` (`name`, `email`, `message`, `phones`, `links`, `login`) VALUES (?, ?, ?, ?, ?, ?) ");
            $sth->bindParam(1, $name);
            $sth->bindParam(2, $email);
            $sth->bindParam(3, $message);
            $sth->bindParam(4, $phone);
            $sth->bindParam(5, $link);
            $sth->bindParam(6, $login);
     
            $sth->execute();
            } catch(PDOException $e) {
                echo "<h2>Возникла тех. неполадка, зайдите на сайт позже</h2>";

                recordError($e);
                exit();

            }
                header("Location: templates/success.phtml");
                exit();
        }

    }   

} elseif ( isset($_POST['submit']) && !checkTokens($_POST['csrf_token']) ) {
    $csrfError = 'Вы превысили время ожидания ввода формы, пожалуйста заполните её еще раз';
}

require 'templates/form-msg.phtml';

<?php

/*** Where save logs ***/

if ($_SERVER['HTTP_HOST'] === "scenario.leehoan.com") {
    define('LOG_WAY', '/home/scenar/domains/scenario.leehoan.com/logs/');
} else {
    define('LOG_WAY', 'Z:/home/home/logs/');
}
    

function recordError($error) {
    $time = date("F-j-Y-H-i");
    file_put_contents(LOG_WAY . $time . '.txt', $error);
} 

/*****CSRF*****/

function getToken() {
    if ( !isset($_SESSION['request_token']) ) {
        return $_SESSION['request_token'] = md5( time() . mt_rand() . mt_rand() );
    } else {
        return $_SESSION['request_token'];
    }
}


function checkTokens($key) {
    if ( isset($_SESSION['request_token']) ) {
        $token = $_SESSION['request_token'];
        unset($_SESSION['request_token']);

        return $key === $token;

    } else {
        return false;
    }
}


/*****END CSRF*****/
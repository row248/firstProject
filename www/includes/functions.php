<?php

mb_internal_encoding('utf-8');

function recordError($error) {
    $time = date("F-j-Y-H-i");
    file_put_contents(PATH . $time . '.txt', $error);
} 

/*****CSRF*****/

function getToken() {
    //if ( !isset($_SESSION['request_token']) ) {
        return $_SESSION['request_token'] = md5( time() . mt_rand() . mt_rand() );
    //} else {
        //return $_SESSION['request_token'];
    //}
}


function checkTokens($key) {
    if ( isset($_SESSION['request_token']) ) {
        $token = $_SESSION['request_token'];
        //unset($_SESSION['request_token']);

        return $key === $token;

    } else {
        return false;
    }
}

/*****END CSRF*****/

/* Max messages length 400 symbols */
function cutText($text) {
    if ( mb_strlen($text) > 400 ) {
        $text  = mb_substr($text, 0, 400);
        $text .= '...';
    }

    return $text;
}

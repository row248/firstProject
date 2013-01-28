<?php

class RequestProtection {

    private $previous_hash;
    public $hash;

    function __construct() {

        if ( isset($_SESSION) ) {
            if ( isset($_SESSION['request_token']) ) {
                $this->previous_hash = $_SESSION['request_token'];
            }

            $this->hash = $_SESSION['request_token'] = md5( time() . mt_rand() . mt_rand() ); 
        }
    }

    // input hidden name must be "csrf_token"
    public function checkTokens($key = "csrf_token") {
        return (isset($_POST[$key]) && ($_POST[$key] === $this->previous_hash)) || 
                (isset($_GET[$key]) && ($_GET[$key]  === $this->previous_hash));
    }
}
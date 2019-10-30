<?php

require_once ('inc/class-api.php');

/**
 * Receive the login auth request and responded by specific class methods
 */

$API = new API;
header('Content-Type: application/json');
echo $API->login();

?>

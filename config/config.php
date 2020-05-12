<?php

session_start();

ini_set('display_errors', 1);

define('DSN', 'mysql:host=localhost;dbname=ordersystem');
define('DB_USERNAME', '524user');
define('DB_PASSWORD', '8fa28af6');

require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/autoload.php');
 ?>

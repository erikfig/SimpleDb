<?php

header('Content-type: text/html; charset=UTF-8');

date_default_timezone_set('America/Sao_Paulo');

define('ROOT', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);

include ROOT.DS.'vendor'.DS.'autoload.php';
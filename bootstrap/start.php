<?php

require __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../config/config.php';
require_once 'functions.php';
//function libraries_autoloader($class) {
//    require_once __DIR__.'/../src/' . $class . '.php';
//}
//spl_autoload_register('libraries_autoloader');

//$session = new Acme\Http\Session();
//$logged_in = new Acme\Auth\LoggedIn($session);
$router = new AltoRouter();
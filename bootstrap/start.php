<?php
session_start();

require __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../config/config.php';

function libraries_autoloader($class) {
    require_once __DIR__.'/../src/' . $class . '.php';
}
spl_autoload_register('libraries_autoloader');
<?php
require_once 'config/config.php';

function libraries_autoloader($class) {
    include 'libraries/' . $class . '.php';
}

spl_autoload_register('libraries_autoloader');
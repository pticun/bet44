<?php
ini_set('session.cookie_lifetime', 1800);
ini_set('session.gc_maxlifetime', 1800);

session_start();

require_once __DIR__ . '/../bootstrap/start.php';


//$_SESSION['test7'] = 'test';
//$sesh = print_r($_SESSION, false);
//setcookie("color","red");
//echo $_COOKIE["color"];
/*color is red*/
/* your codes and functions*/
//setcookie("dog","jack russell");
//echo $_COOKIE["color"];
///*new color is blue*/die;

require_once __DIR__ . '/../bootstrap/dependencies.php';
include __DIR__ . '/../routes.php';
$match = $router->match();
//var_dump($match);
// are we calling a controller?
if (is_string($match['target']))
    list($controller, $method) = explode('@', $match['target']);

if ((isset($controller) && isset($method)) && (is_callable(array($controller, $method)))) {
    // controller
//    $object = new $controller();
    $object = $injector->make($controller);
    call_user_func_array(array($object, $method), array($match['params']));
} else if ($match && is_callable($match['target'])) {
    // closure
    call_user_func_array($match['target'], $match['params']);
} else {
    // nothing matches
    echo "Cannot find $controller -> $method";
    exit();
}

var_dump($match['target']);
die;


<?php

// register routes
$router->map('GET', '/bets', 'Acme\Controllers\PageController@bets', 'bets');
$router->map('GET', '/', 'Acme\Controllers\PageController@getShowHomePage', 'home');
$router->map('GET', '/esrewrwer', 'Acme\Controllers\PageController@getShowHomePage', 'Test');
$router->map('GET', '/page-not-found', 'Acme\Controllers\PageController@getShow404', '404');

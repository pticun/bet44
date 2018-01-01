<?php

define('APP_PATH',  dirname(__DIR__));
define('CONFIG', dirname(__DIR__).'/config');
define('ODDSCHECKER', 'https://www.oddschecker.com');
define('LIVERPOOL', 'liverpool');
define('CITY', 'city');
define('UNITED', 'united');
define('CHELSEA', 'chelsea');
define('ARSENAL', 'arsenal');
define('BURNLEY', 'burnley');
define('SPURS', 'spurs');
define('LEICESTER', 'leicester');
define('EVERTON', 'everton');
define('WATFORD', 'watford');
define('HUDDERSFIELD', 'huddersfield');
define('SOUTHAMPTON', 'southampton');
define('BRIGHTON', 'brighton');
define('PALACE', 'palace');
define('WESTHAM', 'west_ham');
define('BOURNEMOUTH', 'bournemouth');
define('STOKE', 'stoke');
define('NEWCASTLE', 'newcastle');
define('WESTBROM', 'west_brom');
define('SWANSEA', 'swansea');

$bookmakers_name_formats = [
    'Oddschecker' => [
        'slug_format',
        'teams_formats'=>[
            ARSENAL => 'arsenal',
            LIVERPOOL => 'liverpool',
            EVERTON => 'everton',
            CHELSEA => 'chelsea',
            BRIGHTON => 'brighton',
            WATFORD => 'watford',
            BOURNEMOUTH => 'bournemouth',
            SOUTHAMPTON => 'southampton',
            HUDDERSFIELD => 'huddersfield',
            STOKE => 'stoke',
            SWANSEA => 'swansea',
            PALACE => 'crystal-palace',
            WESTHAM => 'west-ham',
            NEWCASTLE => 'newcastle',
            BURNLEY => 'burnley',
            SPURS => 'tottenham',
            LEICESTER => 'leicester',
            UNITED => 'man-utd',
            CITY => 'man-city'
        ]
    ]
];

define('BOOKMAKERS_NAME_FORMATS', $bookmakers_name_formats);

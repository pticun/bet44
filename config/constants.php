<?php

define('APP_PATH',  dirname(__DIR__));
define('CONFIG', dirname(__DIR__).'/config');
define('APP_JS_PATH',  '/assets/js/');

require_once 'names.php';

$teams = [
    'Oddschecker' => [
        'PremierLeague' => [
            'teams' => [
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
        ],
        'WorldCup' => [
            'slug_format' => 'football/world-cup/%s-v-%s/winner',
            'teams' => [
                RUSSIA => 'russia',
                SAUDIARABIA => 'saudi-arabia',
                AUSTRALIA => 'australia',
                FRANCE => 'france'

            ]
        ]
    ]
];

//$matches = [
////    ['stoke', 'newcastle'],
//    ['chelsea', 'leicester']
//];
//football/world-cup/russia-v-saudi-arabia/winner
$competitions = [
    'Oddschecker' => [
        'url' => 'https://www.oddschecker.com',
        'sports'=>[
            'Football' => [
//            'PremierLeague',
                'WorldCup'
            ]
        ]
    ]
];

define('TEAMS', $teams);
//define('MATCHES', $matches);
define('COMPETITIONS', $competitions);

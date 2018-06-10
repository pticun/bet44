<?php


namespace Acme\Models;


interface SiteScraper
{
    function formatOdds();
    function setBetRows($crawler);
    function setBookmakers();
    function setEventDate();
    function getProperties();
    function exec();
    static function eventExists($team_name_1, $team_name_2, $client);
    function getResults();

    static function urlFormatter($team, $opponent);
}
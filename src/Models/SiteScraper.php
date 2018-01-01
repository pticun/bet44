<?php


namespace Acme\Models;


interface SiteScraper
{
    function formatOdds();
    function setBetRows();
    function setBookmakers();
    function setEventDate();
    function getProperties();
    function exec();
    function eventExists();
    function getResults();

    static function urlSlugFormatter($team, $opponent);
}
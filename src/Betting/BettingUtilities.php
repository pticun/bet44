<?php


namespace Acme\Betting;


abstract class BettingUtilities
{
    public function dateFormatter($date)
    {
        return date('Y-m-d', strtotime($date));
    }
}
<?php

namespace Acme\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Acme\Betting\Arbitrage;
use Acme\Betting\BetsCorrelator;
use Goutte\Client;


class Arbs
{

    public function get($odds)
    {
        $correlator = new BetsCorrelator($odds, new Arbitrage());
        $correlator->exec();
        $results = $correlator->getResults();
        return $results;
    }
}
<?php

namespace Acme\Betting;

use Acme\Models\SiteScraper;

class BetsCorrelator
{
    protected $oddsModel;
    protected $arbitrage_opportunities;
    protected $arbitrage;

    public function __construct(SiteScraper $oddsModel, Arbitrage $arbitrage = null)
    {
        $this->oddsModel = $oddsModel;
        if ($arbitrage !== null)
            $this->arbitrage = $arbitrage;
    }

    public function addBets()
    {

    }

    /**
     * @return mixed
     */
    public function getArbitrageOpportunities()
    {
        return $this->arbitrage_opportunities;
    }
}
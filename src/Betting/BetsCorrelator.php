<?php

namespace Acme\Betting;

class BetsCorrelator
{
    protected $odds;
    protected $row_length;
    protected $number_of_rows;
    protected $arbitrage_opportunities;
    protected $arbitrage;
    protected $counter;
    protected $results = [];
    protected $stopper = 0;

    public function __construct($odds, Arbitrage $arbitrage = null)
    {
        $this->odds = $odds;
        $this->row_length = count($odds[0]);
        $this->number_of_rows = count($odds);

        $this->counter = [];
        for ($i = 0; $i < $this->number_of_rows; $i++) {
            $this->counter[] = 0;
        }

        if ($arbitrage !== null)
            $this->arbitrage = $arbitrage;
    }

    public function exec()
    {
        $this->iterateMe();
    }

    public function getResults()
    {
        return $this->results;
    }

    public function iterateMe()
    {//dd($this->number_of_rows) = 3;
        $this->counter[0] = 0;
        for ($i = 0; $i < $this->row_length; $i++) {
            $result = [];
            $cells = [];
            for ($ii = 0; $ii < $this->number_of_rows; $ii++) {
                $odds = $this->odds[$ii][$this->counter[$ii]]['odds'];
                $result[] = $odds;
                $cells[] = $this->odds[$ii][$this->counter[$ii]];
            }
//dd($result);
            $arb = new Arbitrage($result);
            $arb->setArbParams();
            if ($arb->arb()) {
                $this->results[] = ['odds'=>$cells, 'market_total'=>$arb->getMarketTotal()];
            }

            if ($this->isEnd())
                return;

            $this->counter[0]++;
        }

        $this->iterate(1);
        $this->iterateMe();
    }

    function iterate($index)
    {
        if ($this->counter[$index] === $this->row_length - 1) {
            if (isset($this->counter[$index + 1])) {
                $this->counter[$index] = 0;
                $this->iterate($index + 1);
            }
        } else {
            $this->counter[$index]++;
        }
    }

    protected function isEnd()
    {
        $end = true;
        foreach ($this->counter as $c) {
            if ($c < ($this->row_length - 1))
                $end = false;
        }
        if ($end) {
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getArbitrageOpportunities()
    {
        return $this->arbitrage_opportunities;
    }
}
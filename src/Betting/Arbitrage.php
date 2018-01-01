<?php

namespace Acme\Betting;
use Acme\Betting\Converter;
use Acme\Exceptions\CustomExceptions;

class Arbitrage
{
    protected $results = ['bets' => []];
    protected $market_total;
    protected $total_betting_amount;
    protected $converter;

    public function __construct($decimal_odds = null, Converter $converter = null)
    {
        if ($decimal_odds !== null) {
            foreach ($decimal_odds as $decimal_odd) {
                if(!is_float($decimal_odd))
                    throw new CustomExceptions('Odds in constructor must be decimal format. Use setDecimalOddsFromFractions() 
                instead.');
                $this->results['bets'][] = ['decimal_odds' => $decimal_odd];
            }
        }

        if($converter !== null)
            $this->converter = $converter;
    }

    public function setDecimalOddsFromFractions($fractions)
    {
        foreach ($fractions as $fraction){
            $decimal = $this->converter::fractionToDecimal($fraction);
            $decimal_odds = $this->converter::decimalToDecimalOdds($decimal);
            $this->results['bets'][] = ['decimal_odds' => $decimal_odds];
        }
    }

    public function exec()
    {
        foreach ($this->results['bets'] as &$result) {
            $result['percentage_of_total_bet'] = $this->calculatePercentageOfTotalBet($result['implied_odds'], $this->market_total);
            $result['amount_to_bet'] = $this->calculateAmountToBet($this->total_betting_amount, $result['percentage_of_total_bet']);
            $result['total_return'] = $this->calculateTotalReturn($result['amount_to_bet'], $result['decimal_odds']);
            $result['profit'] = $this->calculateProfit($result['total_return'], $this->total_betting_amount);
        }

        $this->results['total_betting_amount'] = $this->total_betting_amount;
        return $this->results;
    }

    public function unitTestTest()
    {
        $results = [];
        for($i=0; $i<3; $i++){
            $fraction = $this->converter->getAFraction();
            $enumerator_and_denominator = explode('/', $fraction);
            $results[] = round($enumerator_and_denominator[1] / ($enumerator_and_denominator[0] + $enumerator_and_denominator[1]), 2);
        }

        return $results;
    }

    public function setArbParams()
    {
        $all_implied_odds = [];
        foreach ($this->results['bets'] as &$bet){
            $decimal_odds[] = $bet['decimal_odds'];
            $implied_odds = $this->impliedOdds($bet['decimal_odds']);
            $all_implied_odds[] = $implied_odds;
            $bet['implied_odds'] = $implied_odds;
        }

        $this->market_total = $this->marketTotal($all_implied_odds);
        $this->results['market_total'] = $this->market_total;
    }

    public function impliedOdds($decimal_odds) : float
    {
        return self::decimalOddsToImpliedOdds($decimal_odds);
    }

    public function marketTotal($implied_odds) : float
    {
        $market_total = 0;
        foreach ($implied_odds as $implied_odd) {
            $market_total += $implied_odd;
        }

        $market_total = round($market_total, 2);
        return $market_total;
    }

    public function setTotalBettingAmount($total_betting_amount)
    {
        $this->total_betting_amount = $total_betting_amount;
    }

    public function arb() : bool
    {
        return $this->market_total < 100;
    }

    public static function decimalOddsToImpliedOdds($decimal_odds) : float
    {
        return round(100 * (1 / $decimal_odds), 2);
    }

    public function getResults()
    {
        return $this->results;
    }

    /**
     * @param float $amount_to_bet
     * @param float $decimal_odds
     * @return mixed
     */
    public function calculateTotalReturn($amount_to_bet, $decimal_odds) : float
    {
        return $amount_to_bet * $decimal_odds;
    }

    /**
     * @param $implied_odds
     * @param $market_total
     * @return float|int
     */
    public function calculatePercentageOfTotalBet($implied_odds, $market_total) : float
    {
        if(empty($implied_odds) || empty($market_total)){
            return false;
        }

        return round(($implied_odds / $market_total) * 100, 2);
    }

    /**
     * @param $total_betting_amount
     * @param $percentage_of_total_bet
     * @return mixed
     */
    public function calculateAmountToBet($total_betting_amount, $percentage_of_total_bet) : float
    {
        $amount_to_bet = round(($total_betting_amount / 100) * $percentage_of_total_bet, 2);
        return $amount_to_bet;
    }

    public function calculateProfit($total_return, $total_betting_amount) : float
    {
        return round(($total_return - $total_betting_amount), 2);
    }

}
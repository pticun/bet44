<?php


namespace Acme\Models;

use Acme\Betting\Arbitrage;
use Goutte;
use Acme\Betting\BettingUtilities;

class Oddschecker extends BettingUtilities implements SiteScraper
{
    protected $crawler;
    protected $arbitrage;
    protected $bookmakers;
    protected $event_date;
    protected $bet_rows;
    protected $results;
    protected $possible_results;
    protected $url = 'https://www.oddschecker.com/football/english/premier-league/%s/winner';

    public function __construct($url, Goutte\Client $client, Arbitrage $arbitrage = null)
    {
        $this->crawler = $client->request('GET', $url);
        if(isset($arbitrage))
            $this->arbitrage = $arbitrage;
    }

    public static function formatUrl($url, $slug)
    {

    }

    public static function urlFormatter($team_1, $team_2)
    {
        return sprintf('%s-v-%s', $team_1, $team_2);
    }

    public function exec()
    {
        $this->getProperties();
//                } echo '<pre>';print_r($all_odds);die;

//            $arbitrage_opportunities = array_merge($arbitrage_opportunities, $this->oddsModelCorrelation->getArbitrageOpportunities());

        // sorts results from web scrape into standardised format to be passed to BetsCorrelation

        $this->results = ['odds' => [], 'bookmakers'=>$this->bookmakers];
        $this->results['event_date'] = $this->dateFormatter($this->event_date);
        $ii=0;
        //125
        foreach ($this->bet_rows as $bet_row) {
//            if($ii === 2)
//                break;
            $row = [];
            for ($i = 0; $i < 5; $i++) {
                $odds = Arbitrage::validateFraction($bet_row['odds'][$i]);
                $result = ['odds' => Arbitrage::setDecimalOddsFromFractions($odds),
                    'bookmakers' => $this->bookmakers[$i], 'result'=>$bet_row['title'],
                    'fractional_odds' => $odds];
                $row[] = $result;
            }
            $this->results['odds'][] = $row;
            $ii++;
        }

    }

    public function getProperties()
    {
        $this->bet_rows = self::setBetRows();
        $this->setBookmakers();
        $this->setEventDate();
    }

    public function setBookmakers()
    {
        $this->bookmakers = $this->crawler->filter('.bookie-area > aside > a')->each(function ($node) {
            return $node->extract(array('title'))[0] ?? '';
        });
    }

    public static function setBetRows($crawler)
    {
        $bet_rows = $crawler->filter('.diff-row')->each(function ($node) {
            $row = [];
            $title = $node->filter('.popup')->extract(array('data-name'))[0];
            $r = $node->filter('td:not(.sel)')->filter('td:not(.wo-col)')->each(function ($node) {
                return $node->extract(array('data-o'))[0] ?? 'trt';
            });
            $row['title'] = $title;
            $row['odds'] = $r;
            return $row;
        });

        return true;

    }

    /**
     * @return mixed
     */
    public function getResults()
    {
        return $this->results;
    }

    public static function eventExists($team_name_1, $team_name_2, $client)
    {
        $url = self::urlFormatter($team_name_1, $team_name_2);

//        $this->setBetRows();
//        return empty($this->bet_rows) ? false : true;

    }

    public function formatOdds()
    {

    }

    /**
     * @return mixed
     */
    public function getBookmakers()
    {
        return $this->bookmakers;
    }

    /**
     * @return mixed
     */
    public function getEventDate()
    {
        return $this->event_date;
    }

    /**
     * @return mixed
     */
    public function getBetRows()
    {
        return $this->bet_rows;
    }

    public function setEventDate()
    {
        $date = $this->crawler->filter('.date')->extract(['_text'])[0];
        $this->event_date = trim(substr($date, 0, stripos($date, '/')));
    }
}
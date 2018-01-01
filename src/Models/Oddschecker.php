<?php


namespace Acme\Models;
use Goutte;
use Acme\Betting\BettingUtilities;

class Oddschecker extends BettingUtilities implements SiteScraper
{
    protected $crawler;
    protected $bookmakers;
    protected $event_date;
    protected $bet_rows;
    protected $results;
    protected $possible_results;

    public function __construct($url, Goutte\Client $client)
    {
        $this->crawler = $client->request('GET',$url);
    }

    public static function urlSlugFormatter($team, $opposition)
    {
        return sprintf('%s-v-%s', $team, $opposition);
    }

    public function exec()
    {

        if ($this->eventExists()) {
            $this->getProperties();
            $this->exec();
//                } echo '<pre>';print_r($all_odds);die;

//            $arbitrage_opportunities = array_merge($arbitrage_opportunities, $this->oddsModelCorrelation->getArbitrageOpportunities());
        }
        // sorts results from web scrape into standardised format to be passed to BetsCorrelation

        $this->results = ['odds'=>[]];
        $this->results['event_date'] = $this->dateFormatter($this->event_date);
        foreach ($this->bet_rows as $bet_row){
            if(!array_key_exists($bet_row['title'], $this->results['odds'])){
                $this->results['odds'][$bet_row['title']] = [];
                for($i=0; $i<count($bet_row['odds']); $i++){
                    $result = ['odds'=>$bet_row['odds'][$i], 'bookmakers'=>$this->bookmakers[$i]];
                    $this->results['odds'][$bet_row['title']][] = $result;
                }
            }
        }

    }

    public function getProperties()
    {
        $this->setBetRows();
        $this->setBookmakers();
        $this->setEventDate();
    }

    public function setBookmakers()
    {
        $this->bookmakers = $this->crawler->filter('.bookie-area > aside > a')->each(function ($node) {
            return $node->extract(array('title'))[0] ?? '';
        });
    }

    public function setBetRows()
    {
        if(!empty($this->bet_rows))
            return false;

        $this->bet_rows = $this->crawler->filter('.diff-row')->each(function ($node) {
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

    public function eventExists()
    {
        $this->setBetRows();
        return empty($this->bet_rows) ? false : true;

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
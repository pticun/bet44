<?php


namespace Acme\Models\Oddschecker;


use Acme\Betting\Arbitrage;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class Oddschecker
{
    public $url;
    public $crawler;
    public $bookmakers;

    public function __construct(\Goutte\Client $crawler, $url)
    {
        $this->url = $url;
    }

    public function setCrawler($crawler, $formatted_slug)
    {
        $this->crawler = $crawler->request('GET', $this->url.'/'.$formatted_slug);
    }

    public function getOdds()
    {
        $bet_rows = [];

        if(!empty($this->crawler)){
            $bet_rows = $this->crawler->filter('.diff-row')->each(function ($node) {
                $row = [];
                $title = $node->filter('.popup')->extract(array('data-name'))[0];
                $r = $node->filter('td:not(.sel)')->filter('td:not(.wo-col)')->each(function ($node) {
                    return $node->extract(array('data-o'))[0] ?? 'trt';
                });
                $row['title'] = $title;
                $row['odds'] = $r;
                return $row;
            });
        }

        return $bet_rows;
    }

    public function getBookmakers()
    {
        $bookmakers = $this->crawler->filter('.bookie-area > aside > a')->each(function ($node) {
            return $node->extract(array('title'))[0] ?? '';
        });

        return $bookmakers;
    }

    public function getEventDate()
    {
        $date = $this->crawler->filter('.date')->extract(['_text'])[0];
        return trim(substr($date, 0, stripos($date, '/')));
    }

    public function sortRows($bet_rows, $bookmakers)
    {
        $results = [];
        $ii=0;
        foreach ($bet_rows as $bet_row) {
//            if($ii === 2)
//                break;
            $row = [];
            for ($i = 0; $i < 5; $i++) {
                $single_odds = Arbitrage::validateFraction($bet_row['odds'][$i]);
                $result = ['odds' => Arbitrage::setDecimalOddsFromFractions($single_odds),
                    'bookmakers' => $bookmakers[$i], 'result'=>$bet_row['title'],
                    'fractional_odds' => $single_odds];
                $row[] = $result;
            }
            $results[] = $row;
            $ii++;

//            pp($results);
        }

        return $results;
    }
}
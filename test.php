<?php

$bookmakers_name_formats = null;

use Goutte\Client;
use Acme\Betting\Converter;
use Acme\Betting\Arbitrage;
use Acme\Exceptions\CustomExceptions;
//use Acme\Betting\BetsCorrelation;

$client = new Client();



$con = new Converter();
$arb = new Arbitrage(null, $con);

$decimal_odds = [1.20, 8.00];
$fractional_odds = ['1/5', '7/1'];


try {
    $converter = new Converter();
    $arb = new Arbitrage($decimal_odds, $converter);
//    $arb->setDecimalOddsFromFractions($fractional_odds);
    $arb->setArbParams();

    if ($arb->arb()) {
        $arb->setTotalBettingAmount(1000);
        $arb->exec();

        $results = $arb->getResults();

        echo '<pre>';
        var_dump($results);
        die;
    }

} catch (CustomExceptions $e) {
    echo $e->customMessage();
}

$test = [
    'odds' => [
        [
            [
                'winner'=>'arsenal',
                'odds' => '31/20',
                'bookmakers' => 'Bet 365'
            ],
            [
                'winner'=>'arsenal',
                'odds' => '6/4',
                'bookmakers' => 'Sky Bet'
            ]
        ],
        [
            [
                'winner'=>'liverpool',
                'odds' => '7/5',
                'bookmakers' => 'Bet 365'
            ],
            [
                'winner'=>'liverpool',
                'odds' => '11/4',
                'bookmakers' => 'Sky Bet'
            ]
        ],
        [
            [
                'winner'=>'draw',
                'odds' => '4/1',
                'bookmakers' => 'Bet 365'
            ],
            [
                'winner'=>'draw',
                'odds' => '11/2',
                'bookmakers' => 'Sky Bet'
            ]
        ]
    ]
];
echo '<pre>';//print_r($test);die;
$all_odds = [];
foreach ($test['odds'][0] as $t){

}die;
foreach ($test['odds'] as $key=>$val){
    foreach ($test['odds'][$key] as $v){
        foreach ($test['odds'] as $a=>$b){
            if($key===$a)
                continue;
            foreach ($test['odds'][$a] as $c){
                $odds[] = ['team'=>$a, 'odds'=>$c['odds'], 'bookmakers'=>$c['bookmakers']];
            }
        }
        $all_odds[] = $odds;
    }
//                        $all_odds[] = $odds;
}

echo '<pre>';
print_r($all_odds);die;




$oddsCheckerOdds = [];
$arbitrage_opportunities = [];
foreach ($bookmakers_name_formats['Oddschecker']['teams_formats'] as $key=>$val){
    $team = $val;
    foreach ($bookmakers_name_formats['Oddschecker']['teams_formats'] as $k=>$v){
        if($val !== $v){
            $slug = Oddschecker::urlSlugFormatter($val, $v);
            $oddschecker = new Oddschecker('https://www.oddschecker.com/football/english/premier-league/'.$slug.'/winner', $client);
            if($oddschecker->eventExists()){
                $oddschecker->getProperties();
                $oddschecker->exec();
                $oddschecker_odds = $oddschecker->getResults();
                $all_odds = [];
                foreach ($oddschecker_odds['odds'] as $key=>$val){
                    foreach ($val as $v){
                        $odds = [['team'=>$key, 'odds'=>$v['odds'], 'bookmakers'=>$v['bookmakers']]];
                        foreach ($oddschecker_odds['odds'] as $a=>$b){
                            if($key===$a)
                                continue;
                            foreach ($oddschecker_odds['odds'][$a] as $c){
                                $odds[] = ['team'=>$a, 'odds'=>$c['odds'], 'bookmakers'=>$c['bookmakers']];
                            }
                        }
                        $all_odds[] = $odds;
                    }
//                        $all_odds[] = $odds;
                }
                echo '<pre>';print_r($all_odds);die;
//                } echo '<pre>';print_r($all_odds);die;

                $arbitrage_opportunities = array_merge($arbitrage_opportunities, $oddscheckerCorrelation->getArbitrageOpportunities());
            }
        }
    }
}

<?php

require_once __DIR__ . '/../bootstrap/start.php';

//$client = new Client();
//
//$crawler = $client->request('GET',
//    'https://www.oddschecker.com/football/english/premier-league/burnley-v-stoke/winner');
//
//
//$titles = $crawler->filter('.bookie-area > aside > a')->each(function ($node) {
//    return $node->extract(array('title'))[0] ?? '';
//});
//
////var_dump($titles);
//
////$crawler->filter('.bookie-area')->each(function ($node) {
////    print $node->text()."<br />";
////});
//$rows = [];
//$rows = $crawler->filter('.diff-row')->each(function ($node) {
//    $r = $node->filter('td:not(.sel)')->each(function ($node) {
//        return $node->extract(array('data-o'))[0] ?? 'trt';
//    });
//
//    return $r;
//});
//echo '<pre>';
//var_dump($rows);
//
////die(ODDSCHECKER.'/football/english/premier-league/west-ham-v-chelsea/winner');
////die(urlencode(ODDSCHECKER.'/football/english/premier-league/west-ham-v-chelsea/winner'));
////$curl = new CURL('https://www.oddschecker.com');
////$curl->exec();
////$response = $curl->get_response();https://www.oddschecker.com/football/english/premier-league/west-ham-v-chelsea/half-time
////$curl->close();
////
////var_dump($response);

use Goutte\Client;
use Acme\Betting\Converter;
use Acme\Betting\Arbitrage;
use Acme\Exceptions\CustomExceptions;

$con = new Converter();
$arb = new Arbitrage(null, $con);
$results = $arb->unitTestTest();
print_r($results);die;

$tst = '9/4';
$decimal_odds = [1.20, 8.00];
$fractional_odds = ['23/1', '1/1', '5/1'];
try {
//    $decimal = Converter::fractionToDecimal($tst);
//    $implied_odds = Converter::decimalToImplied($decimal);
//    $decimal_odds = Converter::decimalToDecimalOdds($decimal);
    $converter = new Converter();
    $arb = new Arbitrage(null, $converter);
    $arb->setDecimalOddsFromFractions($fractional_odds);
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
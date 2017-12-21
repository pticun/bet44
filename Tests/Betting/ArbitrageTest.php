<?php

use Acme\Betting\Arbitrage;
use Acme\Betting\Converter;

class ArbitrageTest extends \PHPUnit\Framework\TestCase
{

    protected $converter;

    protected function setUp()
    {
        $this->converter = $this->getMockBuilder('Acme\Betting\Converter')
            ->getMock();
    }

    public function testSetDecimalOddsFromFractions()
    {
        // need to work out how to mock the fractionToDecimal in converter
        $converter = new Converter();
        $arbitrage = new Arbitrage(null, $converter);

        $fractions = ['2/1', '3/1'];
        $arbitrage->setDecimalOddsFromFractions($fractions);
        $results = $arbitrage->getResults();

        $this->assertEquals(['bets'=>[['decimal_odds' => 3.00], ['decimal_odds' => 4.00]]], $results);
    }

    public function testDecimalOddsToImpliedOdds()
    {
        $arbitrage = new Arbitrage();
        $decimal_odds = 2.10;
        $implied_odds = $arbitrage->decimalOddsToImpliedOdds($decimal_odds);
        $test_case = round(100 * (1 / 2.10), 2);

        $this->assertEquals($test_case, $implied_odds);
    }


    public function testConstructWithDecimalOdds()
    {
        $arbitrage = new Arbitrage([2.10, 2.10]);
        $results = $arbitrage->getResults();
        $test_case = [
            'bets'=>[
                ['decimal_odds'=>2.10],
                ['decimal_odds' => 2.10]
            ]
        ];

        $this->assertEquals($test_case, $results);
    }

    /**
     * @dataProvider providerDecimalOddsSingular
     */
    public function testMarketTotal($original, $expected)
    {
        $arbitrage = new Arbitrage();
        $actual = $arbitrage->marketTotal($original);

        $this->assertEquals($expected, $actual);
    }

    public function testImpliedOdds()
    {
        $decimal_odds = 2.10;
        $test_case = round(100 * (1 / $decimal_odds), 2);
        $arbitrage = new Arbitrage();

        $implied_odds = $arbitrage->impliedOdds($decimal_odds);
        $this->assertEquals($test_case, $implied_odds);
    }

    public function testUnitTestTest()
    {
        $converter = $this->getMockBuilder('Acme\Betting\Converter')
            ->setMethods(['getAFraction']) // don't really need to do this here
            ->getMock();

        $converter->expects($this->at(0))
            ->method('getAFraction')
            ->will($this->returnValue('2/1'));

        $converter->expects($this->at(1))
            ->method('getAFraction')
            ->will($this->returnValue('3/1'));

        $converter->expects($this->at(2))
            ->method('getAFraction')
            ->will($this->returnValue('4/1'));

        $arbitrage = new Arbitrage(null, $converter);
        $test_case = [0.33, 0.25, 0.20];
        $results = $arbitrage->unitTestTest();

        $this->assertEquals($test_case, $results);
    }

    public function providerDecimalOddsSingular()
    {
        return [
            [[47.61, 45.43, 98.23], array_sum([47.61, 45.43, 98.23])]
        ];
    }

//    public function testExec()
//    {
//        $arbitrage = new Arbitrage([2.10, 2.10]);
//        $test_case = [
//            'bets'=>[
//                ['decimal_odds'=>2.10],
//                ['decimal_odds' => 2.10]
//            ]
//        ];
//
//        $arbitrage->exec();
//
//        $results = $arbitrage->getResults();
//
//        $this->assertEquals($test_case, $results);
//    }

}

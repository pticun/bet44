<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/12/2017
 * Time: 15:48
 */

namespace Acme\Betting;
use Acme\Exceptions\CustomExceptions;

class Converter
{
    public function __construct()
    {

    }

    public static function fractionToDecimalOdds($fraction)
    {
        if(!stripos($fraction, '/')){
            throw new CustomExceptions('Invalid fraction.');
        }

        $split_fraction = explode('/', $fraction);

        if(count($split_fraction) < 2){
            throw new CustomExceptions('Invalid fraction.');
        }

        $fraction_to_decimal = self::fractionPartsToDecimal($split_fraction[0], $split_fraction[1]);
        $decimal_odds = self::decimalToDecimalOdds($fraction_to_decimal);

        return $decimal_odds;
    }

    public function getAFraction()
    {
        $fractions = ['2/1', '3/1', '4/1'];
        return $fractions[rand(0, 2)];
    }

    public static function fractionToDecimal($fraction)
    {
        if(!stripos($fraction, '/')){
            throw new CustomExceptions('Invalid fraction.');
        }

        $split_fraction = explode('/', $fraction);

        return $split_fraction[1]/($split_fraction[0]+$split_fraction[1]);
    }

    public static function fractionPartsToDecimal($numerator, $denominator) : float
    {
        return $denominator/($numerator+$denominator);
    }

    public static function decimalToImpliedOdds($decimal) : float
    {
        return 100 * round($decimal, 3);
    }



    public static function decimalToDecimalOdds($decimal)
    {
        return 1 / $decimal;
    }
}
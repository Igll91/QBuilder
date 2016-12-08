<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 06.12.2016.
 * Time: 23:16
 */

namespace AppBundle\Helper;


final class ValueChecker
{

    private function __construct() { }

    public static function getNumericOrEx($value)
    {
        if (!is_numeric($value)) {
            throw new \InvalidArgumentException("Value (${value}) is not numeric!");
        }

        return $value;
    }

    public static function getPositiveNumericOrEx($value)
    {
        $value = self::getNumericOrEx($value);

        if ($value <= 0) {
            throw new \InvalidArgumentException("Value (${value}) is not positive!");
        }

        return $value;
    }

    public static function getStringOrEx($value)
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException("Value (${value}) is not string!");
        }

        return $value;
    }

    public static function getDateTimeOrEx($value)
    {
        if (!is_a($value, 'DateTime')) {
            throw new \InvalidArgumentException("Value (${value}) is not DateTime!");
        }

        return $value;
    }

    public static function getTimeOrEx($value)
    {
        $transformedVal = strtotime($value);

        if (!$transformedVal) {
            throw new \InvalidArgumentException("Value (${value}) is not valid Time!");
        }

        return $transformedVal;
    }
}
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

    /**
     * @param $value string Time value in format H:i:s (for example 23:59:59)
     *
     * @return \DateTime
     */
    public static function getTimeOrEx($value)
    {
        if (!preg_match('/^([0-9]|0[0-9]|1[0-9]|2[0-3]):([0-5][0-9]|[0-5][0-9]:[0-5][0-9])$/', $value)) {
            throw new \InvalidArgumentException("Value (${value}) is not valid Time(H:i:s)!");
        }

        $transformedVal = \DateTime::createFromFormat('H:i:s', $value);

        if (!$transformedVal) {
            throw new \InvalidArgumentException("Value (${value}) is not valid Time(H:i:s)!");
        }

        return $transformedVal;
    }
}
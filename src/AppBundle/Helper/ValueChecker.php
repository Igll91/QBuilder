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

    /**
     * Checks whether passed value is numeric.
     *
     * @param $value mixed Value to be checked if numeric.
     *
     * @throws \InvalidArgumentException If value is not numeric.
     *
     * @return mixed Returns passed numeric value or throws InvalidArgumentException.
     */
    public static function getNumericOrEx($value)
    {
        if (!is_numeric($value)) {
            throw new \InvalidArgumentException("Value (${value}) is not numeric!");
        }

        return $value;
    }

    /**
     * Checks whether passed value is positive numeric.
     *
     * @param $value mixed Value to be checked if it is positive numeric.
     *
     * @throws \InvalidArgumentException If value is not positive numeric.
     *
     * @return mixed Returns passed value or throws InvalidArgumentException.
     */
    public static function getPositiveNumericOrEx($value)
    {
        $value = self::getNumericOrEx($value);

        if ($value <= 0) {
            throw new \InvalidArgumentException("Value (${value}) is not positive!");
        }

        return $value;
    }

    public static function getIntOrEx($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            throw new \InvalidArgumentException("Value (${value}) is not integer!");
        }

        return $value;
    }

    public
    static function getPositiveIntOrEx($value)
    {
        $value = self::getIntOrEx($value);

        if ($value <= 0) {
            throw new \InvalidArgumentException("Value (${value}) is not positive!");
        }

        return $value;
    }

    /**
     * Checks whether passed value is valid string.
     *
     * @param $value mixed Value to be checked if it is string.
     *
     * @throws \InvalidArgumentException If value is not valid string.
     *
     * @return mixed Returns passed value or throws InvalidArgumentException.
     */
    public
    static function getStringOrEx($value)
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException("Value (${value}) is not string!");
        }

        return $value;
    }

    /**
     * Checks whether passed value is valid DateTime.
     *
     * @param $value mixed Value to be checked if it is DateTime.
     *
     * @throws \InvalidArgumentException If value is not valid DateTime.
     *
     * @return mixed Returns value or throws InvalidArgumentException.
     */
    public
    static function getDateTimeOrEx($value)
    {
        if (!is_a($value, 'DateTime')) {
            throw new \InvalidArgumentException("Value (${value}) is not DateTime!");
        }

        return $value;
    }

    /**
     * Checks whether passed value is valid DateTime.
     *
     * Passed value must be valid DateTime in format (H:i:s) or without seconds (H:i).
     *
     * @param $value string Value to be checked if it is in valid DateTime format.
     *
     * @throws \InvalidArgumentException If value is not valid excpected Time format.
     *
     * @return \DateTime Returns value or throws InvalidArgumentException.
     */
    public
    static function getTimeOrEx($value)
    {
        if (!preg_match('/^([0-9]|0[0-9]|1[0-9]|2[0-3]):([0-5][0-9]|[0-5][0-9]:[0-5][0-9])$/', $value)) {
            throw new \InvalidArgumentException("Value (${value}) is not valid Time(H:i:s)!");
        }

        $transformedVal = \DateTime::createFromFormat('H:i:s', $value);

        if (!$transformedVal) {
            $transformedVal = \DateTime::createFromFormat('H:i', $value);
        }

        if (!$transformedVal) {
            throw new \InvalidArgumentException("Value (${value}) is not valid Time(H:i:s)!");
        }

        return $transformedVal;
    }
}
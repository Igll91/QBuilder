<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 14.12.2016.
 * Time: 20:15
 */

namespace AppBundle\Model\Filter;


use AppBundle\Helper\ValueChecker;

class DateFilterType extends FilterType
{
    private $format;

    public function __construct($format = "Y-m-d")
    {
        parent::__construct("date");
        $this->format = $format;
    }


    public function validateValue($value)
    {
        $date = \DateTime::createFromFormat($this->format, $value);

        return (bool)$date;
    }


}
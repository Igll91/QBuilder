<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 14.12.2016.
 * Time: 20:30
 */

namespace AppBundle\Model\Filter\Type;


class DateTimeFilterType extends FilterType
{
    private $format;

    public function __construct($format = "Y-m-d h:i:s")
    {
        parent::__construct("datetime");
        $this->format = $format;
    }

    public function validateValue($value)
    {
        $date = \DateTime::createFromFormat($this->format, $value);

        return (bool)$date;
    }

}
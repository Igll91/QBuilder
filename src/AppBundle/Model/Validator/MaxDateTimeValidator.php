<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 12.12.2016.
 * Time: 19:27
 */

namespace AppBundle\Model\Validator;


use AppBundle\Helper\ValueChecker;

class MaxDateTimeValidator extends MaxValidator
{
    public function __construct(\DateTime $maxValue)
    {
        parent::__construct($maxValue);
    }

    public function validate($value)
    {
        $currentValue = ValueChecker::getDateTimeOrEx($value);

        return $currentValue <= $this->maxValue;
    }

}
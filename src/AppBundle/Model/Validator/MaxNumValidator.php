<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 11.12.2016.
 * Time: 13:25
 */

namespace AppBundle\Model\Validator;


use AppBundle\Helper\ValueChecker;

class MaxNumValidator extends MaxValidator
{
    public function __construct($maxValue)
    {
        parent::__construct(ValueChecker::getNumericOrEx($maxValue));
    }

    public function validate($value)
    {
        $currentVal = ValueChecker::getNumericOrEx($value);

        return $currentVal <= $this->maxValue;
    }

}
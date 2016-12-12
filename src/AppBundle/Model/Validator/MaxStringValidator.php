<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 11.12.2016.
 * Time: 13:01
 */

namespace AppBundle\Model\Validator;


use AppBundle\Helper\ValueChecker;

class MaxStringValidator extends MaxValidator
{
    /**
     * MaxStringValidator constructor.
     *
     * @param $maxLength int Maximal length allowed.
     */
    public function __construct($maxLength)
    {
        parent::__construct(ValueChecker::getPositiveIntOrEx($maxLength));
    }

    public function validate($value)
    {
        $currentVal = ValueChecker::getStringOrEx($value);

        return strlen($currentVal) <= $this->maxValue;
    }

}
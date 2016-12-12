<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 11.12.2016.
 * Time: 13:52
 */

namespace AppBundle\Model\Validator;


use AppBundle\Helper\ValueChecker;

class MaxTimeValidator extends MaxValidator
{

    /**
     * MaxTimeValidator constructor.
     *
     * @param $maxTime
     */
    public function __construct($maxTime)
    {
        parent::__construct(ValueChecker::getTimeOrEx($maxTime));
    }

    public function validate($value)
    {
        $currentVal = ValueChecker::getTimeOrEx($value);

        return $currentVal <= $this->maxValue;
    }

}
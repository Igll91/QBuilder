<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 07.12.2016.
 * Time: 22:13
 */

namespace AppBundle\Model\Validator;


use AppBundle\Helper\ValueChecker;

class MinTimeValidator extends MinValidator
{
    /**
     * Minimal allowed time.
     *
     * @var \DateTime
     */
    private $minValue;

    public function __construct($minValue)
    {
        $this->minValue = ValueChecker::getTimeOrEx($minValue);
    }

    public function validate($value)
    {
        $currentVal = ValueChecker::getTimeOrEx($value);

        return $currentVal >= $this->minValue;
    }

}
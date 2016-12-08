<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 06.12.2016.
 * Time: 23:05
 */

namespace AppBundle\Model\Validator;


use AppBundle\Helper\ValueChecker;

class MinNumValidator extends MinValidator
{
    /**
     * Minimal allowed numeric value.
     *
     * @var integer|double|float
     */
    private $minValue;

    public function __construct($minValue)
    {
        $this->minValue = ValueChecker::getNumericOrEx($minValue);
    }

    public function validate($value)
    {
        $currentVal = ValueChecker::getNumericOrEx($value);

        return $currentVal >= $this->minValue;
    }

}
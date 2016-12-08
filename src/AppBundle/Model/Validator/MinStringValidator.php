<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 07.12.2016.
 * Time: 21:50
 */

namespace AppBundle\Model\Validator;


use AppBundle\Helper\ValueChecker;

class MinStringValidator extends MinValidator
{
    /**
     * Minimal allowed string size.
     *
     * @var integer
     */
    private $minValue;

    public function __construct($minValue)
    {
        $this->minValue = ValueChecker::getPositiveNumericOrEx($minValue);
    }

    /**
     *
     * @param string $value
     *
     * @return bool True if passed string is longer or equal than required limit.
     */
    public function validate($value)
    {
        $currentVal = ValueChecker::getStringOrEx($value);

        return strlen($currentVal) >= $this->minValue;
    }

}
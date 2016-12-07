<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 07.12.2016.
 * Time: 22:00
 */

namespace AppBundle\Model\Validator;


use AppBundle\Helper\ValueChecker;

class MinDateTimeValidator extends MinValidator
{
    /**
     * Minimal allowed datetime.
     *
     * @var \DateTime
     */
    private $minValue;

    public function __construct(\DateTime $minValue)
    {
        $this->minValue = $minValue;
    }

    public function validate($value)
    {
        $currentValue = ValueChecker::getDateTimeOrEx($value);

        return $currentValue >= $this->minValue;
    }

}
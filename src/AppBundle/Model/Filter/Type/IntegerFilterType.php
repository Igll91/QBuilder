<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 14.12.2016.
 * Time: 20:05
 */

namespace AppBundle\Model\Filter\Type;


use AppBundle\Helper\ValueChecker;

class IntegerFilterType extends FilterType
{
    public function __construct()
    {
        parent::__construct("integer");
    }

    public function validateValue($value)
    {
        try {
            ValueChecker::getIntOrEx($value);

            return TRUE;
        } catch (\InvalidArgumentException $ex) {
            return FALSE;
        }
    }

}
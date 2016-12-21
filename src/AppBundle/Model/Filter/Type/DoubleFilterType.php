<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 14.12.2016.
 * Time: 20:07
 */

namespace AppBundle\Model\Filter\Type;


use AppBundle\Helper\ValueChecker;

class DoubleFilterType extends FilterType
{
    public function __construct()
    {
        parent::__construct("double");
    }

    public function validateValue($value)
    {
        try {
            ValueChecker::getNumericOrEx($value);

            return TRUE;
        } catch (\InvalidArgumentException $ex) {
            return FALSE;
        }
    }

}
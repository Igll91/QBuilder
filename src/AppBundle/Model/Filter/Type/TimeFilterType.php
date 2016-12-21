<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 14.12.2016.
 * Time: 20:21
 */

namespace AppBundle\Model\Filter\Type;


use AppBundle\Helper\ValueChecker;

class TimeFilterType extends FilterType
{
    public function __construct() { parent::__construct("time"); }

    public function validateValue($value)
    {
        try {
            ValueChecker::getTimeOrEx($value);

            return TRUE;
        } catch (\InvalidArgumentException $ex) {
            return FALSE;
        }
    }

}
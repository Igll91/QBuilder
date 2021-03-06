<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 14.12.2016.
 * Time: 20:01
 */

namespace AppBundle\Model\Filter\Type;

use AppBundle\Helper\ValueChecker;

class StringFilterType extends FilterType
{
    public function __construct()
    {
        parent::__construct("string");
    }

    public function validateValue($value)
    {
        try {
            ValueChecker::getStringOrEx($value);

            return true;
        } catch (\InvalidArgumentException $ex) {
            return false;
        }
    }
}

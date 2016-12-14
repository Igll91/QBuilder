<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 14.12.2016.
 * Time: 20:25
 */

namespace AppBundle\Model\Filter;


class BooleanFilterType extends FilterType
{
    public function __construct() { parent::__construct('boolean'); }

    public function validateValue($value)
    {
        return is_bool($value);
    }


}
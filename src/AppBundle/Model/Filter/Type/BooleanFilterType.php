<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 14.12.2016.
 * Time: 20:25
 */

namespace AppBundle\Model\Filter\Type;

class BooleanFilterType extends FilterType
{
    public function __construct()
    {
        parent::__construct('boolean');
    }

    public function validateValue($value)
    {
        $string = strtolower((string)$value);

        return (in_array($string, array("true", "false", "1", "0", "yes", "no"), true));
    }
}

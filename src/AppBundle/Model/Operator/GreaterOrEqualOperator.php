<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 03.01.2017.
 * Time: 12:57
 */

namespace AppBundle\Model\Operator;

class GreaterOrEqualOperator extends Operator
{
    public function __construct()
    {
        parent::__construct('greater_or_equal', false, 1);
    }
}

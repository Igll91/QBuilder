<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 03.01.2017.
 * Time: 12:55
 */

namespace AppBundle\Model\Operator;

class LessOrEqualOperator extends Operator
{
    public function __construct()
    {
        parent::__construct('less_or_equal', false, 1);
    }
}

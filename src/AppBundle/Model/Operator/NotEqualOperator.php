<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 03.01.2017.
 * Time: 13:11
 */

namespace AppBundle\Model\Operator;

class NotEqualOperator extends Operator
{
    public function __construct()
    {
        parent::__construct('not_equal', false, 1);
    }
}

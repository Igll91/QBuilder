<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 03.01.2017.
 * Time: 15:47
 */

namespace AppBundle\Model\Operator;

class NotContainsOperator extends Operator
{
    public function __construct()
    {
        parent::__construct('not_contains', false, 2);
    }
}

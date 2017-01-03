<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 03.01.2017.
 * Time: 15:46
 */

namespace AppBundle\Model\Operator;

class ContainsOperator extends Operator
{
    public function __construct()
    {
        parent::__construct('contains', false, 1);
    }
}

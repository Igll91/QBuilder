<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 03.01.2017.
 * Time: 17:35
 */

namespace AppBundle\Model\Operator;

class BetweenOperator extends Operator
{
    public function __construct()
    {
        parent::__construct('between', false, 2);
    }
}

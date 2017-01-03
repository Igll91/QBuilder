<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 03.01.2017.
 * Time: 17:39
 */

namespace AppBundle\Model\Operator;

class NotBetweenOperator extends Operator
{
    public function __construct()
    {
        parent::__construct('not_between', false, 2);
    }
}

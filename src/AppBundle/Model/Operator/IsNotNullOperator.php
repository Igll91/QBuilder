<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 03.01.2017.
 * Time: 13:21
 */

namespace AppBundle\Model\Operator;

class IsNotNullOperator extends Operator
{
    public function __construct()
    {
        parent::__construct('is_not_null', false, 1);
    }
}

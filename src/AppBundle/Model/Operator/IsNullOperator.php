<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 02.01.2017.
 * Time: 21:36
 */

namespace AppBundle\Model\Operator;

class IsNullOperator extends Operator
{

    public function __construct()
    {
        parent::__construct('is_null', false, 1);
    }
}

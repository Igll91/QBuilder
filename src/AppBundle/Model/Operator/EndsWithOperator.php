<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 03.01.2017.
 * Time: 14:48
 */

namespace AppBundle\Model\Operator;

class EndsWithOperator extends Operator
{
    public function __construct()
    {
        parent::__construct('ends_with', false, 1);
    }
}

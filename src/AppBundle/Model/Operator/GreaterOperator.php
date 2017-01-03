<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 03.01.2017.
 * Time: 13:00
 */

namespace AppBundle\Model\Operator;

class GreaterOperator extends Operator
{
    public function __construct()
    {
        parent::__construct('greater', false, 1);
    }
}

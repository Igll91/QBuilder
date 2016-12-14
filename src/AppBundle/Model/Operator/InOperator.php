<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 13.12.2016.
 * Time: 23:18
 */

namespace AppBundle\Model\Operator;


class InOperator extends Operator
{

    public function __construct($type, $multiple, $numberOfInputs)
    {
        parent::__construct('in', TRUE, 1);
    }

}
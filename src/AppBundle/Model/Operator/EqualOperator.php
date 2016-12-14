<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 13.12.2016.
 * Time: 22:56
 */

namespace AppBundle\Model\Operator;


class EqualOperator extends Operator
{

    public function __construct($type, $multiple, $numberOfInputs)
    {
        parent::__construct("equal", FALSE, 1);
    }

}
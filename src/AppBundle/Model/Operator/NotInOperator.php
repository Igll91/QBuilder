<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 03.01.2017.
 * Time: 13:13
 */

namespace AppBundle\Model\Operator;

class NotInOperator extends Operator
{
    public function __construct()
    {
        parent::__construct('not_in', false, 1);
    }
}

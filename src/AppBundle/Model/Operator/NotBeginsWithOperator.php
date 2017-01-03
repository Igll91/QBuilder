<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 03.01.2017.
 * Time: 14:43
 */

namespace AppBundle\Model\Operator;

class NotBeginsWithOperator extends Operator
{
    public function __construct()
    {
        parent::__construct('not_begins_with', false, 1);
    }
}

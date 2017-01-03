<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 03.01.2017.
 * Time: 14:50
 */

namespace AppBundle\Model\Operator;

class BeginsWithOperator extends Operator
{
    public function __construct()
    {
        parent::__construct('begins_with', false, 1);
    }
}

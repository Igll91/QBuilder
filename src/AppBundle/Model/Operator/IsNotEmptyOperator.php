<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 03.01.2017.
 * Time: 13:41
 */

namespace AppBundle\Model\Operator;

class IsNotEmptyOperator extends Operator
{
    public function __construct()
    {
        parent::__construct('is_not_empty', false, 1);
    }
}

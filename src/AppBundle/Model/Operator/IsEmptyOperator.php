<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 03.01.2017.
 * Time: 13:32
 */

namespace AppBundle\Model\Operator;

class IsEmptyOperator extends Operator
{
    public function __construct()
    {
        parent::__construct('is_empty', false, 1);
    }
}

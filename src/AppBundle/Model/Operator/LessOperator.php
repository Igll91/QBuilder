<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 03.01.2017.
 * Time: 13:03
 */

namespace AppBundle\Model\Operator;

class LessOperator extends Operator
{
    public function __construct()
    {
        parent::__construct('less', false, 1);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 03.01.2017.
 * Time: 14:28
 */

namespace AppBundle\Model\Operator;

class NotEndsWithOperator extends Operator
{
    public function __construct()
    {
        parent::__construct('not_ends_with', false, 1);
    }
}

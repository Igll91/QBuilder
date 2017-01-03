<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 02.01.2017.
 * Time: 22:22
 */

namespace AppBundle\Model\Operator\Parser;

use AppBundle\Model\Operator\Operator;

interface IOperatorParser
{
    /**
     * Parses given value into corresponding Operator.
     *
     * @param $value mixed Value that represents Operator.
     *
     * @return Operator|null Corresponding Operator if found , else null.
     */
    public function parse($value);
}

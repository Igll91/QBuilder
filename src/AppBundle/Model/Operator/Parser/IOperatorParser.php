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
     * Parses given string into corresponding Operator.
     *
     * @param $value string String representing Operator.
     *
     * @return Operator|null Corresponding Operator if found , else null.
     */
    public static function parse($value);
}

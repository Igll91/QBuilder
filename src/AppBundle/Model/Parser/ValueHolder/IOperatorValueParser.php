<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 02.01.2017.
 * Time: 11:15
 */

namespace AppBundle\Model\Parser\ValueHolder;

use AppBundle\Model\ValueHolder\OperatorValueHolder;

interface IOperatorValueParser
{
    /**
     * Parses given string into corresponding OperatorValueHolder.
     *
     * @param $val string String representing OperatorValueHolder.
     *
     * @return OperatorValueHolder|null Corresponding OperatorValueHolder if found , else null.
     */
    public static function parse($val);
}

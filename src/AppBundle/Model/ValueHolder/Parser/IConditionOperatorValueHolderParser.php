<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 02.01.2017.
 * Time: 11:15
 */

namespace AppBundle\Model\ValueHolder\Parser;

use AppBundle\Model\ValueHolder\ConditionOperatorValueHolder;

interface IConditionOperatorValueHolderParser
{
    /**
     * Parses given string into corresponding ConditionOperatorValueHolder.
     *
     * @param $val string String that will be parsed.
     *
     * @return ConditionOperatorValueHolder|null Corresponding ConditionOperatorValueHolder if found , else null.
     */
    public static function parse($val);
}

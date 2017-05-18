<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 04.01.2017.
 * Time: 19:32
 */

namespace AppBundle\Model\ValueHolder\Parser;

use AppBundle\Helper\ValueChecker;
use AppBundle\Model\ValueHolder\AndConditionValueHolder;
use AppBundle\Model\ValueHolder\OrConditionValueHolder;

/**
 * Parses given value into one of ConditionValueHolder objects.
 *
 * Parses querybuilderjs condition string into corresponding object representation.
 */
class RuleConditionOperatorValueHolderParser implements IConditionOperatorValueHolderParser
{
    public static function parse($val)
    {
        $stringVal = ValueChecker::getStringOrEx($val);
        $operator  = null;

        switch ($stringVal) {
            case 'AND':
                $operator = new AndConditionValueHolder();
                break;
            case 'OR':
                $operator = new OrConditionValueHolder();
                break;
        }

        return $operator;
    }
}

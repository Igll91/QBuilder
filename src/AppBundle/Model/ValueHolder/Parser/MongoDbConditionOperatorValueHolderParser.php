<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 02.01.2017.
 * Time: 11:19
 */

namespace AppBundle\Model\ValueHolder\Parser;

use AppBundle\Helper\ValueChecker;
use AppBundle\Model\ValueHolder\AndConditionValueHolder;
use AppBundle\Model\ValueHolder\OrConditionValueHolder;

/**
 * Class MongoDbOperatorValueParser
 * @package AppBundle\Model\parser\value_holder
 *
 * @deprecated
 */
class MongoDbConditionOperatorValueHolderParser implements IConditionOperatorValueHolderParser
{
    public static function parse($val)
    {
        $stringVal = ValueChecker::getStringOrEx($val);
        $operator  = null;

        switch ($stringVal) {
            case '$and':
                $operator = new AndConditionValueHolder();
                break;
            case '$or':
                $operator = new OrConditionValueHolder();
                break;
        }

        return $operator;
    }

}

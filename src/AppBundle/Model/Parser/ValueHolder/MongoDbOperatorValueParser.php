<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 02.01.2017.
 * Time: 11:19
 */

namespace AppBundle\Model\Parser\ValueHolder;

use AppBundle\Helper\ValueChecker;
use AppBundle\Model\ValueHolder\AndValueHolder;
use AppBundle\Model\ValueHolder\OrValueHolder;

class MongoDbOperatorValueParser implements IOperatorValueParser
{
    public static function parse($val)
    {
        $stringVal = ValueChecker::getStringOrEx($val);
        $operator  = null;

        switch ($stringVal) {
            case '$and':
                $operator = new AndValueHolder();
                break;
            case '$or':
                $operator = new OrValueHolder();
                break;
        }

        return $operator;
    }

}

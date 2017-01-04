<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 03.01.2017.
 * Time: 13:52
 */

namespace AppBundle\Model\Operator\Parser;

use AppBundle\Model\ValueHolder\Parser\RuleConditionOperatorValueHolderParser;

final class OperatorParserFactory
{
    const MONGODB_PARSER = 1;
    const RULE_PARSER    = 2;

    private function __construct()
    {
    }

    public static function getParser($parserType)
    {
        switch ($parserType) {
            case self::MONGODB_PARSER:
//                return new MongoDbConditionOperatorValueHolderParser();
                throw new \InvalidArgumentException('Deprecated. Do not use.');
            case self::RULE_PARSER:
                return new RuleConditionOperatorValueHolderParser();
            default:
                throw new \InvalidArgumentException('Unsupported parser type');
        }
    }
}

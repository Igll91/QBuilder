<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 03.01.2017.
 * Time: 13:52
 */

namespace AppBundle\Model\Operator\Parser;

final class OperatorParserFactory
{
    const MONGODB_PARSER = 1;

    private function __construct()
    {
    }

    public static function getParser($parserType)
    {
        switch ($parserType) {
            case self::MONGODB_PARSER:
                return new MongoDbOperatorParser();
            default:
                throw new \InvalidArgumentException('Unsupported parser type');
        }
    }
}

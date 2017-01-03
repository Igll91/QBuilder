<?php

namespace Svuk\Tests\Model\Operator;

use AppBundle\Model\Operator\Parser\MongoDbOperatorParser;
use \Behat\Behat\Context\Context;

/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 03.01.2017.
 * Time: 19:32
 */
class MongoDbOperatorParserRegexContext implements Context
{
    private $regexMethod;
    private $result;

    public function __construct()
    {
        $class  = new \ReflectionClass(MongoDbOperatorParser::class);
        $method = $class->getMethod('getRegexOperator');
        $method->setAccessible(true);

        $this->regexMethod = $method;
    }

    /**
     * @Given that value I want to parse is :arg1
     */
    public function thatValueIWantToParseIs($arg1)
    {
        $this->result = $this->regexMethod->invokeArgs(new MongoDbOperatorParser(), array($arg1));
    }

    /**
     * @Then I should get :arg1
     */
    public function iShouldGet($arg1)
    {
        $reflection = new \ReflectionClass($this->result);
        \PHPUnit_Framework_Assert::assertEquals($arg1, $reflection->getShortName());
    }
}

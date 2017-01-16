<?php

namespace Svuk\Tests\Model\ValueHolder\Parser;

use AppBundle\Model\ValueHolder\AndConditionValueHolder;
use AppBundle\Model\ValueHolder\OrConditionValueHolder;
use AppBundle\Model\ValueHolder\Parser\RuleConditionOperatorValueHolderParser;
use Behat\Behat\Context\Context;

/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 16.01.2017.
 * Time: 19:25
 */
class ConditionOperatorValueHolderParserContext implements Context
{
    private $parserClass;
    private $result = null;

    /**
     * @Given that we use :arg1
     */
    public function thatWeUse($arg1)
    {
        switch ($arg1) {
            case "RuleConditionOperatorValueHolderParser":
                $this->parserClass = RuleConditionOperatorValueHolderParser::class;
                break;
            default:
                throw new \InvalidArgumentException("Unsupported condition operator parser (${arg1}.");
        }
    }

    /**
     * @Given we try to parse value :arg1
     */
    public function weTryToParseValue($arg1)
    {
        $this->result = call_user_func($this->parserClass . '::parse', $arg1);
    }

    /**
     * @Then I should get AndConditionValueHolder
     */
    public function iShouldGetAndconditionvalueholder()
    {
        \PHPUnit_Framework_Assert::assertEquals(AndConditionValueHolder::class, get_class($this->result));
    }

    /**
     * @Then I should get OrConditionValueHolder
     */
    public function iShouldGetOrconditionvalueholder()
    {
        \PHPUnit_Framework_Assert::assertEquals(OrConditionValueHolder::class, get_class($this->result));
    }

    /**
     * @Then I should get null
     */
    public function iShouldGetNull()
    {
        \PHPUnit_Framework_Assert::assertEquals(null, $this->result);
    }
}

<?php

namespace Svuk\Tests\Helper;

use AppBundle\Helper\ValueChecker;
use Behat\Behat\Context\Context;

/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 10.12.2016.
 * Time: 13:35
 */
class ValueCheckerContext implements Context
{
    private $functionToUse;

    private $value;

    private $error;

    private function getVal($value)
    {
        $function = $this->functionToUse;

        try {
            $this->value = ValueChecker::$function($value);
        } catch (\InvalidArgumentException $ex) {
            $this->error = $ex;
        }
    }

    /**
     * @Given that function i want to use is :arg1
     */
    public function thatFunctionIWantToUseIs($arg1)
    {
        $this->functionToUse = $arg1;
    }

    /**
     * @When I try to get value :arg1
     */
    public function iTryToGetValue($arg1)
    {
        $this->getVal($arg1);
    }

    /**
     * @When I try to get integer value :arg1
     */
    public function iTryToGetIntegerValue($arg1)
    {
        $this->getVal((int)$arg1);
    }

    /**
     * @Then I should get :arg1
     */
    public function iShouldGet($arg1)
    {
        \PHPUnit_Framework_Assert::assertEquals($this->value, $arg1);
    }

    /**
     * @Then I should get error :arg1
     */
    public function iShouldGetError($arg1)
    {
        \PHPUnit_Framework_Assert::assertEquals($arg1, get_class($this->error));
    }

    /**
     * @Then I should get valid DateTime object
     */
    public function iShouldGetValidDatetimeObject()
    {
        \PHPUnit_Framework_Assert::assertEquals("DateTime", get_class($this->value));
    }
}

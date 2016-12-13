<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use AppBundle\Model\Validator\Validator;

/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 08.12.2016.
 * Time: 20:39
 */
class MinValidatorContext extends MaxValidatorContext
{

    /**
     * @Given that minimal allowed value for :arg1 is :arg2 of type :arg3
     */
    public function thatMinimalAllowedValueForIsOfType($arg1, $arg2, $arg3)
    {
        $this->createValidator($arg1, array(new $arg3($arg2)));
    }

    /**
     * @Given that minimal allowed value for :arg1 is :arg2
     */
    public function thatMinimalAllowedValueForIs($arg1, $arg2)
    {
        $this->createValidator($arg1, array($arg2));
    }

    /**
     * @Given that minimal allowed invalid value for :arg1 is :arg2
     */
    public function thatMinimalAllowedInvalidValueForIs($arg1, $arg2)
    {
        $this->createValidator($arg1, array($arg2));
    }
}

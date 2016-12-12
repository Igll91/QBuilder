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
class MinValidatorContext implements Context
{

    /**
     * @var Validator
     */
    private $validator;

    /**
     * Result of validation.
     *
     * @var mixed
     */
    private $result;

    /**
     * Catched error if any.
     *
     * @var Exception
     */
    private $error;

    private $namespace;

    public function __construct()
    {
        $reflectionClass = new ReflectionClass(Validator::class);
        $this->namespace = $reflectionClass->getNamespaceName() . '\\';
    }

    /**
     * @Given that minimal allowed value for :arg1 is :arg2
     */
    public function thatMinimalAllowedValueForIs($arg1, $arg2)
    {
        $class           = $this->namespace . $arg1;
        $this->validator = new $class($arg2);
    }

    /**
     * @Given that minimal allowed value for :arg1 is :arg2 of type :arg3
     */
    public function thatMinimalAllowedValueForIsOfType($arg1, $arg2, $arg3)
    {
        $class           = $this->namespace . $arg1;
        $this->validator = new $class(new $arg3($arg2));
    }

    /**
     * @When I try to validate value :arg1
     */
    public function iTryToValidateValue($arg1)
    {
        $this->result = $this->validator->validate($arg1);
    }

    /**
     * @When I try to validate value :arg1 of type :arg2
     */
    public function iTryToValidateValueOfType($arg1, $arg2)
    {
        $this->result = $this->validator->validate(new $arg2($arg1));
    }

    /**
     * @Given that minimal allowed invalid value for :arg1 is :arg2
     */
    public function thatMinimalAllowedInvalidValueForIs($arg1, $arg2)
    {
        try {
            $class           = $this->namespace . $arg1;
            $this->validator = new $class($arg2);
        } catch (Exception $ex) {
            $this->error = $ex;
        }
    }

    /**
     * @When I try to validate invalid value :arg1
     */
    public function iTryToValidateInvalidValue($arg1)
    {
        try {
            $this->validator->validate($arg1);
        } catch (Exception $ex) {
            $this->error = $ex;
        }
    }

}

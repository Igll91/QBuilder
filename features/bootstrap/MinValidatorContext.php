<?php

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
     * @When I try to validate value :arg1
     */
    public function iTryToValidateValue($arg1)
    {
        $this->result = $this->validator->validate($arg1);
    }

    /**
     * @Then validation should return false
     */
    public function validationShouldReturnFalse()
    {
        PHPUnit_Framework_Assert::assertFalse($this->result);
    }

    /**
     * @Then validation should return true
     */
    public function validationShouldReturnTrue()
    {
        PHPUnit_Framework_Assert::assertTrue($this->result);
    }

    /**
     * @Then I should get error :arg1
     */
    public function iShouldGetError($arg1)
    {
        PHPUnit_Framework_Assert::assertEquals($arg1, get_class($this->error));
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

}

<?php

use Behat\Behat\Context\Context;
use \AppBundle\Model\Validator\Validator;

/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 12.12.2016.
 * Time: 19:47
 */
abstract class ValidatorContext implements Context
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
     * Caught exception if any occurred.
     *
     * All exceptions should be caught in this variable.
     *
     * @var Exception
     */
    private $error;

    /**
     * Namespace of validation classes.
     *
     * @var string
     *
     * NOTE: redo differently
     */
    private $namespace;

    public function __construct()
    {
        $reflectionClass = new ReflectionClass(Validator::class);
        $this->namespace = $reflectionClass->getNamespaceName() . '\\';
    }

//======================================================================================================================
// CONSTRUCTION
//======================================================================================================================

    public function createValidator($className, $validatorArgs)
    {
        // TODO: Think about this one  and exception handling process inhere !

        try {
            $reflector       = new ReflectionClass($this->namespace . $className);
            $this->validator = $reflector->newInstanceArgs($validatorArgs);
        } catch (Exception $ex) {
            $this->error = $ex;
        }
    }

//======================================================================================================================
// VALIDATION
//======================================================================================================================

    /**
     * @When I try to validate value :arg1
     */
    public final function iTryToValidateValue($arg1)
    {
        $this->checkIfExceptionWasThrown();
        $this->executeOrCatch(function () use ($arg1) {
            $this->result = $this->validator->validate($arg1);
        });
    }

    /**
     * @When I try to validate value :arg1 of type :arg2
     */
    public final function iTryToValidateValueOfType($arg1, $arg2)
    {
        $this->checkIfExceptionWasThrown();
        $this->executeOrCatch(
            function () use ($arg1, $arg2) {
                $this->result = $this->validator->validate(new $arg2($arg1));
            }
        );
    }

    /**
     * Check if exception was raised by one of the previous steps.
     *
     * Throw that exception, because it was not supposed to happen at this step.
     */
    private final function checkIfExceptionWasThrown()
    {
        if ($this->error) {
            throw $this->error;
        }
    }

    /**
     *
     * @param callable $executable
     */
    private final function executeOrCatch(callable $executable)
    {
        try {
            $executable();
        } catch (Exception $ex) {
            $this->error = $ex;
        }
    }

//======================================================================================================================
// RESULT CHECKING
//======================================================================================================================

    /**
     * @Then validation should return false
     */
    public final function validationShouldReturnFalse()
    {
        PHPUnit_Framework_Assert::assertFalse($this->result);
    }

    /**
     * @Then validation should return true
     */
    public final function validationShouldReturnTrue()
    {
        PHPUnit_Framework_Assert::assertTrue($this->result);
    }


    /**
     * @Then I should get error :arg1
     */
    public final function iShouldGetError($arg1)
    {
        PHPUnit_Framework_Assert::assertEquals($arg1, get_class($this->error));
    }

}
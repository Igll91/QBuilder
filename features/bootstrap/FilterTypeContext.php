<?php

/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 14.12.2016.
 * Time: 21:11
 */
class FilterTypeContext implements \Behat\Behat\Context\Context
{

    /**
     * @var \AppBundle\Model\Filter\FilterType
     */
    private $filterType;

    /**
     * @var bool
     */
    private $result;

    /**
     * Namespace of filter type classes.
     *
     * @var string
     */
    private $namespace;

    public function __construct()
    {
        $reflectionClass = new ReflectionClass(\AppBundle\Model\Filter\FilterType::class);
        $this->namespace = $reflectionClass->getNamespaceName() . '\\';
    }

    /**
     * @Given that we use :arg1
     */
    public function thatWeUse($arg1)
    {
        $reflector        = new ReflectionClass($this->namespace . $arg1);
        $this->filterType = $reflector->newInstanceArgs();
    }

    /**
     * @When I try to validate value :arg1
     */
    public function iTryToValidateValue($arg1)
    {
        $this->result = $this->filterType->validateValue($arg1);
    }

    /**
     * @When I try to validate boolean value
     */
    public function iTryToValidateBooleanValue()
    {
        $this->result = $this->filterType->validateValue(TRUE);
    }

    /**
     * @When I try to validate non boolean value
     */
    public function iTryToValidateNonBooleanValue()
    {
        $this->result = $this->filterType->validateValue("random string");
    }

    /**
     * @Then I should get :arg1
     */
    public function iShouldGet($arg1)
    {
        PHPUnit_Framework_Assert::assertEquals(filter_var($arg1, FILTER_VALIDATE_BOOLEAN), $this->result);
    }

}

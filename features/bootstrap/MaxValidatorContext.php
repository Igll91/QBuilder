<?php

/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 12.12.2016.
 * Time: 19:41
 */
class MaxValidatorContext extends ValidatorContext
{

    /**
     * @Given that maximal allowed value for :arg1 is :arg2
     */
    public function thatMaximalAllowedValueForIs($arg1, $arg2)
    {
        $this->createValidator($arg1, array($arg2));
    }

    /**
     * @Given that maximal allowed invalid value for :arg1 is :arg2
     */
    public function thatMaximalAllowedInvalidValueForIs($arg1, $arg2)
    {
        $this->createValidator($arg1, array($arg2));
    }
}

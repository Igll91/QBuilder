<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 20.12.2016.
 * Time: 20:25
 */

namespace AppBundle\Model\ValueHolder;

/**
 * Holds collection of IValueHolder objects.
 *
 * Class ConditionOperatorValueHolder
 * @package AppBundle\Model\ValueHolder
 */
abstract class ConditionOperatorValueHolder implements IValueHolder
{
    /**
     * Collection of other IValueHolder implementation objects.
     *
     * @var IValueHolder[]
     */
    private $valueHolders;

    public function __construct()
    {
        $this->valueHolders = array();
    }

//======================================================================================================================
// GETTERS & SETTERS
//======================================================================================================================

    public function getValue()
    {
        return $this->valueHolders;
    }

    public function addValueHolder(IValueHolder $valueHolder)
    {
        $this->valueHolders[] = $valueHolder;
    }

    public function addAllValueHolders(array $valueHolders)
    {
        array_walk($valueHolders, array($this, 'addValueHolder'));
    }
}

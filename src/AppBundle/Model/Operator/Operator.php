<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 13.12.2016.
 * Time: 22:48
 */

namespace AppBundle\Model\Operator;


abstract class Operator
{

    /**
     * Identifier of the operator.
     *
     * @var string
     */
    private $type;

    /**
     * The number of inputs.
     *
     * @var int
     */
    private $numberOfInputs;

    /**
     * Inform the builder that each input can have multiple values.
     *
     * @var bool
     */
    private $multiple;

    /**
     * Optional id of an <optgroup> in the operators dropdown.
     *
     * @var string
     */
    private $optgroup;

    public function __construct($type, $multiple, $numberOfInputs)
    {
        $this->type           = $type;
        $this->multiple       = $multiple;
        $this->numberOfInputs = $numberOfInputs;
    }

    public function __toString()
    {
        return $this->type;
    }

//======================================================================================================================
// GETTERS & SETTERS
//======================================================================================================================

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getNumberOfInputs()
    {
        return $this->numberOfInputs;
    }

    /**
     * @return boolean
     */
    public function isMultiple()
    {
        return $this->multiple;
    }

    /**
     * @return string
     */
    public function getOptgroup()
    {
        return $this->optgroup;
    }

    /**
     * @param string $optgroup
     */
    public function setOptgroup($optgroup)
    {
        $this->optgroup = $optgroup;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 14.12.2016.
 * Time: 19:39
 */

namespace AppBundle\Model\Filter\Type;


abstract class FilterType
{

    /**
     * Identifier used by frontend.
     *
     * @var string
     */
    private $identifier;

    public function __construct($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Value if passed value matches required type.
     *
     * @return boolean True if valid, false otherwise.
     */
    public abstract function validateValue($value);

//======================================================================================================================
// GETTERS & SETTERS
//======================================================================================================================

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

}
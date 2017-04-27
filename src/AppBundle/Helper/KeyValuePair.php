<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 26.04.2017.
 * Time: 22:07
 */

namespace AppBundle\Helper;

class KeyValuePair
{
    private $key;
    private $value;

    public function __construct($key, $value)
    {
        ValueChecker::getStringOrEx($key);

        $this->key   = $key;
        $this->value = $value;
    }

//======================================================================================================================
// GETTERS & SETTERS
//======================================================================================================================

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
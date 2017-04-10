<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 20.12.2016.
 * Time: 20:37
 */

namespace AppBundle\Model\ValueHolder;

use AppBundle\Model\Filter\Filter;
use AppBundle\Model\Operator\Operator;

class ValueHolder implements IValueHolder
{
    /**
     * Selected Filter.
     *
     * @var Filter
     */
    private $filter;

    /**
     * Selected operator.
     *
     * @var Operator
     */
    private $operator;

    /**
     * Inserted value/s.
     *
     * @var mixed
     */
    private $value;

    public function __construct(Filter $filter, Operator $operator, $value)
    {
        $this->filter   = $filter;
        $this->operator = $operator;
        $this->value    = $value;
    }

//======================================================================================================================
// GETTERS & SETTERS
//======================================================================================================================

    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return Filter
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @return Operator
     */
    public function getOperator()
    {
        return $this->operator;
    }
}

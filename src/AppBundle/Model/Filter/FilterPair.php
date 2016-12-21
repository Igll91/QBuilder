<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 20.12.2016.
 * Time: 22:24
 */

namespace AppBundle\Model\Filter;

use AppBundle\Model\Filter;
use AppBundle\Model\Operator\Operator;

class FilterPair
{
    /**
     * @var Filter
     */
    private $filter;

    /**
     * Operators applicable for this filter.
     *
     * @var array List of Operator objects.
     */
    private $operators;

    public function __construct(Filter $filter)
    {
        $this->filter    = $filter;
        $this->operators = array();
    }

    public function addOperator(Operator $operator)
    {
        if (array_key_exists($operator->getType(), $this->operators)) {
            throw new \InvalidArgumentException("Operator already inserted!");
        }

        $this->operators[] = $operator;
    }

//======================================================================================================================
// GETTERS & SETTERS
//======================================================================================================================

    /**
     * @return Filter
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @return array
     */
    public function getOperators()
    {
        return $this->operators;
    }
}

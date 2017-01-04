<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 20.12.2016.
 * Time: 22:24
 */

namespace AppBundle\Model\Filter;

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

//======================================================================================================================
// SEARCHERS
//======================================================================================================================

    public function hasOperator(Operator $operator)
    {
        return in_array($operator, $this->operators);
    }

    /**
     * Search operator by type.
     *
     * @param $type string Type to be searched.
     *
     * @return Operator|null Operator if found, else null.
     */
    public function findOperatorByType($type)
    {
        foreach ($this->operators as $operator) {
            if ($operator->getType() === $type) {
                return $operator;
            }
        }

        return null;
    }

//======================================================================================================================
// INSERTION
//======================================================================================================================

    public function addOperator(Operator $operator)
    {
        if (array_key_exists($operator->getType(), $this->operators)) {
            throw new \InvalidArgumentException("Operator already inserted!");
        }

        $this->operators[] = $operator;
    }

    public function addOperators(array $operators)
    {
        array_walk($operators, array($this, 'addOperator'));
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

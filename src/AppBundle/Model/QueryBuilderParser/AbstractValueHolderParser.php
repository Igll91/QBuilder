<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 12.04.2017.
 * Time: 20:20
 */

namespace AppBundle\Model\QueryBuilderParser;

use AppBundle\Model\Filter\Filter;
use AppBundle\Model\RelationParser\RelationHolder;
use AppBundle\Model\ValueHolder\ValueHolder;

abstract class AbstractValueHolderParser
{
    private $relationHolder;
    private $relationDelimiter;
    private $rootAlias;

    public function __construct(RelationHolder $relationHolder, $rootAlias, $relationDelimiter = '.')
    {
        $this->relationHolder    = $relationHolder;
        $this->relationDelimiter = $relationDelimiter;
        $this->rootAlias         = $rootAlias;
    }

    /**
     * Parse valueHolder with corresponding operator function into queryable entity.
     *
     * @param ValueHolder $valueHolder Contains Operator, Field and value required for building query.
     *
     * @return mixed Inherited implementation specific.
     */
    public function parse(ValueHolder $valueHolder)
    {
        $operatorReflection = new \ReflectionClass($valueHolder->getOperator());
        $params             = [$valueHolder];

        return call_user_func_array([$this, 'parse'.$operatorReflection->getShortName()], $params);
    }

    /**
     * Replaces filter field relation identifiers with relation aliases.
     *
     * <pre>
     * Example:
     *  Given that filter identifier is equal to: 'parent_relation.field_id'
     *  For parent filter key, which in this case is 'parent_relation'
     *  Search alias for parent filter key
     *  Prepend filter field identifier with parent alias.
     *
     *  In case that filter is root entity/table field
     *  Prepend root alias to the filter field identifier.
     *
     *  Why?: to avoid ambiguous column names.
     * </pre>
     *
     * @param Filter $filter
     *
     * @return string
     */
    protected function getFieldIdentifier(Filter $filter)
    {
        $filterId     = $filter->getIdentifier();
        $delimiterPos = strrpos($filterId, $this->relationDelimiter);

        if ($delimiterPos !== false) {
            $relationKey = substr($filterId, 0, $delimiterPos);
            $relation    = $this->relationHolder->getRelationByKey($relationKey);

            return $relation->getAlias().substr($filterId, $delimiterPos);
        } else {
            return ''.$this->rootAlias.$this->relationDelimiter.$filterId;
        }
    }

//======================================================================================================================
// ABSTRACT FUNCTIONS
//======================================================================================================================

    abstract public function parseBeginsWithOperator(ValueHolder $valueHolder);

    abstract public function parseBetweenOperator(ValueHolder $valueHolder);

    abstract public function parseContainsOperator(ValueHolder $valueHolder);

    abstract public function parseEndsWithOperator(ValueHolder $valueHolder);

    abstract public function parseEqualOperator(ValueHolder $valueHolder);

    abstract public function parseGreaterOperator(ValueHolder $valueHolder);

    abstract public function parseGreaterOrEqualOperator(ValueHolder $valueHolder);

    abstract public function parseInOperator(ValueHolder $valueHolder);

    abstract public function parseIsEmptyOperator(ValueHolder $valueHolder);

    abstract public function parseIsNotEmptyOperator(ValueHolder $valueHolder);

    abstract public function parseIsNotNullOperator(ValueHolder $valueHolder);

    abstract public function parseIsNullOperator(ValueHolder $valueHolder);

    abstract public function parseLessOperator(ValueHolder $valueHolder);

    abstract public function parseLessOrEqualOperator(ValueHolder $valueHolder);

    abstract public function parseNotBeginsWithOperator(ValueHolder $valueHolder);

    abstract public function parseNotBetweenOperator(ValueHolder $valueHolder);

    abstract public function parseNotContainsOperator(ValueHolder $valueHolder);

    abstract public function parseNotEndsWithOperator(ValueHolder $valueHolder);

    abstract public function parseNotEqualOperator(ValueHolder $valueHolder);

    abstract public function parseNotInOperator(ValueHolder $valueHolder);
}

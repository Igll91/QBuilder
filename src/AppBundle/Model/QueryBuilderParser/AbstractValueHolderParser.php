<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 12.04.2017.
 * Time: 20:20
 */

namespace AppBundle\Model\QueryBuilderParser;

use AppBundle\Model\Filter\Filter;
use AppBundle\Model\Operator\BeginsWithOperator;
use AppBundle\Model\Operator\BetweenOperator;
use AppBundle\Model\Operator\Operator;
use AppBundle\Model\RelationParser\RelationHolder;
use AppBundle\Model\ValueHolder\ValueHolder;

abstract class AbstractValueHolderParser
{
    private $relationHolder;
    private $relationDelimiter;

    public function __construct(RelationHolder $relationHolder, $relationDelimiter = '.')
    {
        $this->relationHolder    = $relationHolder;
        $this->relationDelimiter = $relationDelimiter;
    }

    public function parse(ValueHolder $valueHolder)
    {
        $operatorReflection = new \ReflectionClass($valueHolder->getOperator());
        $params             = [$valueHolder->getOperator(), $valueHolder->getValue()];

        return call_user_func_array('parse'.$operatorReflection->getShortName(), $params);
    }

    protected function getFieldIdentifier(Filter $filter)
    {
        $filterId     = $filter->getIdentifier();
        $delimiterPos = strpos($filterId, $this->relationDelimiter);

        if ($delimiterPos !== false) {
            return substr($filterId, 0, $delimiterPos);
        } else {
            return $filterId;
        }
    }

    public abstract function parseBeginsWithOperator(ValueHolder $valueHolder);

    public abstract function parseBetweenOperator(ValueHolder $valueHolder);

    public abstract function parseContainsOperator(ValueHolder $valueHolder);

    public abstract function parseEndsWithOperator(ValueHolder $valueHolder);

    public abstract function parseEqualOperator(ValueHolder $valueHolder);

    public abstract function parseGreaterOperator(ValueHolder $valueHolder);

    public abstract function parseGreaterOrEqualOperator(ValueHolder $valueHolder);

    public abstract function parseInOperator(ValueHolder $valueHolder);

    public abstract function parseIsEmptyOperator(ValueHolder $valueHolder);

    public abstract function parseIsNotEmptyOperator(ValueHolder $valueHolder);

    public abstract function parseIsNotNullOperator(ValueHolder $valueHolder);

    public abstract function parseIsNullOperator(ValueHolder $valueHolder);

    public abstract function parseLessOperator(ValueHolder $valueHolder);

    public abstract function parseLessOrEqualOperator(ValueHolder $valueHolder);

    public abstract function parseNotBeginsWithOperator(ValueHolder $valueHolder);

    public abstract function parseNotBetweenOperator(ValueHolder $valueHolder);

    public abstract function parseNotContainsOperator(ValueHolder $valueHolder);

    public abstract function parseNotEndsWithOperator(ValueHolder $valueHolder);

    public abstract function parseNotEqualOperator(ValueHolder $valueHolder);

    public abstract function parseNotInOperator(ValueHolder $valueHolder);
}
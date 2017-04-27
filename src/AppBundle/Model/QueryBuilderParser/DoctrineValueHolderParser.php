<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 12.04.2017.
 * Time: 20:41
 */

namespace AppBundle\Model\QueryBuilderParser;

use AppBundle\Helper\KeyValuePair;
use AppBundle\Model\Filter\Type\DateFilterType;
use AppBundle\Model\Filter\Type\DateTimeFilterType;
use AppBundle\Model\ValueHolder\ValueHolder;
use Doctrine\ORM\Query\Expr;

class DoctrineValueHolderParser extends AbstractValueHolderParser
{
    /**
     * Combines expression and value into single DoctrineExpressionHolder object.
     *
     * Takes expression name and builds it with value literal. Assigns random unique key for value.
     * Key is placed instead of value so we can parameterize SQL queries with given key and value.
     *
     * @param ValueHolder $valueHolder
     * @param string      $exprMethod One of doctrine expressions (e.g. eq, like...).
     * @param string      $value      Replaces ValueHolder value.
     *
     * @return DoctrineExpressionHolder Object holding expression and key value parameter pairs.
     */
    private function simpleExprHolder(ValueHolder $valueHolder, $exprMethod, $value = null)
    {
        $expr     = new Expr();
        $paramKey = uniqid($valueHolder->getFID());

        if ($valueHolder->getOperator()->isMultiple()) {
            $paramValue = $value ? $value : $valueHolder->getValue();
        } else {
            $paramValue = $expr->literal($value ? $value : $valueHolder->getValue());
        }

        $expr       = $expr->$exprMethod($this->getFieldIdentifier($valueHolder->getFilter()), ":$paramKey");
        $exprHolder = new DoctrineExpressionHolder($expr);
        $exprHolder->addKeyValuePair(new KeyValuePair($paramKey, $paramValue));

        return $exprHolder;
    }

    /**
     * Creates DoctrineExpressionHolder by applying Not expression on calling function.
     *
     * Doctrine creates NOT expressions by applying not to other expressions.
     * We reuse defined operator definitions and apply not expression on them.
     * NOTE: only for NOT expression functions.
     *
     * @param $valueHolder
     *
     * @return DoctrineExpressionHolder
     */
    private function parseNotOperator($valueHolder)
    {
        $dbt     = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
        $baseFun = str_replace('Not', '', $dbt[1]['function']);

        $expr       = new Expr();
        $exprHolder = $this->$baseFun($valueHolder);
        $exprHolder->setExpression($expr->not($exprHolder->getExpression()));

        return $exprHolder;
    }

//======================================================================================================================
// OPERATOR FUNCTIONS
//======================================================================================================================

    public function parseBetweenOperator(ValueHolder $valueHolder)
    {
        $expr       = new Expr();
        $values     = $valueHolder->getValue();
        $paramKeyX  = uniqid($valueHolder->getFID().'X');
        $paramKeyY  = uniqid($valueHolder->getFID().'Y');
        $exprHolder = new DoctrineExpressionHolder($expr);

        switch ($valueHolder->getFilter()->getType()) {
            case DateFilterType::class:
            case DateTimeFilterType::class:
                $exprHolder->addKeyValuePair(new KeyValuePair($paramKeyX,
                    $expr->literal($values[0]->format('Y-m-d H:i:s'))));
                $exprHolder->addKeyValuePair(new KeyValuePair($paramKeyY,
                    $expr->literal($values[1]->format('Y-m-d H:i:s'))));
                break;
            default:
                $exprHolder->addKeyValuePair(new KeyValuePair($paramKeyX, $expr->literal($values[0])));
                $exprHolder->addKeyValuePair(new KeyValuePair($paramKeyY, $expr->literal($values[1])));
                break;
        }

        $expr = $expr->between($this->getFieldIdentifier($valueHolder->getFilter()), ":$paramKeyX",
            ":$paramKeyY");

        return $exprHolder;
    }

    public function parseBeginsWithOperator(ValueHolder $valueHolder)
    {
        return $this->simpleExprHolder($valueHolder, 'like', $valueHolder->getValue().'%');
    }

    public function parseContainsOperator(ValueHolder $valueHolder)
    {
        return $this->simpleExprHolder($valueHolder, "like", '%'.$valueHolder->getValue().'%');
    }

    public function parseEndsWithOperator(ValueHolder $valueHolder)
    {
        return $this->simpleExprHolder($valueHolder, 'like', '%'.$valueHolder->getValue());
    }

    public function parseEqualOperator(ValueHolder $valueHolder)
    {
        return $this->simpleExprHolder($valueHolder, 'eq');
    }

    public function parseGreaterOperator(ValueHolder $valueHolder)
    {
        return $this->simpleExprHolder($valueHolder, 'gt');
    }

    public function parseGreaterOrEqualOperator(ValueHolder $valueHolder)
    {
        return $this->simpleExprHolder($valueHolder, 'gte');
    }

    public function parseInOperator(ValueHolder $valueHolder)
    {
        return $this->simpleExprHolder($valueHolder, 'in');
    }

    public function parseIsEmptyOperator(ValueHolder $valueHolder)
    {
        // TODO: Implement parseIsEmptyOperator() method.
    }

    public function parseIsNotEmptyOperator(ValueHolder $valueHolder)
    {
        // TODO: Implement parseIsNotEmptyOperator() method.
    }

    public function parseIsNotNullOperator(ValueHolder $valueHolder)
    {
        $expr = new Expr();
        $expr = $expr->isNotNull($this->getFieldIdentifier($valueHolder->getFilter()));

        return new DoctrineExpressionHolder($expr);
    }

    public function parseIsNullOperator(ValueHolder $valueHolder)
    {
        $expr = new Expr();
        $expr = $expr->isNull($this->getFieldIdentifier($valueHolder->getFilter()));

        return new DoctrineExpressionHolder($expr);
    }

    public function parseLessOperator(ValueHolder $valueHolder)
    {
        return $this->simpleExprHolder($valueHolder, 'lt');
    }

    public function parseLessOrEqualOperator(ValueHolder $valueHolder)
    {
        return $this->simpleExprHolder($valueHolder, 'lte');
    }

    public function parseNotBeginsWithOperator(ValueHolder $valueHolder)
    {
        return $this->parseNotOperator($valueHolder);
    }

    public function parseNotBetweenOperator(ValueHolder $valueHolder)
    {
        return $this->parseNotOperator($valueHolder);
    }

    public function parseNotContainsOperator(ValueHolder $valueHolder)
    {
        return $this->parseNotOperator($valueHolder);
    }

    public function parseNotEndsWithOperator(ValueHolder $valueHolder)
    {
        return $this->parseNotOperator($valueHolder);
    }

    public function parseNotEqualOperator(ValueHolder $valueHolder)
    {
        return $this->parseNotOperator($valueHolder);
    }

    public function parseNotInOperator(ValueHolder $valueHolder)
    {
        return $this->parseNotOperator($valueHolder);
    }
}

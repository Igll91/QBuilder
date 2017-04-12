<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 12.04.2017.
 * Time: 20:41
 */

namespace AppBundle\Model\QueryBuilderParser;

use AppBundle\Model\Filter\Type\DateFilterType;
use AppBundle\Model\Filter\Type\DateTimeFilterType;
use AppBundle\Model\ValueHolder\ValueHolder;
use Doctrine\ORM\Query\Expr;

class DoctrineValueHolderParser extends AbstractValueHolderParser
{
    public function parseBeginsWithOperator(ValueHolder $valueHolder)
    {
        $expr = new Expr();

        return $expr->like($this->getFieldIdentifier($valueHolder->getFilter()), $valueHolder->getValue().'%');
    }

    public function parseBetweenOperator(ValueHolder $valueHolder)
    {
        $expr   = new Expr();
        $values = $valueHolder->getValue();

        switch ($valueHolder->getFilter()->getType()) {
        case DateFilterType::class:
        case DateTimeFilterType::class:
            return $expr->between(
                $this->getFieldIdentifier($valueHolder->getFilter()),
                $values[0]->format('Y-m-d H:i:s'),
                $values[1]->format('Y-m-d H:i:s')
            );
        default:
            return $expr->between($this->getFieldIdentifier($valueHolder->getFilter()), $values[0], $values[1]);
        }
    }

    public function parseContainsOperator(ValueHolder $valueHolder)
    {
        $expr = new Expr();

        return $expr->like($this->getFieldIdentifier($valueHolder->getFilter()), '%'.$valueHolder->getValue().'%');
    }

    public function parseEndsWithOperator(ValueHolder $valueHolder)
    {
        $expr = new Expr();

        return $expr->like($this->getFieldIdentifier($valueHolder->getFilter()), '%'.$valueHolder->getValue());
    }

    public function parseEqualOperator(ValueHolder $valueHolder)
    {
        $expr = new Expr();

        return $expr->eq($this->getFieldIdentifier($valueHolder->getFilter()), $valueHolder->getValue());
    }

    public function parseGreaterOperator(ValueHolder $valueHolder)
    {
        $expr = new Expr();

        return $expr->gt($this->getFieldIdentifier($valueHolder->getFilter()), $valueHolder->getValue());
    }

    public function parseGreaterOrEqualOperator(ValueHolder $valueHolder)
    {
        $expr = new Expr();

        return $expr->gte($this->getFieldIdentifier($valueHolder->getFilter()), $valueHolder->getValue());
    }

    public function parseInOperator(ValueHolder $valueHolder)
    {
        $expr = new Expr();

        return $expr->in($this->getFieldIdentifier($valueHolder->getFilter()), $valueHolder->getValue());
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

        return $expr->isNotNull($valueHolder->getFID());
    }

    public function parseIsNullOperator(ValueHolder $valueHolder)
    {
        $expr = new Expr();

        return $expr->isNull($valueHolder->getFID());
    }

    public function parseLessOperator(ValueHolder $valueHolder)
    {
        $expr = new Expr();

        return $expr->lt($this->getFieldIdentifier($valueHolder->getFilter()), $valueHolder->getValue());
    }

    public function parseLessOrEqualOperator(ValueHolder $valueHolder)
    {
        $expr = new Expr();

        return $expr->lte($this->getFieldIdentifier($valueHolder->getFilter()), $valueHolder->getValue());
    }

    public function parseNotBeginsWithOperator(ValueHolder $valueHolder)
    {
        $expr = new Expr();

        return $expr->not($this->parseBeginsWithOperator($valueHolder));
    }

    public function parseNotBetweenOperator(ValueHolder $valueHolder)
    {
        $expr = new Expr();

        return $expr->not($this->parseBetweenOperator($valueHolder));
    }

    public function parseNotContainsOperator(ValueHolder $valueHolder)
    {
        $expr = new Expr();

        return $expr->not($this->parseContainsOperator($valueHolder));
    }

    public function parseNotEndsWithOperator(ValueHolder $valueHolder)
    {
        $expr = new Expr();

        return $expr->not($this->parseEndsWithOperator($valueHolder));
    }

    public function parseNotEqualOperator(ValueHolder $valueHolder)
    {
        $expr = new Expr();

        return $expr->not($this->parseEqualOperator($valueHolder));
    }

    public function parseNotInOperator(ValueHolder $valueHolder)
    {
        $expr = new Expr();

        return $expr->not($this->parseInOperator($valueHolder));
    }

}
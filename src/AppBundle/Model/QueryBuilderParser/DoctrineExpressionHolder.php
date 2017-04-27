<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 26.04.2017.
 * Time: 21:58
 */

namespace AppBundle\Model\QueryBuilderParser;

use AppBundle\Helper\KeyValuePair;
use Doctrine\ORM\Query\Expr;

class DoctrineExpressionHolder
{
    private $expression;
    private $keyValuePairs;

    public function __construct($expr)
    {
        $this->expression    = $expr;
        $this->keyValuePairs = [];
    }

    public function addKeyValuePair(KeyValuePair $keyValuePair)
    {
        $this->keyValuePairs[] = $keyValuePair;
    }

    public function addKeyValuePairs(array $keyValuePairs)
    {
        call_user_func_array('addKeyValuePair', $keyValuePairs);
    }

//======================================================================================================================
// GETTERS & SETTERS
//======================================================================================================================

    /**
     * @param mixed $expression
     */
    public function setExpression($expression)
    {
        $this->expression = $expression;
    }

    /**
     * @return Expr
     */
    public function getExpression()
    {
        return $this->expression;
    }

    /**
     * @return KeyValuePair[]
     */
    public function getKeyValuePairs()
    {
        return $this->keyValuePairs;
    }
}

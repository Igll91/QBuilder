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

/**
 * Holds one of doctrine query expression and list of KeyValuePair objects.
 *
 * Expression should be used in combination with KeyValuePair's to build parameterized query.
 *
 * Class DoctrineExpressionHolder
 * @package AppBundle\Model\QueryBuilderParser
 */
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
        array_walk($keyValuePairs, array($this, 'addKeyValuePair'));
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

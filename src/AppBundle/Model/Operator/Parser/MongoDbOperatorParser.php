<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 02.01.2017.
 * Time: 22:24
 */

namespace AppBundle\Model\Operator\Parser;

use AppBundle\Helper\ValueChecker;
use AppBundle\Model\Operator\BeginsWithOperator;
use AppBundle\Model\Operator\BetweenOperator;
use AppBundle\Model\Operator\ContainsOperator;
use AppBundle\Model\Operator\EndsWithOperator;
use AppBundle\Model\Operator\EqualOperator;
use AppBundle\Model\Operator\GreaterOperator;
use AppBundle\Model\Operator\GreaterOrEqualOperator;
use AppBundle\Model\Operator\InOperator;
use AppBundle\Model\Operator\IsEmptyOperator;
use AppBundle\Model\Operator\IsNotEmptyOperator;
use AppBundle\Model\Operator\IsNotNullOperator;
use AppBundle\Model\Operator\IsNullOperator;
use AppBundle\Model\Operator\LessOperator;
use AppBundle\Model\Operator\LessOrEqualOperator;
use AppBundle\Model\Operator\NotBeginsWithOperator;
use AppBundle\Model\Operator\NotBetweenOperator;
use AppBundle\Model\Operator\NotContainsOperator;
use AppBundle\Model\Operator\NotEndsWithOperator;
use AppBundle\Model\Operator\NotEqualOperator;
use AppBundle\Model\Operator\NotInOperator;
use AppBundle\Model\Operator\Operator;

class MongoDbOperatorParser implements IOperatorParser
{
    /**
     * @param mixed $value
     *
     * @return Operator|null
     *
     */
    public function parse($value)
    {
        $operator = null;

        if (is_array($value)) {
            $keys         = array_keys($value);
            $values       = array_values($value);
            $operatorSize = count($value);

            if ($operatorSize === 1) {
                switch ($keys[0]) {
                    case '$gt':
                        $operator = new GreaterOperator();
                        break;
                    case '$gte':
                        $operator = new GreaterOrEqualOperator();
                        break;
                    case '$lt':
                        $operator = new LessOperator();
                        break;
                    case '$lte':
                        $operator = new LessOrEqualOperator();
                        break;
                    case '$in':
                        $operator = new InOperator();
                        break;
                    case '$nin':
                        $operator = new NotInOperator();
                        break;
                    case '$ne':
                        $operator = $this->getEqualityOperator($values[0], true);
                        break;
                    case '$regex':
                        $regexValue = ValueChecker::getStringOrEx($values[0]);
                        $operator   = $this->getRegexOperator($regexValue);
                        break;
                }
            } elseif ($operatorSize === 2) {
                $operator = $this->handleTwoSizedOperators($keys, $values);
            } else {
                throw new \InvalidArgumentException('Unsupported number of operator values.');
            }
        } else {
            $operator = $this->getEqualityOperator($value, false);
        }

        return $operator;
    }

    private function handleTwoSizedOperators($keys, $values)
    {
        $operator = null;

        if ($keys[0] == '$regex') {
            // NOTE: separate regex function?
            $operator = $this->getRegexOperator($values[0]);
        } elseif ($keys[0] === '$gte' && $keys[1] === '$lte') {
            $operator = new BetweenOperator();
        } elseif ($keys[0] === '$lt' && $keys[1] === '$gt') {
            $operator = new NotBetweenOperator();
        }

        return $operator;
    }

    private function getEqualityOperator($value, $useNot)
    {
        $operator = null;

        if ($value === null) {
            $operator = $useNot ? new IsNotNullOperator() : new IsNullOperator();
        } elseif ($value === '') {
//            NOTICE: can raise error if operator is not among available ones, and empty string was
//            passed as value
            $operator = $useNot ? new IsNotEmptyOperator() : new IsEmptyOperator();
        } else {
            $operator = $useNot ? new NotEqualOperator() : new EqualOperator();
        }

        return $operator;
    }

    /**
     * @param $value
     *
     * @return null
     *
     */
    private function getRegexOperator($value)
    {
        $operator = null;

        // "$regex": "^asd"             - begins with
        // "$regex": "^(?!asd)"         - doesn't begin with
        // "$regex": "asd"              - contains
        // "$regex": "asd$"             - ends with
        // "$regex": "(?<!asd)$"        - doesn't end with
        // "$regex": "^((?!asd).)*$"    - doesn't contain (note - second parameter: "$options": "s")

        switch (true) {
            case preg_match('/^\(\?\<\![[:print:]]*\)\$$/', $value):
                $operator = new NotEndsWithOperator();
                break;
            case preg_match('/^\^\(\?\!([[:print:]]|\p{L})*\)$/', $value):
                $operator = new NotBeginsWithOperator();
                break;
            case preg_match('/^\^\(\(\?\!([[:print:]]|\p{L})*\)\.\)\*\$$/', $value):
                $operator = new NotContainsOperator();
                break;
            case preg_match('/^([[:print:]]|\p{L})*\$$/', $value):
                $operator = new EndsWithOperator();
                break;
            case preg_match('/^\^([[:print:]]|\p{L})*$/', $value):
                $operator = new BeginsWithOperator();
                break;
            default:
                $operator = new ContainsOperator();
                break;
        }

        return $operator;
    }
}

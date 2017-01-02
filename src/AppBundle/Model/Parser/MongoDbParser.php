<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 20.12.2016.
 * Time: 19:22
 */

namespace AppBundle\Model\Parser;

use AppBundle\Helper\JsonHelper;
use AppBundle\Helper\ValueChecker;
use AppBundle\Model\Filter\FilterPair;
use AppBundle\Model\Operator\EqualOperator;
use AppBundle\Model\Operator\IsNullOperator;
use AppBundle\Model\Operator\Operator;
use AppBundle\Model\Parser\ValueHolder\MongoDbOperatorValueParser;
use AppBundle\Model\ValueHolder\OperatorValueHolder;

class MongoDbParser extends Parser
{

    public function parseQuery($query)
    {
        $mongoDbQuery = JsonHelper::decode($query, true);

        dump($mongoDbQuery);

        foreach ($mongoDbQuery->getResult() as $key => $value) {
            dump($key);
            dump($value);
        }

        $this->getValues($mongoDbQuery->getResult(), 0);

        die();

        // TODO: Implement parseQuery() method.
        // first key must be either And or Or .. iterationCounter
    }

    /**
     * TODO: explanation
     *
     * @param array $mongoDbQuery
     * @param  int  $iterationLevel Query nesting level.
     *
     * @return OperatorValueHolder Main level OperatorValueHolder.
     */
    private function getValues(array $mongoDbQuery, $iterationLevel)
    {
        if ($iterationLevel === 0) {
            if (count($mongoDbQuery) !== 1) {
                throw new \InvalidArgumentException('There can be only one outer(main) operator holder.');
            }

            // TODO: get only key and val of first element (remove foreach)
            foreach ($mongoDbQuery as $key => $value) {
                $operatorValueHolder = MongoDbOperatorValueParser::parse($key);

                if (is_array($value) && $operatorValueHolder && (count($value) > 0)) {
                    $this->getValues($value, $iterationLevel + 1); //TODO: delete
//                    $operatorValueHolder->addValueHolder($this->getValues($value, $iterationCounter + 1));

                    return $operatorValueHolder;
                } else {
                    throw new \InvalidArgumentException('Invalid outer(main) operator holder.');
                }
            }
        } else {
            $queries = array();

            foreach ($mongoDbQuery as $cQuery) {
                if (is_array($cQuery) === false || count($cQuery) !== 1) {
                    throw new \InvalidArgumentException('Invalid query syntax.');
                }

                $cQueryKey           = array_keys($cQuery)[0];
                $cQueryVal           = array_values($cQuery)[0];
                $operatorValueHolder = MongoDbOperatorValueParser::parse($cQueryKey);

                dump('key: ' . $cQueryKey . ' at level ' . $iterationLevel);
                dump($cQueryVal);

                if ($operatorValueHolder) {
                    $this->getValues($cQueryVal, $iterationLevel + 1);
//                    $queries[] = $operatorValueHolder->addAllValueHolders();
                } else {
                    $filterPair = $this->filterPairHolder->getByFilterId($cQueryKey);
                    ValueChecker::throwExIfNull($filterPair);
                    $operator = $this->getOperator($cQueryVal);
                    //TODO: operator must not be null and must be in filterPair list of operators
                    // TODO: validate value with filter type !
                    // TODO: validate value with filter validators !
                }
            }
        }
    }

    /**
     * TODO: documentation with examples
     *
     * @param $value
     *
     * @return Operator|null
     */
    private function getOperator($value)
    {
        // RETHINK THIS PART AGAIN...

        if (is_array($value)) {
            //TODO: handle operator
            $operatorSize = count($value);
            if ($operatorSize === 1) {

            } else {

            }
        } else {
            switch (true) {
                case $value === null:
                    return new IsNullOperator();
                    break;
                default:
                    return new EqualOperator();
                    break;
            }
        }

        return null;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 04.01.2017.
 * Time: 19:02
 */

namespace AppBundle\Model\Parser;

use AppBundle\Helper\JsonHelper;
use AppBundle\Helper\ValueChecker;
use AppBundle\Model\ValueHolder\ConditionOperatorValueHolder;
use AppBundle\Model\ValueHolder\Parser\RuleConditionOperatorValueHolderParser;
use AppBundle\Model\ValueHolder\ValueHolder;

class RuleParser extends Parser
{
    public function parseQuery($query)
    {
        $query = ValueChecker::getStringOrEx($query);
        $json  = JsonHelper::decode($query);

        dump($json);

        $asd = $this->parseConditionOperator($json->getResult(), 0);

        dump($asd);
        die();
    }

    /**
     * Parses rules that are part of current iteration ConditionOperatorValueHolder.
     *
     * TODO: explanation
     *
     * @param \stdClass $rule           Current set of rules that will be parsed.
     * @param  int      $iterationLevel Nesting level.
     *
     * @return ConditionOperatorValueHolder Main level ConditionOperatorValueHolder.
     */
    private function parseConditionOperator($rule, $iterationLevel)
    {
        $conditionOperator = RuleConditionOperatorValueHolderParser::parse($rule->condition);
        $rules             = $this->parseRules($rule->rules, $iterationLevel);

        $conditionOperator->addAllValueHolders($rules);

        return $conditionOperator;
    }

    /**
     * @param array $rules
     * @param       $iterationLevel
     */
    private function parseRules(array $rules, $iterationLevel)
    {
        $valueHolders = array();

        if (empty($rules)) {
            throw new \InvalidArgumentException('');
        }

        foreach ($rules as $item) {
            if (property_exists($item, 'condition')) {
                $valueHolders[] = $this->parseConditionOperator($item, $iterationLevel + 1);
            } else {
                $filterPair = $this->filterPairHolder->getByFilterId($item->id);
                ValueChecker::throwExIfNull($filterPair);

                $operator = $filterPair->findOperatorByType($item->operator);
                ValueChecker::throwExIfNull($operator);

                $value = $item->value;

                dump($value);

                if (is_array($value)) {
                    $valueCount = count($value);
                    $inputSize  = $operator->getNumberOfInputs();

                    if ($operator->isMultiple() || $inputSize > 1) {
                        if ($inputSize > 1 && ($valueCount !== $inputSize)) {
                            throw new \InvalidArgumentException("Size of values array(${valueCount}) does not match number of operator inputs ${inputSize}.");
                        }

                        foreach ($value as $currentValue) {
                            $this->validateValue($filterPair->getFilter(), $operator, $currentValue);
                        }

                        $valueHolders[] = new ValueHolder($filterPair->getFilter(), $operator, $value);
                    } else {
                        throw new \InvalidArgumentException("Operator ${operator} does not support multiple values.");
                    }
                } else {
                    $this->validateValue($filterPair->getFilter(), $operator, $value);
                    $valueHolders[] = new ValueHolder($filterPair->getFilter(), $operator, $value);
                }
            }
        }

        return $valueHolders;
    }
}

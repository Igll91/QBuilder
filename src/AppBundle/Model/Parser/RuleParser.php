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
use AppBundle\Model\Exception\ValidationException;
use AppBundle\Model\ValueHolder\ConditionOperatorValueHolder;
use AppBundle\Model\ValueHolder\IValueHolder;
use AppBundle\Model\ValueHolder\Parser\RuleConditionOperatorValueHolderParser;
use AppBundle\Model\ValueHolder\ValueHolder;

class RuleParser extends Parser
{
    public function parseQuery($query)
    {
        $query = ValueChecker::getStringOrEx($query);
        $json  = JsonHelper::decode($query);

        if ($json->getStatus() != JsonHelper::SUCCESS) {
            throw new \InvalidArgumentException("Passed JSON query is invalid: ${query}");
        }

        return $this->parseConditionOperator($json->getResult(), 0);
    }

    /**
     * Parses rules that are part of current iteration ConditionOperatorValueHolder.
     *
     * Parse current condition rule and append other rules into his holder.
     * It represents SQL condition.
     * Example:
     *      (name = 'x' OR name = 'y') will be presented as OrConditionValueHolder containing two ValueHolder objects.
     *
     * Holders can be nested.
     *
     * @param \stdClass $rule           Current set of rules that will be parsed.
     * @param  int      $iterationLevel Nesting level.
     *
     * @return ConditionOperatorValueHolder ConditionOperatorValueHolder containing other rule values.
     */
    private function parseConditionOperator($rule, $iterationLevel)
    {
        $conditionOperator = RuleConditionOperatorValueHolderParser::parse($rule->condition);
        $rules             = $this->parseRules($rule->rules, $iterationLevel);

        $conditionOperator->addAllValueHolders($rules);

        return $conditionOperator;
    }

    /**
     * Iterates rules and parses them into IValueHolder instances.
     *
     * Iterates over passed rules (frontend QueryBuilder client values) and tries to parse them.
     * If any of values contains condition, another level of iteration will be added to the values holder.
     * Other values will be checked:
     *  - if Filter is among allowed ones
     *  - if Operator is among allowed ones
     *  - rule value/s will be checked with Filter and FilterType validator/s
     *  - rule value/s will be cast to corresponding type
     *
     * @param array $rules          Rules defined and passed by frontend QueryBuilder client.
     * @param int   $iterationLevel Current level of iteration.
     *
     * @throws \InvalidArgumentException If Exception occurred that should not be handled any further and no
     * details should be shown to user.
     * @throws ValidationException If validation was invalid.
     *
     * @return IValueHolder[] Array of IValueHolder instances.
     */
    private function parseRules(array $rules, $iterationLevel)
    {
        $valueHolders = array();

        if (empty($rules)) {
            throw new \InvalidArgumentException('Rules should not be empty.');
        }

        foreach ($rules as $item) {
            if (property_exists($item, 'condition')) {
                $valueHolders[] = $this->parseConditionOperator($item, $iterationLevel + 1);
            } else {
                $value      = $item->value;
                $filterPair = $this->filterPairHolder->getByFilterId($item->id);
                $operator   = $filterPair->findOperatorByType($item->operator);

                ValueChecker::throwExIfNull($filterPair, 'FilterPair must not be null.');
                ValueChecker::throwExIfNull($operator, 'Operator must not be null.');

                if (is_array($value)) {
                    $valueCount = count($value);
                    $inputSize  = $operator->getNumberOfInputs();

                    if ($operator->isMultiple() || $inputSize > 1) {
                        if ($inputSize > 1 && ($valueCount !== $inputSize)) {
                            throw new \InvalidArgumentException("Size of values array(${valueCount}) does not 
                            match number of operator inputs ${inputSize}.");
                        }

                        foreach ($value as $currentValue) {
                            $this->validateValue($filterPair->getFilter(), $operator, $currentValue);
                        }

                        $castedValues   = $this->matchValueToFilterType($value, $filterPair->getFilter()->getType());
                        $valueHolders[] = new ValueHolder($filterPair->getFilter(), $operator, $castedValues);
                    } else {
                        throw new \InvalidArgumentException("Operator ${operator} does not support multiple values.");
                    }
                } else {
                    $this->validateValue($filterPair->getFilter(), $operator, $value);
                    $castedValue    = $this->matchValueToFilterType($value, $filterPair->getFilter()->getType());
                    $valueHolders[] = new ValueHolder($filterPair->getFilter(), $operator, $castedValue);
                }
            }
        }

        return $valueHolders;
    }
}

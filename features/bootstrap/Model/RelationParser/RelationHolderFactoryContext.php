<?php

namespace Svuk\Tests\Model\RelationParser;

use Behat\Behat\Tester\Exception\PendingException;
use AppBundle\Model\ValueHolder\AndConditionValueHolder;
use AppBundle\Model\ValueHolder\OrConditionValueHolder;
use AppBundle\Model\ValueHolder\Parser\RuleConditionOperatorValueHolderParser;
use Behat\Behat\Context\Context;
use AppBundle\Model\Filter\Filter;
use AppBundle\Model\Operator\EqualOperator;
use AppBundle\Model\ValueHolder\ValueHolder;
use AppBundle\Model\Filter\Type\StringFilterType;
use AppBundle\Model\RelationParser\RelationHolderFactory;
use AppBundle\Model\RelationParser\RelationHolder;
use AppBundle\Model\RelationParser\Relation;

class RelationHolderFactoryContext implements Context
{

    private $conditionValueHolder;
    private $result;
    private $relationResult;
    private $relationIds;

    private function getNoRelationsValues()
    {
        $filter       = new Filter('someid', new StringFilterType());
        $operator     = new EqualOperator();
        $valueHolder  = new ValueHolder($filter, $operator, 'test val');
        $andCondition = new AndConditionValueHolder();
        $andCondition->addValueHolder($valueHolder);

        return $andCondition;
    }

    private function getSingleRelation()
    {
        $filter       = new Filter('relationone.someid', new StringFilterType());
        $operator     = new EqualOperator();
        $valueHolder  = new ValueHolder($filter, $operator, 'test val');
        $andCondition = new AndConditionValueHolder();
        $andCondition->addValueHolder($valueHolder);

        return $andCondition;
    }

    private function getTwoSameRelations()
    {
        $filter       = new Filter('relationone.someid', new StringFilterType());
        $filter2      = new Filter('relationone.otherid', new StringFilterType());
        $operator     = new EqualOperator();
        $valueHolder  = new ValueHolder($filter, $operator, 'test val');
        $valueHolder2 = new ValueHolder($filter2, $operator, 'test val');
        $andCondition = new AndConditionValueHolder();
        $andCondition->addValueHolder($valueHolder);
        $andCondition->addValueHolder($valueHolder2);

        return $andCondition;
    }

    private function getTwoDifferentRelations()
    {
        $filter       = new Filter('relationone.someid', new StringFilterType());
        $filter2      = new Filter('relationtwo.otherid', new StringFilterType());
        $operator     = new EqualOperator();
        $valueHolder  = new ValueHolder($filter, $operator, 'test val');
        $valueHolder2 = new ValueHolder($filter2, $operator, 'test val');
        $andCondition = new AndConditionValueHolder();
        $andCondition->addValueHolder($valueHolder);
        $andCondition->addValueHolder($valueHolder2);

        return $andCondition;
    }

    private function multipleMultyLayeredRelations()
    {
        $filter       = new Filter('relationone.someid', new StringFilterType());
        $filter2      = new Filter('relationtwo.otherid', new StringFilterType());
        $filter3      = new Filter('relationtwo.id21', new StringFilterType());
        $filter4      = new Filter('notimportant', new StringFilterType());
        $filter5      = new Filter('relationtwo.otherid', new StringFilterType());
        $filter6      = new Filter('relationthree.ddd', new StringFilterType());
        $filter7      = new Filter('sadasd', new StringFilterType());
        $operator     = new EqualOperator();
        $valueHolder  = new ValueHolder($filter, $operator, 'test val');
        $valueHolder2 = new ValueHolder($filter2, $operator, 'test val');
        $valueHolder3 = new ValueHolder($filter3, $operator, 'test val');
        $valueHolder4 = new ValueHolder($filter4, $operator, 'test val');
        $valueHolder5 = new ValueHolder($filter5, $operator, 'test val');
        $valueHolder6 = new ValueHolder($filter6, $operator, 'test val');
        $valueHolder7 = new ValueHolder($filter7, $operator, 'test val');
        $andCondition = new AndConditionValueHolder();
        $andCondition->addValueHolder($valueHolder);
        $andCondition->addValueHolder($valueHolder2);
        $andCondition->addValueHolder($valueHolder3);
        $andCondition->addValueHolder($valueHolder4);
        $andCondition->addValueHolder($valueHolder5);
        $andCondition->addValueHolder($valueHolder6);
        $andCondition->addValueHolder($valueHolder7);

        return $andCondition;
    }

    /**
     * @Given that used ConditionOperatorValueHolder is :arg1
     */
    public function thatUsedConditionoperatorvalueholderIs($arg1)
    {
        switch ($arg1) {
            case "without relations":
                $this->conditionValueHolder =  $this->getNoRelationsValues();
                break;
            case "single relation":
                $this->conditionValueHolder =  $this->getSingleRelation();
                break;
            case "two same relations":
                $this->conditionValueHolder = $this->getTwoSameRelations();
                break;
            case "two different relations":
                $this->conditionValueHolder = $this->getTwoDifferentRelations();
                break;
            case "multitple multilayered":
                $this->conditionValueHolder = $this->multipleMultyLayeredRelations();
                break;
            default:
                throw new \InvalidArgumentException("Unsupported
                        prepared ConditionOperatorValueHolder.");
        }
    }

    /**
     * @When I extract relation field identifiers
     */
    public function iExtractRelationFieldIdentifiers()
    {
        $rhf                  = new RelationHolderFactory();
        $reflectionClass      = new \ReflectionClass($rhf);
        $method               = $reflectionClass->getMethod('extractRelationFieldIdentifiers');
        $method->setAccessible(true);
        $this->result         = $method->invoke($rhf, $this->conditionValueHolder);
        $this->relationResult = $rhf->createRelationHolder($this->conditionValueHolder);
    }

    /**
     * @Then I should get array :arg1
     */
    public function iShouldGetArray($arg1)
    {
        $this->relationIds = json_decode($arg1, true);

        \PHPUnit_Framework_Assert::assertEquals($this->relationIds, $this->result);
    }

    /**
     * @Then RelationHolder should contain relations with corresponding keys
     */
    public function relationholderShouldContainRelationsWithCorrespondingKeys()
    {
        $relationHolder = new RelationHolder();
        foreach ($this->relationIds as $relationId) {
            $relation = new Relation($relationId);
            $relationHolder->addRelation($relation);
        }

        \PHPUnit_Framework_Assert::assertEquals(md5(json_encode($relationHolder)),
            md5(json_encode($this->relationResult)));
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 18.01.2017.
 * Time: 20:51
 */

namespace AppBundle\Model\QueryBuilderParser;

use AppBundle\Helper\DoctrineEntityHelper;
use AppBundle\Model\RelationParser\Relation;
use AppBundle\Model\RelationParser\RelationHolderFactory;
use AppBundle\Model\ValueHolder\AndConditionValueHolder;
use AppBundle\Model\ValueHolder\ConditionOperatorValueHolder;
use AppBundle\Model\ValueHolder\OrConditionValueHolder;
use AppBundle\Model\ValueHolder\ValueHolder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use phpDocumentor\Reflection\Types\Mixed;

class DoctrineEntityParser implements IEntityParser
{
    private $entityManager;
    private $delimiter;
    private $rootAlias;     //Alias of the root entity.

    public function __construct(EntityManager $entityManager, $rootAlias = 'root', $delimiter = '.')
    {
        $this->entityManager = $entityManager;
        $this->delimiter     = $delimiter;
        $this->rootAlias     = $rootAlias;
    }

    /**
     * Parses given values into SQL and returns result.
     *
     * Process is done in few steps:
     *  1) Relations informations are acquired from ConditionOperatorValueHolder
     *  2) Relations are applied to doctrine QueryBuilder
     *  3) Parse ConditionOperatorValueHolder and apply SQL WHERE conditions to QueryBuilder.
     *  4) Get query and return the result.
     *
     * @param ConditionOperatorValueHolder $valueHolder
     * @param Mixed                        $rootEntity
     *
     * @return string[] Array of queried values.
     */
    public function parse(ConditionOperatorValueHolder $valueHolder, QueryInquiry $queryInquiry)
    {
        //TODO: relations should be already validated... string id must match entity field

        $relationHolderFactory     = new RelationHolderFactory();
        $relationHolder            = $relationHolderFactory->createRelationHolder($valueHolder);
        $doctrineValueHolderParser = new DoctrineValueHolderParser($relationHolder, $this->rootAlias, $this->delimiter);
        $queryBuilder              = $this->entityManager->createQueryBuilder();

        $queryBuilder->from($queryInquiry->getRootEntity(), $this->rootAlias);
        $queryBuilder->select($this->rootAlias.'.identifier'); //TODO: which fields to select?

        $queryBuilder->setFirstResult($queryInquiry->getOffset());
        $queryBuilder->setMaxResults($queryInquiry->getLimit());

        dump($relationHolder);

        foreach ($relationHolder->getRelations() as $currentRelation) {
            $this->handleJoin($currentRelation, $queryBuilder);
        }

        dump($queryBuilder->getQuery()->getDQL());
        dump($queryBuilder->getQuery()->getSQL());

//        TODO: validate VALUES !!!

        $ddd = $this->parseValueHolder($valueHolder, $queryBuilder, $doctrineValueHolderParser);

        dump($ddd->getQuery()->getDQL());
        dump($ddd->getQuery()->getSQL());
        dump($ddd->getQuery()->getResult());

        return $ddd->getQuery()->getArrayResult();
    }

    /**
     * Build and apply WHERE criteria based on ConditionOperatorValueHolder values.
     *
     * @param ConditionOperatorValueHolder $valueHolder
     * @param QueryBuilder                 $queryBuilder
     * @param AbstractValueHolderParser    $valueHolderParser
     *
     * @return QueryBuilder
     */
    private function parseValueHolder(
        ConditionOperatorValueHolder $valueHolder,
        QueryBuilder $queryBuilder,
        AbstractValueHolderParser $valueHolderParser
    ) {
        $loop = function (ConditionOperatorValueHolder $conditionOperatorValueHolder) use (
            $queryBuilder,
            $valueHolderParser,
            &$loop
        ) {

            switch (get_class($conditionOperatorValueHolder)) {
                case AndConditionValueHolder::class:
                    $expr = new Expr\Andx();
                    break;
                case OrConditionValueHolder::class:
                    $expr = new Expr\Orx();
                    break;
                default:
                    throw new \InvalidArgumentException("Unsupported Condition operator.");
            }

            foreach ($conditionOperatorValueHolder->getValue() as $item) {
                switch (get_class($item)) {
                    case AndConditionValueHolder::class:
                    case OrConditionValueHolder::class:
                        $expr->add($loop($item));
                        break;
                    case ValueHolder::class:
                        /* @var $expressionHolder DoctrineExpressionHolder */
                        $expressionHolder = $valueHolderParser->parse($item);
                        $expr->add($expressionHolder->getExpression());
                        $this->setParameters($expressionHolder, $queryBuilder);

                        break;
                }
            }

            return $expr;
        };

        $expression = $loop($valueHolder);

        $queryBuilder->where($expression);

        return $queryBuilder;
    }

    /**
     * Apply DoctrineExpressionHolder key value pairs as parameters to QueryBuilder.
     *
     * @param DoctrineExpressionHolder $expressionHolder
     * @param QueryBuilder             $queryBuilder
     */
    private function setParameters(DoctrineExpressionHolder $expressionHolder, QueryBuilder $queryBuilder)
    {
        foreach ($expressionHolder->getKeyValuePairs() as $pair) {
            $queryBuilder->setParameter($pair->getKey(), $pair->getValue());
        }
    }

    /**
     *
     *
     * TODO: determine type of join based on condition
     * NOTE: test needed suspicious code.
     *
     * @param Relation     $relation
     * @param QueryBuilder $queryBuilder
     */
    private function handleJoin(Relation $relation, QueryBuilder $queryBuilder)
    {
        $alias = $relation->getAlias();

        if ($relation->hasParent()) {
            $queryBuilder->leftJoin($relation->getParent()->getAlias().'.'.$relation->getFieldIdentifier(), $alias);
        } else {
            $queryBuilder->leftJoin($this->rootAlias.'.'.$relation->getIdentifier(), $alias);
        }
    }
}

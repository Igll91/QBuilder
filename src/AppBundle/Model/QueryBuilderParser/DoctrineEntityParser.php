<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 18.01.2017.
 * Time: 20:51
 */

namespace AppBundle\Model\QueryBuilderParser;

use AppBundle\Helper\DoctrineEntityHelper;
use AppBundle\Model\RelationParser\RelationHolderFactory;
use AppBundle\Model\ValueHolder\AndConditionValueHolder;
use AppBundle\Model\ValueHolder\ConditionOperatorValueHolder;
use AppBundle\Model\ValueHolder\OrConditionValueHolder;
use AppBundle\Model\ValueHolder\ValueHolder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

class DoctrineEntityParser implements IEntityParser
{
    private $entityManager;
    private $delimiter;
    private $rootAlias;

    public function __construct(EntityManager $entityManager, $rootAlias = 'root', $delimiter = '.')
    {
        $this->entityManager = $entityManager;
        $this->delimiter     = $delimiter;
        $this->rootAlias     = $rootAlias;
    }

    public function parse(ConditionOperatorValueHolder $valueHolder, $rootEntity)
    {
        //TODO: relations should be already validated... string id must match entity field

        if (is_object($rootEntity)) {
            $rootEntity = get_class($rootEntity);
        }

        $relationHolderFactory = new RelationHolderFactory();
        $relationHolder = $relationHolderFactory->createRelationHolder($valueHolder);
        $doctrineValueHolderParser = new DoctrineValueHolderParser($relationHolder, $this->rootAlias, $this->delimiter);
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->from($rootEntity, $this->rootAlias);
        $queryBuilder->select($this->rootAlias.'.identifier'); //TODO: which fields to select?

        dump($relationHolder);

        foreach ($relationHolder->getRelations() as $currentRelation) {
            // TODO: determine type of join based on condition operator ?
            $alias = $currentRelation->getAlias();
            dump($alias);
            if ($currentRelation->hasParent()) {
                $queryBuilder->leftJoin(
                    $currentRelation->getParent()->getAlias().'.'.$currentRelation->getFieldIdentifier(),
                    $alias
                );
            } else {
                $queryBuilder->leftJoin($this->rootAlias.'.'.$currentRelation->getIdentifier(), $alias);
            }
        }

        dump($queryBuilder->getQuery()->getDQL());
        dump($queryBuilder->getQuery()->getSQL());

        $ddd = $this->parseValueHolder($valueHolder, $queryBuilder, $doctrineValueHolderParser);
        dump($ddd->getQuery()->getDQL());
        dump($ddd->getQuery()->getSQL());
    }

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

                        foreach ($expressionHolder->getKeyValuePairs() as $pair) {
                            $queryBuilder->setParameter($pair->getKey(), $pair->getValue());
                        }
                        break;
                }
            }

            return $expr;
        };

        $expression = $loop($valueHolder);

        $queryBuilder->where($expression);

        return $queryBuilder;
    }

    private function getEntity($entityName)
    {
        if (!DoctrineEntityHelper::isEntity($this->entityManager, $entityName)) {
            $namespaces = join(",", $this->entityManager->getConfiguration()->getEntityNamespaces());
            throw new \InvalidArgumentException("${entityName} is not valid Entity in namespaces: ${namespaces}.");
        }

        dump($entityName);

//        dump($this->entityManager->getClassMetadata($entityName)->getAssociationNames());
//        dump($this->entityManager->getClassMetadata($entityName)->getAssociationMappings());
//die();

        return $entityName;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 18.01.2017.
 * Time: 20:51
 */

namespace AppBundle\Model\QueryBuilderParser;

use AppBundle\Helper\DoctrineEntityHelper;
use AppBundle\Helper\ValueChecker;
use AppBundle\Model\RelationParser\RelationHolderFactory;
use AppBundle\Model\ValueHolder\AndConditionValueHolder;
use AppBundle\Model\ValueHolder\ConditionOperatorValueHolder;
use AppBundle\Model\ValueHolder\IValueHolder;
use AppBundle\Model\ValueHolder\OrConditionValueHolder;
use AppBundle\Model\ValueHolder\ValueHolder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Monolog\Logger;

class DoctrineEntityParser implements IEntityParser
{
    private $entityManager;
    private $delimiter;

    public function __construct(EntityManager $entityManager, $delimiter = '.')
    {
        $this->entityManager = $entityManager;
        $this->delimiter     = $delimiter;
    }

    public function parse(ConditionOperatorValueHolder $valueHolder, $rootEntity)
    {
        //TODO: relations should be already validated... string id must match entity field

        if (is_object($rootEntity)) {
            $rootEntity = get_class($rootEntity);
        }

        $relationHolderFactory     = new RelationHolderFactory();
        $relationHolder            = $relationHolderFactory->createRelationHolder($valueHolder);
        $doctrineValueHolderParser = new DoctrineValueHolderParser($relationHolder, $this->delimiter);
        $queryBuilder              = $this->entityManager->createQueryBuilder();

        $queryBuilder->from($rootEntity, 'root');
        $queryBuilder->select('root.identifier'); //TODO: which fields to select?

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
                $queryBuilder->leftJoin('root.'.$currentRelation->getIdentifier(), $alias);
            }
        }

        dump($queryBuilder->getQuery()->getDQL());
        dump($queryBuilder->getQuery()->getSQL());

    }

    private function parseValueHolder(IValueHolder $valueHolder, QueryBuilder $queryBuilder)
    {
//        TODO: parse ValueHolder
        switch (get_class($valueHolder)) {
        case AndConditionValueHolder::class:
        case OrConditionValueHolder::class:
            break;
        case ValueHolder::class:

            break;
        }
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

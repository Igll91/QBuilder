<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 18.01.2017.
 * Time: 20:51
 */

namespace AppBundle\Model\RelationParser;

use AppBundle\Helper\DoctrineEntityHelper;
use AppBundle\Helper\ValueChecker;
use Doctrine\ORM\EntityManager;

class DoctrineEntityParser
{
    private $entityManager;
    private $delimiter;

    public function __construct(EntityManager $entityManager, $delimiter = '.')
    {
        $this->entityManager = $entityManager;
        $this->delimiter     = $delimiter;
    }

    public function parse($relationsString, $entitiesMap = array())
    {
        $relationsString   = ValueChecker::getStringOrEx($relationsString);
        $delimiterPosition = strpos($relationsString, $this->delimiter);

        if ($delimiterPosition === false) {
            $entitiesMap[] = $this->getEntity($relationsString);
        } else {
            $entityName    = substr($relationsString, 0, $delimiterPosition);
            $entitiesMap[] = $this->getEntity($entityName);
            $entitiesMap   = $this->parse(substr($relationsString, $delimiterPosition + 1), $entitiesMap);
        }

        return $entitiesMap;
    }

    public function mergeRelations(array $relations)
    {
        //TODO: OO value holder.. don't work with arrays!
        //TODO: relation validation... and extra data saving... fields must exist in Entity and they must be relations to other entities
        // save field name for doctrine QB, probably type too

        $mergedRelations  = array();
        $relationMappings = array();

        foreach ($relations as $currentRelations) {
            $fieldRelationMappings = array();
            foreach ($currentRelations as $key => $val) {
                //ROOT entity
                if ($key === 0) {
                    if (isset($mergedRelations[0])) {
                        if ($mergedRelations[0] != $val) {
                            throw new \InvalidArgumentException("Root element must match in all fields relation 
                            definitions. ${val} does not match " . $mergedRelations[0]);
                        } else {
                            $fieldRelationMappings[] = $key;
                        }
                    } else {
                        $mergedRelations[0]      = $val;
                        $fieldRelationMappings[] = $key;
                    }
                } else {
                    if (isset($mergedRelations[$key])) {
                        $matchValueKey = array_search($val, $mergedRelations[$key], true);
                        if ($matchValueKey === false) {
                            $fieldRelationMappings[] = count($mergedRelations[$key]);
                            $mergedRelations[$key][] = $val;
                        } else {
                            $fieldRelationMappings[] = $matchValueKey;
                        }
                    } else {
                        $mergedRelations[$key]   = array($val);
                        $fieldRelationMappings[] = 0;
                    }
                }
            }

            $relationMappings[] = $fieldRelationMappings;
        }

        return array('MergedRelations' => $mergedRelations, 'EntityRelationsMappings' => $relationMappings);
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

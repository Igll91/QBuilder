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

    private function getEntity($entityName)
    {
        if (!DoctrineEntityHelper::isEntity($this->entityManager, $entityName)) {
            $namespaces = join(",", $this->entityManager->getConfiguration()->getEntityNamespaces());
            throw new \InvalidArgumentException("${entityName} is not valid Entity in namespaces: ${namespaces}.");
        }

        dump($entityName);

        return $entityName;
    }
}

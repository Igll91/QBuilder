<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 18.01.2017.
 * Time: 19:37
 */

namespace AppBundle\Helper;

use Doctrine\Common\Persistence\Proxy;
use Doctrine\ORM\EntityManager;

class DoctrineEntityHelper
{
    /**
     * @param EntityManager $entityManager
     * @param string|object $class
     *
     * @return boolean
     */
    public static function isEntity(EntityManager $entityManager, $class)
    {
        if (is_object($class)) {
            $class = ($class instanceof Proxy)
                ? get_parent_class($class)
                : get_class($class);
        }

        return !$entityManager->getMetadataFactory()->isTransient($class);
    }
}

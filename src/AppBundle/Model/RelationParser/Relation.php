<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 10.04.2017.
 * Time: 20:33
 */

namespace AppBundle\Model\RelationParser;

use AppBundle\Helper\ValueChecker;

class Relation
{
    const RELATION_ALIAS_DELIMITER = '_';

    private $identifier;

    private $hasParent;

    /**
     * @var Relation Parent relation.
     */
    private $parent;

    public function __construct($identifier)
    {
        ValueChecker::getStringOrEx($identifier);
        $this->identifier = $identifier;
    }

    public function __toString()
    {
        return $this->getIdentifier();
    }

    public function getFieldIdentifier()
    {
        return $this->identifier;
    }

    public function getIdentifier()
    {
        if ($this->hasParent) {
            return $this->parent->getIdentifier().'.'.$this->identifier;
        } else {
            return $this->identifier;
        }
    }

    public function getAlias()
    {
        if ($this->hasParent) {
            return $this->parent->getIdentifier().self::RELATION_ALIAS_DELIMITER.$this->identifier;
        } else {
            return $this->identifier;
        }
    }

    public function hasParent()
    {
        return $this->parent !== null;
    }

    public function setParent(Relation $relation)
    {
        $this->hasParent = true;
        $this->parent    = $relation;

        return $this;
    }

    /**
     * @return Relation
     */
    public function getParent()
    {
        return $this->parent;
    }
}
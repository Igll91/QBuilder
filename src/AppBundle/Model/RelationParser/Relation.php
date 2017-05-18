<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 10.04.2017.
 * Time: 20:33
 */

namespace AppBundle\Model\RelationParser;

use AppBundle\Helper\ValueChecker;

/**
 * Contains information about ORM object relation.
 */
class Relation
{
    //Delimiter used for child-parent separation when creating ALIAS string.
    const RELATION_ALIAS_DELIMITER = '_';

    /**
     * Current relation string identifier representation.
     *
     * @var String
     */
    private $identifier;

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

    /**
     * Return only this Relation identifier.
     *
     * Returns identifier for single Relation without its parent.
     */
    public function getFieldIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Return full Relation identifier.
     *
     * Return full path relation identifier. In case relation has parents
     * their identifiers are concatenated in front of current Relation.
     *
     * @return String
     */
    public function getIdentifier()
    {
        if ($this->hasParent()) {
            return $this->parent->getIdentifier().'.'.$this->identifier;
        } else {
            return $this->identifier;
        }
    }

    /**
     * Returns Relation alias.
     *
     * Recursively iterate over Relation parents and create combined alias.
     *
     * @return String
     */
    public function getAlias()
    {
        if ($this->hasParent()) {
            return $this->parent->getAlias().self::RELATION_ALIAS_DELIMITER.$this->identifier;
        } else {
            return $this->identifier;
        }
    }

    /**
     * @return bool True if Relation has parent, false otherwise.
     */
    public function hasParent()
    {
        return $this->parent !== null;
    }

    public function setParent(Relation $relation)
    {
        $this->parent = $relation;

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

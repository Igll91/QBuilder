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

    public function getIdentifier()
    {
        if ($this->hasParent) {
            return $this->parent->getIdentifier().'.'.$this->identifier;
        } else {
            return $this->identifier;
        }
    }

    public function setParent(Relation $relation)
    {
        $this->hasParent = true;
        $this->parent    = $relation;

        return $this;
    }
}
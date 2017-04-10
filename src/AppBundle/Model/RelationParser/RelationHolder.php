<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 10.04.2017.
 * Time: 20:33
 */

namespace AppBundle\Model\RelationParser;


class RelationHolder
{
    /**
     * @var Relation[] array
     */
    private $relations;

    public function __construct()
    {
        $this->relations = array();
    }

//======================================================================================================================
// GETTERS & SETTERS
//======================================================================================================================

    public function getRelations()
    {
        return $this->relations;
    }

    public function addRelation(Relation $relation)
    {
        $newRelationKey = $relation->getIdentifier();

        if (!array_key_exists($newRelationKey, $this->relations)) {
            $this->relations[$newRelationKey] = $relation;
        }

        return $this;
    }

    public function addRelations(array $relations)
    {
        array_walk($relations, array($this, 'addRelation'));

        return $this;
    }

    public function relationExists($key)
    {
        return array_key_exists($key, $this->relations);
    }

    public function getRelationByKey($key)
    {
        return array_key_exists($key, $this->relations) ? $this->relations[$key] : null;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 10.04.2017.
 * Time: 21:16
 */

namespace AppBundle\Model\RelationParser;

use AppBundle\Model\ValueHolder\ConditionOperatorValueHolder;

class RelationHolderFactory
{
    private $delimiter;

    public function __construct($delimiter = '.')
    {
        $this->delimiter = $delimiter;
    }

    /**
     * Creates RelationHolder from ConditionOperatorValueHolder.
     *
     * @param ConditionOperatorValueHolder $holder QBuilder user selected values holder.
     *
     * @return RelationHolder
     */
    public function createRelationHolder(ConditionOperatorValueHolder $holder)
    {
        $relationHolder = new RelationHolder();
        $relationIds    = $this->extractRelationFieldIdentifiers($holder);

        foreach ($relationIds as $relationIdentifier) {
            $this->handleRelationIdentifier($relationIdentifier, $relationHolder);
        }

        return $relationHolder;
    }

    /**
     * Turns given field relation string representation into Relation object and appends it to RelationHolder.
     *
     * If given field relation string representation (argument: relationKey) contains delimiter, the first
     * parent is taken and processed into Relation object, and added to next iteration as parent. Process
     * is repeated until end of relation string representation is reached.
     *
     * @see Relation
     *
     */
    private function handleRelationIdentifier($relationKey, RelationHolder $relationHolder, Relation $parent = null)
    {
        $delimiterPos      = strrpos($relationKey, $this->delimiter);
        $relationInsertion = function ($relationIdentifier) use ($relationHolder, $parent) {
            if (!$relationHolder->relationExists($relationIdentifier)) {
                $newRelation = new Relation($relationIdentifier);

                if ($parent) {
                    $newRelation->setParent($parent);
                }

                $relationHolder->addRelation($newRelation);

                return $newRelation;
            } else {
                return $relationHolder->getRelationByKey($relationIdentifier);
            }
        };

        if ($delimiterPos === false) {
            $relationInsertion($relationKey);

            return $relationHolder;
        } else {
            $relationIdentifier = substr($relationKey, 0, $delimiterPos);
            $newRelation        = $relationInsertion($relationIdentifier);

            return $this->handleRelationIdentifier(
                substr($relationKey, $delimiterPos + 1),
                $relationHolder,
                $newRelation
            );
        }
    }

    /**
     * Extract unique relation string representations from ConditionOperatorValueHolder.
     *
     * Takes all unique ConditionOperatorValueHolder's filter relations identifiers.
     * <pre>
     * Example:
     * For values [
     *  "relation1.field1", "relation.1.field2", "relation2.field3", "field5"
     * ]
     *
     * Returned value will be [
     * "relation1", "relation2"
     * ]
     *
     * Because:
     *  * first two field identifiers point to same relation
     *  * last field identifier has no relation
     *
     * </pre>
     *
     * @param ConditionOperatorValueHolder $holder
     * @param array                        $fields
     *
     * @return array
     */
    private function extractRelationFieldIdentifiers(ConditionOperatorValueHolder $holder, array $fields = [])
    {
        foreach ($holder->getValue() as $value) {
            if (is_a($value, ConditionOperatorValueHolder::class)) {
                $fields = $this->extractRelationFieldIdentifiers($value, $fields);
            } else {
                $identifier         = $value->getFilter()->getIdentifier();
                $delimiterPos       = strrpos($identifier, $this->delimiter);
                $relationIdentifier = substr($identifier, 0, $delimiterPos);
                if ($delimiterPos !== false && !in_array($relationIdentifier, $fields)) {
                    $fields[] = substr($relationIdentifier, 0, $delimiterPos);
                }
            }
        }

        return $fields;
    }
}

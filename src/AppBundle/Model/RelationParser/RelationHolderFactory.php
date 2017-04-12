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
        $relationHolder               = new RelationHolder();
        $extractedRelationIdentifiers = $this->extractRelationFieldIdentifiers($holder);

        foreach ($extractedRelationIdentifiers as $relationIdentifier) {
            $this->handleRelationIdentifier($relationIdentifier, $relationHolder);
        }

        return $relationHolder;
    }

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
     * TODO: TEST
     *
     * @param ConditionOperatorValueHolder $holder
     * @param array                        $fields
     *
     * @return array
     */
    private function extractRelationFieldIdentifiers(ConditionOperatorValueHolder $holder, array $fields = [])
    {
//        category.type ... category.name => have same relation

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
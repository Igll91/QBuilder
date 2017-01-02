<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 20.12.2016.
 * Time: 21:09
 */

namespace AppBundle\Model\Filter;

/**
 *
 *
 * Class FilterHolder
 * @package AppBundle\Model\Filter
 */
class FilterPairHolder
{

    private $filterPairs;

    public function __construct()
    {
        $this->filterPairs = array();
    }

//======================================================================================================================
// INSERTION
//======================================================================================================================

    public function addFilterPair(FilterPair $filterPair)
    {
        $this->filterPairs[] = $filterPair;
    }

    public function addAllFilterPairs(array $filterPairs)
    {
        array_walk($filterPairs, array($this, 'addFilterPair'));
    }

//======================================================================================================================
// SEARCHERS
//======================================================================================================================

    /**
     * Check if any of the FilterPair's contains Filer with given identifier.
     *
     * @param $filterId string Filter identifier that will be searched.
     *
     * @return bool True if filter found, false otherwise.
     */
    public function containsFilter($filterId)
    {
        foreach ($this->filterPairs as $filterPair) {
            if ($filterPair->getFilter()->getIdentifier() === $filterId) {
                return true;
            }
        }

        return false;
    }

    /**
     * Search FilterPair by Filter identifier.
     *
     * @param $filterId  string Filter identifier that will be searched.
     *
     * @return FilterPair|null FilterPair if found, null otherwise.
     */
    public function getByFilterId($filterId)
    {
        foreach ($this->filterPairs as $filterPair) {
            if ($filterPair->getFilter()->getIdentifier() === $filterId) {
                return $filterPair;
            }
        }

        return null;
    }

//======================================================================================================================
// GETTERS & SETTERS
//======================================================================================================================

    /**
     * @return array
     */
    public function getFilterPairs()
    {
        return $this->filterPairs;
    }
}

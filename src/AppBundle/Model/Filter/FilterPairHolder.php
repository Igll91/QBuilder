<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 20.12.2016.
 * Time: 21:09
 */

namespace AppBundle\Model\Filter;

use AppBundle\Model\Filter;

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

    public function addFilterPair(FilterPair $filterPair)
    {
        $this->filterPairs = $filterPair;
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

<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 18.05.2017.
 * Time: 22:11
 */

namespace AppBundle\Model\QueryBuilderParser;

use AppBundle\Helper\ValueChecker;

/**
 * Holds data necessary to execute query.
 *
 * Data
 *
 * Class QueryInquery
 * @package AppBundle\Model\QueryBuilderParser
 */
class QueryInquiry
{
    private $rootEntity;

    private $limit;

    private $offset;

    public function __construct($rootEntity, $limit = 10, $offset = 0)
    {
        ValueChecker::getIntOrEx($limit);
        ValueChecker::getIntOrEx($offset);

        $this->rootEntity = is_object($rootEntity) ? get_class($rootEntity) : $rootEntity;
        $this->limit      = $limit;
        $this->offset     = $offset;
    }

//======================================================================================================================
// GETTERS & SETTERS
//======================================================================================================================

    /**
     * @return string
     */
    public function getRootEntity()
    {
        return $this->rootEntity;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }
}

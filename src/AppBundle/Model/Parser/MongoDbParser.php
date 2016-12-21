<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 20.12.2016.
 * Time: 19:22
 */

namespace AppBundle\Model\Parser;

use AppBundle\Helper\JsonHelper;
use AppBundle\Model\Filter\FilterPairHolder;

class MongoDbParser implements IParser
{
    public function parseQuery($query, FilterPairHolder $filterPairHolder)
    {
        $mongoDbQuery = JsonHelper::decode($query);

        dump($mongoDbQuery);

        foreach ($mongoDbQuery->getResult() as $item) {
            dump($item);
        }

        die();

        // TODO: Implement parseQuery() method.
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Model\Filter\Filter;
use AppBundle\Model\Filter\FilterPair;
use AppBundle\Model\Filter\FilterPairHolder;
use AppBundle\Model\Filter\Type\DoubleFilterType;
use AppBundle\Model\Filter\Type\IntegerFilterType;
use AppBundle\Model\Operator\PrebuiltAggregate\OperatorAggregator;
use AppBundle\Model\Parser\MongoDbParser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $json = '{
  "$and": [
    {
      "price": {
        "$gte": 22,
        "$lte": 33
      }
    },
    {
      "$or": [
        {
          "category": null
        },
        {
          "category": 2
        },
        {
          "category": 1
        }
      ]
    },
    {
      "price": 35
    }
  ]
}';
        $fph  = new FilterPairHolder();
        $fp1  = new FilterPair(new Filter('price', new DoubleFilterType()));
        $fp2  = new FilterPair(new Filter('category', new IntegerFilterType()));
        $fp1->addOperators(OperatorAggregator::getOperators(OperatorAggregator::NUMERIC_INPUT_TYPE,
            OperatorAggregator::FULL_SIZE));
        $fp2->addOperators(OperatorAggregator::getOperators(OperatorAggregator::SELECT_TYPE,
            OperatorAggregator::FULL_SIZE));
        $fph->addAllFilterPairs(array($fp1, $fp2));
        $mongoDbParser = new MongoDbParser($fph);
        $mongoDbParser->parseQuery($json);

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
        ]);
    }
}

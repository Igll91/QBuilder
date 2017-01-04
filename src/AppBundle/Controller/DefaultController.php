<?php

namespace AppBundle\Controller;

use AppBundle\Model\Filter\Filter;
use AppBundle\Model\Filter\FilterPair;
use AppBundle\Model\Filter\FilterPairHolder;
use AppBundle\Model\Filter\Type\DoubleFilterType;
use AppBundle\Model\Filter\Type\IntegerFilterType;
use AppBundle\Model\Filter\Type\StringFilterType;
use AppBundle\Model\Operator\PrebuiltAggregate\OperatorAggregator;
use AppBundle\Model\Parser\MongoDbParser;
use AppBundle\Model\Parser\RuleParser;
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
  "condition": "AND",
  "rules": [
    {
      "id": "name",
      "field": "name",
      "type": "string",
      "input": "text",
      "operator": "equal",
      "value": "Mistic"
    },
    {
      "condition": "OR",
      "rules": [
        {
          "id": "category",
          "field": "category",
          "type": "integer",
          "input": "checkbox",
          "operator": "in",
          "value": [
            "1",
            "2"
          ]
        }
      ],
      "not": false
    },
    {
      "id": "price",
      "field": "price",
      "type": "double",
      "input": "text",
      "operator": "between",
      "value": [
        "21",
        "213"
      ]
    },
    {
      "id": "category",
      "field": "category",
      "type": "integer",
      "input": "checkbox",
      "operator": "is_null",
      "value": null
    }
  ],
  "not": false
}';
        $fph  = new FilterPairHolder();
        $fp1  = new FilterPair(new Filter('price', new DoubleFilterType()));
        $fp2  = new FilterPair(new Filter('category', new IntegerFilterType()));
        $fp3  = new FilterPair(new Filter('name', new StringFilterType()));
        $fp1->addOperators(OperatorAggregator::getOperators(OperatorAggregator::NUMERIC_INPUT_TYPE,
            OperatorAggregator::FULL_SIZE));
        $fp2->addOperators(OperatorAggregator::getOperators(OperatorAggregator::SELECT_TYPE,
            OperatorAggregator::FULL_SIZE));
        $fp3->addOperators(OperatorAggregator::getOperators(OperatorAggregator::TEXT_INPUT_TYPE,
            OperatorAggregator::FULL_SIZE));
        $fph->addAllFilterPairs(array($fp1, $fp2, $fp3));
        $parser = new RuleParser($fph);
        $parser->parseQuery($json);

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
        ]);
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Model\Filter\Filter;
use AppBundle\Model\Filter\FilterPair;
use AppBundle\Model\Filter\FilterPairHolder;
use AppBundle\Model\Filter\Type\BooleanFilterType;
use AppBundle\Model\Filter\Type\DoubleFilterType;
use AppBundle\Model\Filter\Type\IntegerFilterType;
use AppBundle\Model\Filter\Type\StringFilterType;
use AppBundle\Model\Operator\PrebuiltAggregate\OperatorAggregator;
use AppBundle\Model\Parser\MongoDbParser;
use AppBundle\Model\Parser\RuleParser;
use AppBundle\Model\RelationParser\DoctrineEntityParser;
use AppBundle\Model\RelationParser\RelationHolderFactory;
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
      "id": "price",
      "field": "price",
      "type": "double",
      "input": "text",
      "operator": "less",
      "value": "10.25"
    },
    {
      "condition": "OR",
      "rules": [
        {
          "id": "category",
          "field": "category",
          "type": "integer",
          "input": "select",
          "operator": "in",
          "value": [
            "4",
            "2"
           ]
        },
        {
          "id": "category",
          "field": "category",
          "type": "integer",
          "input": "select",
          "operator": "equal",
          "value": "1"
        }
      ]
    },
    {
      "id": "price",
      "field": "price",
      "type": "double",
      "input": "text",
      "operator": "is_null",
      "value": null
    },
    {
      "id": "price",
      "field": "price",
      "type": "double",
      "input": "text",
      "operator": "equal",
      "value": "34"
    },
    {
      "id": "name",
      "field": "name",
      "type": "string",
      "input": "text",
      "operator": "begins_with",
      "value": "sd"
    },
    {
      "id": "inStock",
      "field": "in_stock",
      "type": "integer",
      "input": "radio",
      "operator": "equal",
      "value": "1"
    },
    {
      "id": "category",
      "field": "category",
      "type": "integer",
      "input": "select",
      "operator": "is_null",
      "value": null
    },
    {
      "id": "category.type",
      "field": "category.type",
      "type": "integer",
      "input": "select",
      "operator": "equal",
      "value": "5"
    },
    {
      "id": "category.name",
      "field": "category.name",
      "type": "string",
      "input": "text",
      "operator": "equal",
      "value": "ASd"
    },
    {
      "id": "category.type.name",
      "field": "category.type.name",
      "type": "string",
      "input": "text",
      "operator": "equal",
      "value": "Ves"
    }
  ],
  "valid": true
}';
        $fph  = new FilterPairHolder();
        $fp1  = new FilterPair(new Filter('price', new DoubleFilterType()));
        $fp2  = new FilterPair(new Filter('category', new IntegerFilterType()));
        $fp3  = new FilterPair(new Filter('name', new StringFilterType()));
        $fp4  = new FilterPair(new Filter('inStock', new BooleanFilterType()));
        $fp5  = new FilterPair(new Filter('category.type', new IntegerFilterType()));
        $fp6  = new FilterPair(new Filter('category.name', new StringFilterType()));
        $fp7  = new FilterPair(new Filter('category.type.name', new StringFilterType()));
        $fp1->addOperators(OperatorAggregator::getOperators(OperatorAggregator::NUMERIC_INPUT_TYPE,
            OperatorAggregator::FULL_SIZE));
        $fp2->addOperators(OperatorAggregator::getOperators(OperatorAggregator::SELECT_TYPE,
            OperatorAggregator::FULL_SIZE));
        $fp3->addOperators(OperatorAggregator::getOperators(OperatorAggregator::TEXT_INPUT_TYPE,
            OperatorAggregator::FULL_SIZE));
        $fp4->addOperators(OperatorAggregator::getOperators(OperatorAggregator::TEXT_INPUT_TYPE,
            OperatorAggregator::FULL_SIZE));
        $fp5->addOperators(OperatorAggregator::getOperators(OperatorAggregator::SELECT_TYPE,
            OperatorAggregator::FULL_SIZE));
        $fp6->addOperators(OperatorAggregator::getOperators(OperatorAggregator::TEXT_INPUT_TYPE,
            OperatorAggregator::FULL_SIZE));
        $fp7->addOperators(OperatorAggregator::getOperators(OperatorAggregator::TEXT_INPUT_TYPE,
            OperatorAggregator::FULL_SIZE));
        $fph->addAllFilterPairs(array($fp1, $fp2, $fp3, $fp4, $fp5, $fp6, $fp7));
        $parser = new RuleParser($fph);
        $result = $parser->parseQuery($json);

        dump($result);

        $entityMap  = 'AppBundle:Product.AppBundle:Category';
        $entityMap2 = 'AppBundle:Product.AppBundle:Category.AppBundle:CategoryType';

        $dep = new DoctrineEntityParser($this->getDoctrine()->getManager());
//        $map = $dep->parse($entityMap);
//        $map2 = $dep->parse($entityMap2);

        $relationHolderFactory = new RelationHolderFactory();
        dump($relationHolderFactory->createRelationHolder($result));
//        dump($dep->extractRelationFieldIdentifiers($result));
        //TODO: result should be mapped so that relation is joined only once!

//        dump($map);
//        dump($map2);

//        dump($dep->mergeRelations(array($map, $map2)));

        die();
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
        ]);
    }
}

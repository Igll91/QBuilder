<?php

namespace AppBundle\Controller;

use AppBundle\Helper\ValueChecker;
use AppBundle\Model\Filter\FilterPairHolder;
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
        "$lt": 10.25
      }
    },
    {
      "$or": [
        {
          "category": 2
        },
        {
          "category": 1
        },
        {
          "price": {
            "$gte": 13,
            "$lte": 213
          }
        }
      ]
    }
  ]
}';

        $mongoDbParser = new MongoDbParser();
        $mongoDbParser->parseQuery($json, new FilterPairHolder());

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
        ]);
    }
}

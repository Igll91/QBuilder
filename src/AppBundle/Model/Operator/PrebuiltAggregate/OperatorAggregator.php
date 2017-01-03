<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 03.01.2017.
 * Time: 18:10
 */

namespace AppBundle\Model\Operator\PrebuiltAggregate;

use AppBundle\Model\Operator\BeginsWithOperator;
use AppBundle\Model\Operator\BetweenOperator;
use AppBundle\Model\Operator\ContainsOperator;
use AppBundle\Model\Operator\EndsWithOperator;
use AppBundle\Model\Operator\EqualOperator;
use AppBundle\Model\Operator\GreaterOperator;
use AppBundle\Model\Operator\GreaterOrEqualOperator;
use AppBundle\Model\Operator\InOperator;
use AppBundle\Model\Operator\IsEmptyOperator;
use AppBundle\Model\Operator\IsNotEmptyOperator;
use AppBundle\Model\Operator\IsNotNullOperator;
use AppBundle\Model\Operator\IsNullOperator;
use AppBundle\Model\Operator\LessOperator;
use AppBundle\Model\Operator\LessOrEqualOperator;
use AppBundle\Model\Operator\NotBeginsWithOperator;
use AppBundle\Model\Operator\NotBetweenOperator;
use AppBundle\Model\Operator\NotContainsOperator;
use AppBundle\Model\Operator\NotEndsWithOperator;
use AppBundle\Model\Operator\NotEqualOperator;
use AppBundle\Model\Operator\NotInOperator;

/**
 * Class OperatorAggregator
 * @package AppBundle\Model\Operator\PrebuiltAggregate
 *
 * NOTE: replace/remake this(DRY) or keep it plain simple stupid, because it does not matter much?
 */
class OperatorAggregator
{
    /**
     * TYPES
     */
    const TEXT_INPUT_TYPE    = 1;
    const SELECT_TYPE        = 2;
    const NUMERIC_INPUT_TYPE = 3;

    /**
     * SIZES
     */
    const BASIC_SIZE = 1;
    const FULL_SIZE  = 2;

    private function __construct()
    {
    }

    public static function getOperators($type, $size = self::BASIC_SIZE)
    {
        $operators = array();

        switch ($type) {
            case self::TEXT_INPUT_TYPE:
                switch ($size) {
                    case self::FULL_SIZE:
                        $operators[] = new IsNullOperator();
                        $operators[] = new IsNotNullOperator();
                        $operators[] = new InOperator();
                        $operators[] = new NotInOperator();
                        $operators[] = new IsEmptyOperator();
                        $operators[] = new IsNotEmptyOperator();
                    //Fallthrough, FULL_SIZE contains all other operators
                    case self::BASIC_SIZE:
                        $operators[] = new EqualOperator();
                        $operators[] = new NotEqualOperator();
                        $operators[] = new BeginsWithOperator();
                        $operators[] = new EndsWithOperator();
                        $operators[] = new NotBeginsWithOperator();
                        $operators[] = new NotEndsWithOperator();
                        $operators[] = new ContainsOperator();
                        $operators[] = new NotContainsOperator();
                        break;
                    default:
                        throw new \InvalidArgumentException('Unsupported operator aggregator size.');
                }
                break;
            case self::SELECT_TYPE:
                switch ($size) {
                    case self::FULL_SIZE:
                        $operators[] = new IsNullOperator();
                        $operators[] = new IsNotNullOperator();
                    //Fallthrough, FULL_SIZE contains all other operators
                    case self::BASIC_SIZE:
                        $operators[] = new EqualOperator();
                        $operators[] = new NotEqualOperator();
                        $operators[] = new InOperator();
                        $operators[] = new NotInOperator();
                        break;
                    default:
                        throw new \InvalidArgumentException('Unsupported operator aggregator size.');
                }
                break;
            case self::NUMERIC_INPUT_TYPE:
                switch ($size) {
                    case self::FULL_SIZE:
                        $operators[] = new IsNullOperator();
                        $operators[] = new IsNotNullOperator();
                        $operators[] = new BetweenOperator();
                        $operators[] = new NotBetweenOperator();
                    //Fallthrough, FULL_SIZE contains all other operators
                    case self::BASIC_SIZE:
                        $operators[] = new EqualOperator();
                        $operators[] = new NotEqualOperator();
                        $operators[] = new LessOperator();
                        $operators[] = new LessOrEqualOperator();
                        $operators[] = new GreaterOperator();
                        $operators[] = new GreaterOrEqualOperator();
                        break;
                    default:
                        throw new \InvalidArgumentException('Unsupported operator aggregator size.');
                }
                break;
            default:
                throw new \InvalidArgumentException('Unsupported operator aggregator type.');
        }

        return $operators;
    }
}

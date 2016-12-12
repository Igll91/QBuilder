<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 11.12.2016.
 * Time: 12:52
 */

namespace AppBundle\Model\Validator;


abstract class MaxValidator extends Validator
{
    /**
     * Querybuilder filtername
     * @var string
     */
    private $name;

    /**
     * Maximal allowed value.
     *
     * @var mixed
     */
    protected $maxValue;

    public function __construct($maxValue)
    {
        parent::__construct(TRUE);
        $this->name     = "max";
        $this->maxValue = $maxValue;
    }

}
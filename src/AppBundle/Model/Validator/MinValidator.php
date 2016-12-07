<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 06.12.2016.
 * Time: 22:56
 */

namespace AppBundle\Model\Validator;


abstract class MinValidator extends Validator
{

    /**
     * Querybuilder filtername
     * @var string
     */
    private $name;

    public function __construct()
    {
        parent::__construct(TRUE);
        $this->name = "min";
    }

    //TODO: prepare for querybuilder syntax
}
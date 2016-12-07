<?php namespace AppBundle\Model\Validator;

/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 06.12.2016.
 * Time: 22:41
 */
abstract class Validator
{

    /**
     * Defines whether validator can be used at querybuilder plugin(frontend).
     *
     * @var bool
     */
    private $isRenderable;

    public function __construct($isRenderable)
    {
        $this->isRenderable = $isRenderable;
    }

    /**
     * @param $value mixed Value to be validated.
     *
     * @return mixed True if valid, false otherwise.
     */
    public abstract function validate($value);

}
<?php namespace AppBundle\Model\Filter;

use AppBundle\Model\Filter\Type\FilterType;
use AppBundle\Model\Validator\Validator;

/**
 * Represents querybuilder Filter object.
 *
 * Backbone for all filter types.
 * Contains required and shared values for querybuilder filter object.
 *
 * http://querybuilder.js.org/
 *
 * Created by PhpStorm.
 * User: silvio
 * Date: 06.12.2016.
 * Time: 22:07
 */
class Filter
{

    /**
     * @var string
     */
    private $identifier;

    /**
     * Querybuilder type of the field.
     *
     * @var FilterType
     */
    private $type;

    /**
     * Label that will be displayed to user.
     *
     * @var string
     *
     * TODO: localization map
     */
    private $label;

    /**
     * Optional id of an group.
     *
     * Used for grouping multiple Filter's into same group.
     *
     * @var string
     */
    private $optgroup;

    /**
     * Default value that will be set for filter.
     *
     * @var mixed
     */
    private $defaultValue;

    /**
     * Array of validators that are applicable to this filter.
     *
     * @var array
     */
    private $validators;

    public function __construct($identifier, FilterType $type)
    {
        // Required values for successful build
        $this->identifier = $identifier;
        $this->type       = $type;
        $this->validators = array();
    }

//======================================================================================================================
// INSERTION
//======================================================================================================================

    public function addValidator(Validator $validator)
    {
        if (in_array($validator, $this->validators, true)) {
            throw new \InvalidArgumentException("Validator ${validator} already inserted!");
        }

        $this->validators[] = $validator;
    }

    public function addValidators(array $validators)
    {
        array_walk($validators, array($this, 'addValidator'));
    }

//======================================================================================================================
// GETTERS & SETTERS
//======================================================================================================================

    /**
     * @return FilterType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     *
     * @return Filter
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getOptgroup()
    {
        return $this->optgroup;
    }

    /**
     * @param string $optgroup
     *
     * @return Filter
     */
    public function setOptgroup($optgroup)
    {
        $this->optgroup = $optgroup;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @param mixed $defaultValue
     *
     * @return Filter
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }

    /**
     * @return Validator[]
     */
    public function getValidators()
    {
        return $this->validators;
    }
}

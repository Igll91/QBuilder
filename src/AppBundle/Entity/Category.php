<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $identifier;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var CategoryType
     *
     * @ORM\ManyToOne(targetEntity="CategoryType")
     * @ORM\JoinColumn(name="category_type_id", referencedColumnName="id")
     */
    private $type;

//======================================================================================================================
// GETTERS & SETTERS
//======================================================================================================================

    /**
     * Get id
     *
     * @return int
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param \AppBundle\Entity\CategoryType $type
     *
     * @return Category
     */
    public function setType(\AppBundle\Entity\CategoryType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\CategoryType
     */
    public function getType()
    {
        return $this->type;
    }
}

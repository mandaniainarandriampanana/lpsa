<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeEvenementCategorie
 *
 * @ORM\Table(name="evenement_categorie_type")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\TypeEvenementCategorieRepository")
 */
class TypeEvenementCategorie extends Base
{
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\EvenementCategorie", mappedBy="typeEvenementCategorie")
     */
    private $evenementCategories;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->evenementCategories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add evenementCategory
     *
     * @param \Lpsa\AppBundle\Entity\EvenementCategorie $evenementCategory
     *
     * @return TypeEvenementCategorie
     */
    public function addEvenementCategory(\Lpsa\AppBundle\Entity\EvenementCategorie $evenementCategory)
    {
        $this->evenementCategories[] = $evenementCategory;

        return $this;
    }

    /**
     * Remove evenementCategory
     *
     * @param \Lpsa\AppBundle\Entity\EvenementCategorie $evenementCategory
     */
    public function removeEvenementCategory(\Lpsa\AppBundle\Entity\EvenementCategorie $evenementCategory)
    {
        $this->evenementCategories->removeElement($evenementCategory);
    }

    /**
     * Get evenementCategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvenementCategories()
    {
        return $this->evenementCategories;
    }
}

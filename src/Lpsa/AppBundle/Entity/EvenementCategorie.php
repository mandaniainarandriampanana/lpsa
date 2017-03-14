<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EvenementCategorie
 *
 * @ORM\Table(name="evenement_categorie")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\EvenementCategorieRepository")
 */
class EvenementCategorie extends Base
{
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\EvenementCategorieTable", mappedBy="evenementCategorie")
     */
    private $evenementCategorieTables;
    
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\Evenement", mappedBy="categorie")
     */
    private $evenements;
    
    /**
     * @var TypeEvenementCategorie
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\TypeEvenementCategorie", inversedBy="evenementCategories")
     * @ORM\JoinColumn(name="evenement_categorie_type_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $typeEvenementCategorie;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->evenementCategorieTables = new \Doctrine\Common\Collections\ArrayCollection();
        $this->evenements = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add evenementCategorieTables
     *
     * @param \Lpsa\AppBundle\Entity\EvenementCategorieTable $evenementCategorieTables
     * @return EvenementCategorie
     */
    public function addEvenementCategorieTable(\Lpsa\AppBundle\Entity\EvenementCategorieTable $evenementCategorieTables)
    {
        $this->evenementCategorieTables[] = $evenementCategorieTables;

        return $this;
    }

    /**
     * Remove evenementCategorieTables
     *
     * @param \Lpsa\AppBundle\Entity\EvenementCategorieTable $evenementCategorieTables
     */
    public function removeEvenementCategorieTable(\Lpsa\AppBundle\Entity\EvenementCategorieTable $evenementCategorieTables)
    {
        $this->evenementCategorieTables->removeElement($evenementCategorieTables);
    }

    /**
     * Get evenementCategorieTables
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvenementCategorieTables()
    {
        return $this->evenementCategorieTables;
    }

    /**
     * Add evenement
     *
     * @param \Lpsa\AppBundle\Entity\Evenement $evenement
     *
     * @return EvenementCategorie
     */
    public function addEvenement(\Lpsa\AppBundle\Entity\Evenement $evenement)
    {
        $this->evenements[] = $evenement;

        return $this;
    }

    /**
     * Remove evenement
     *
     * @param \Lpsa\AppBundle\Entity\Evenement $evenement
     */
    public function removeEvenement(\Lpsa\AppBundle\Entity\Evenement $evenement)
    {
        $this->evenements->removeElement($evenement);
    }

    /**
     * Get evenements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvenements()
    {
        return $this->evenements;
    }

    /**
     * Set typeEvenementCategorie
     *
     * @param \Lpsa\AppBundle\Entity\TypeEvenementCategorie $typeEvenementCategorie
     *
     * @return EvenementCategorie
     */
    public function setTypeEvenementCategorie(\Lpsa\AppBundle\Entity\TypeEvenementCategorie $typeEvenementCategorie = null)
    {
        $this->typeEvenementCategorie = $typeEvenementCategorie;

        return $this;
    }

    /**
     * Get typeEvenementCategorie
     *
     * @return \Lpsa\AppBundle\Entity\TypeEvenementCategorie
     */
    public function getTypeEvenementCategorie()
    {
        return $this->typeEvenementCategorie;
    }
}

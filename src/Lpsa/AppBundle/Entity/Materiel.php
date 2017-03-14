<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Materiel
 *
 * @ORM\Table(name="materiel")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\MaterielRepository")
 */
class Materiel extends Base
{
    /**
     * @var Gravite
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Gravite", inversedBy="materiels")
     * @ORM\JoinColumn(name="gravite_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $gravite;
    
    /**
     * @var TypeCorporel
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\TypeMateriel", inversedBy="materiels")
     * @ORM\JoinColumn(name="type_materiel_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $typeMateriel;

    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\Evenement", mappedBy="materiel")
     */
    private $evenements;
    
    /**
     * Set gravite
     *
     * @param \Lpsa\AppBundle\Entity\Gravite $gravite
     *
     * @return Materiel
     */
    public function setGravite(\Lpsa\AppBundle\Entity\Gravite $gravite = null)
    {
        $this->gravite = $gravite;

        return $this;
    }

    /**
     * Get gravite
     *
     * @return \Lpsa\AppBundle\Entity\Gravite
     */
    public function getGravite()
    {
        return $this->gravite;
    }

    /**
     * Set typeMateriel
     *
     * @param \Lpsa\AppBundle\Entity\TypeMateriel $typeMateriel
     *
     * @return Materiel
     */
    public function setTypeMateriel(\Lpsa\AppBundle\Entity\TypeMateriel $typeMateriel = null)
    {
        $this->typeMateriel = $typeMateriel;

        return $this;
    }

    /**
     * Get typeMateriel
     *
     * @return \Lpsa\AppBundle\Entity\TypeMateriel
     */
    public function getTypeMateriel()
    {
        return $this->typeMateriel;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->evenements = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add evenement
     *
     * @param \Lpsa\AppBundle\Entity\Evenement $evenement
     *
     * @return Materiel
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
    
    /* Proxy of relationship manyToOne
     * @return int|null
     */
    public function getParent(){
        return ($this->getTypeMateriel()) ? $this->getTypeMateriel()->getId() : null;
    }
}

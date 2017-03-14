<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeMateriel
 *
 * @ORM\Table(name="type_materiel")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\TypeMaterielRepository")
 */
class TypeMateriel extends Base
{
   /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\Materiel", mappedBy="typeMateriel")
     */
    private $materiels;
     public function __construct(){
        $this->materiels = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add materiel
     *
     * @param \Lpsa\AppBundle\Entity\Materiel $materiel
     *
     * @return TypeMateriel
     */
    public function addMateriel(\Lpsa\AppBundle\Entity\Materiel $materiel)
    {
        $this->materiels[] = $materiel;

        return $this;
    }

    /**
     * Remove materiel
     *
     * @param \Lpsa\AppBundle\Entity\Materiel $materiel
     */
    public function removeMateriel(\Lpsa\AppBundle\Entity\Materiel $materiel)
    {
        $this->materiels->removeElement($materiel);
    }

    /**
     * Get materiels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMateriels()
    {
        return $this->materiels;
    }
}

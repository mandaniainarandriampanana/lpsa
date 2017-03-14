<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeEnvironnement
 *
 * @ORM\Table(name="type_environnement")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\TypeEnvironnementRepository")
 */
class TypeEnvironnement extends Base
{
     /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\Environnement", mappedBy="typeEnvironnement")
     */
    private  $environnements;
    
    public function __construct()
    {
        $this->environnements = new \Doctrine\Common\Collections\ArrayCollection();
    }
   

    /**
     * Add environnement
     *
     * @param \Lpsa\AppBundle\Entity\Environnement $environnement
     *
     * @return Environnement
     */
    public function addEvenement(\Lpsa\AppBundle\Entity\Environnement $environnement)
    {
        $this->environnements[] = $environnement;

        return $this;
    }

    /**
     * Remove environnement
     *
     * @param \Lpsa\AppBundle\Entity\Environnement $environnement
     */
    public function removeEvenement(\Lpsa\AppBundle\Entity\Environnement $environnement)
    {
        $this->environnements->removeElement($environnement);
    }

    /**
     * Get environnements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvenements()
    {
        return $this->environnements;
    }
}

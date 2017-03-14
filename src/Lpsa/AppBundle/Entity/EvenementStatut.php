<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EvenementStatut
 *
 * @ORM\Table(name="evenement_statut")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\EvenementStatutRepository")
 */
class EvenementStatut Extends Base
{
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\Evenement", mappedBy="evenementStatut")
     */
    private $evenements;    
    
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
     * @return EvenementStatut
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
}

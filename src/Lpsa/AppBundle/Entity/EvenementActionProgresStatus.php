<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EvenementActionProgresStatus
 *
 * @ORM\Table(name="evenement_action_progres_status")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\EvenementActionProgresStatusRepository")
 */
class EvenementActionProgresStatus extends Base
{
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\EvenementActionProgres", mappedBy="evenementActionProgresStatus")
     */
    private $evenementActionProgres;
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->evenementActionProgres = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add evenementActionProgre
     *
     * @param \Lpsa\AppBundle\Entity\EvenementActionProgres $evenementActionProgre
     *
     * @return EvenementActionProgresStatus
     */
    public function addEvenementActionProgre(\Lpsa\AppBundle\Entity\EvenementActionProgres $evenementActionProgre)
    {
        $this->evenementActionProgres[] = $evenementActionProgre;

        return $this;
    }

    /**
     * Remove evenementActionProgre
     *
     * @param \Lpsa\AppBundle\Entity\EvenementActionProgres $evenementActionProgre
     */
    public function removeEvenementActionProgre(\Lpsa\AppBundle\Entity\EvenementActionProgres $evenementActionProgre)
    {
        $this->evenementActionProgres->removeElement($evenementActionProgre);
    }

    /**
     * Get evenementActionProgres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvenementActionProgres()
    {
        return $this->evenementActionProgres;
    }
}

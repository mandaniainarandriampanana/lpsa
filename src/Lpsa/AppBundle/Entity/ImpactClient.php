<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImpactClient
 *
 * @ORM\Table(name="impact_client")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\ImpactClientRepository")
 */
class ImpactClient extends Base
{
    /**
     * @var Gravite
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Gravite", inversedBy="impactClients")
     * @ORM\JoinColumn(name="gravite_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $gravite;
    
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\Evenement", mappedBy="impactClient")
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
     * Set gravite
     *
     * @param \Lpsa\AppBundle\Entity\Gravite $gravite
     * @return ImpactClient
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
     * Add evenement
     *
     * @param \Lpsa\AppBundle\Entity\Evenement $evenement
     *
     * @return ImpactClient
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

<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Service
 *
 * @ORM\Table(name="service")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\ServiceRepository")
 */
class Service extends Base
{
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\UserBundle\Entity\User", mappedBy="service")
     */
    private $users;
    
    /**
     * @var Departement
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Departement", inversedBy="services")
     * @ORM\JoinColumn(name="departement_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $departement;
    
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\ResponsableService", mappedBy="service")
     */
    private $responsableServices;

    /**
     * Set departement
     *
     * @param \Lpsa\AppBundle\Entity\Departement $departement
     *
     * @return Service
     */
    public function setDepartement(\Lpsa\AppBundle\Entity\Departement $departement = null)
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * Get departement
     *
     * @return \Lpsa\AppBundle\Entity\Departement
     */
    public function getDepartement()
    {
        return $this->departement;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->responsableServices = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add responsableService
     *
     * @param \Lpsa\AppBundle\Entity\ResponsableService $responsableService
     *
     * @return Service
     */
    public function addResponsableService(\Lpsa\AppBundle\Entity\ResponsableService $responsableService)
    {
        $this->responsableServices[] = $responsableService;

        return $this;
    }

    /**
     * Remove responsableService
     *
     * @param \Lpsa\AppBundle\Entity\ResponsableService $responsableService
     */
    public function removeResponsableService(\Lpsa\AppBundle\Entity\ResponsableService $responsableService)
    {
        $this->responsableServices->removeElement($responsableService);
    }

    /**
     * Get responsableServices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResponsableServices()
    {
        return $this->responsableServices;
    }
    
    public function getParent(){
        return ($this->getDepartement()) ? $this->getDepartement()->getId() : null;
    }
}

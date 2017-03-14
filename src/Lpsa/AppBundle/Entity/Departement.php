<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Departement
 *
 * @ORM\Table(name="departement")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\DepartementRepository")
 */
class Departement extends Base
{
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\UserBundle\Entity\User", mappedBy="departement")
     */
    private $users;
    
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\Service", mappedBy="departement")
     */
    private $services;
    
    /**
     * @var Direction
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Direction", inversedBy="departements")
     * @ORM\JoinColumn(name="direction_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $direction;
    
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\ResponsableService", mappedBy="departement")
     */
    private $responsableServices;

    /**
     * Set direction
     *
     * @param \Lpsa\AppBundle\Entity\Direction $direction
     *
     * @return Departement
     */
    public function setDirection(\Lpsa\AppBundle\Entity\Direction $direction = null)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * Get direction
     *
     * @return \Lpsa\AppBundle\Entity\Direction
     */
    public function getDirection()
    {
        return $this->direction;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->services = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add service
     *
     * @param \Lpsa\AppBundle\Entity\Service $service
     *
     * @return Departement
     */
    public function addService(\Lpsa\AppBundle\Entity\Service $service)
    {
        $this->services[] = $service;

        return $this;
    }

    /**
     * Remove service
     *
     * @param \Lpsa\AppBundle\Entity\Service $service
     */
    public function removeService(\Lpsa\AppBundle\Entity\Service $service)
    {
        $this->services->removeElement($service);
    }

    /**
     * Get services
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * Add responsableService
     *
     * @param \Lpsa\AppBundle\Entity\ResponsableService $responsableService
     *
     * @return Departement
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

    /**
     * Add user
     *
     * @param \Lpsa\UserBundle\Entity\User $user
     *
     * @return Departement
     */
    public function addUser(\Lpsa\UserBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \Lpsa\UserBundle\Entity\User $user
     */
    public function removeUser(\Lpsa\UserBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
    public function getParent(){
        return ($this->getDirection()) ? $this->getDirection()->getId() : null;
    }
}

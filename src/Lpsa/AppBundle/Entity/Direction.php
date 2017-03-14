<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Direction
 *
 * @ORM\Table(name="direction")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\DirectionRepository")
 */
class Direction extends Base
{  
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\Departement", mappedBy="direction")
     */
    private $departements;
    
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\UserBundle\Entity\User", mappedBy="direction")
     */
    private $users;
    
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\ResponsableService", mappedBy="direction")
     */
    private $responsableServices;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->departements = new \Doctrine\Common\Collections\ArrayCollection();
        $this->directions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add departement
     *
     * @param \Lpsa\AppBundle\Entity\Departement $departement
     *
     * @return Direction
     */
    public function addDepartement(\Lpsa\AppBundle\Entity\Departement $departement)
    {
        $this->departements[] = $departement;

        return $this;
    }

    /**
     * Remove departement
     *
     * @param \Lpsa\AppBundle\Entity\Departement $departement
     */
    public function removeDepartement(\Lpsa\AppBundle\Entity\Departement $departement)
    {
        $this->departements->removeElement($departement);
    }

    /**
     * Get departements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDepartements()
    {
        return $this->departements;
    }

    /**
     * Add responsableService
     *
     * @param \Lpsa\AppBundle\Entity\ResponsableService $responsableService
     *
     * @return Direction
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
     * @return Direction
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
}

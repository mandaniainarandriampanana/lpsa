<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Depot
 *
 * @ORM\Table(name="responsable_service")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\ResponsableServiceRepository")
 */
class ResponsableService extends Base
{
    /**
     * @var Departement
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Departement", inversedBy="responsableServices")
     * @ORM\JoinColumn(name="departement_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $departement;
    
    /**
     * @var Service
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Service", inversedBy="responsableServices")
     * @ORM\JoinColumn(name="service_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $service;
    
    /**
     * @var Direction
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Direction", inversedBy="responsableServices")
     * @ORM\JoinColumn(name="direction_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $direction;

    /**
     * @var User
     *  
     * @ORM\ManyToMany(targetEntity="Lpsa\UserBundle\Entity\User", inversedBy="responsableServices")
     * @ORM\JoinTable(name="responsable_service_user")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $users;
    
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\EvenementActionProgres", mappedBy="responsableService")
     */
    private $evenementActionProgres;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->evenementActionProgres = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * Add user
     *
     * @param \Lpsa\UserBundle\Entity\User $user
     *
     * @return ResponsableService
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

    /**
     * Add evenementActionProgre
     *
     * @param \Lpsa\AppBundle\Entity\EvenementActionProgres $evenementActionProgre
     *
     * @return ResponsableService
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

    /**
     * Set departement
     *
     * @param \Lpsa\AppBundle\Entity\Departement $departement
     *
     * @return ResponsableService
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
     * Set service
     *
     * @param \Lpsa\AppBundle\Entity\Service $service
     *
     * @return ResponsableService
     */
    public function setService(\Lpsa\AppBundle\Entity\Service $service = null)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \Lpsa\AppBundle\Entity\Service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set direction
     *
     * @param \Lpsa\AppBundle\Entity\Direction $direction
     *
     * @return ResponsableService
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
}

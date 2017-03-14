<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Fonction
 *
 * @ORM\Table(name="fonction")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\FonctionRepository")
 */
class Fonction extends Base
{ 
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\UserBundle\Entity\User", mappedBy="fonction")
     */
    private $users;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add user
     *
     * @param \Lpsa\UserBundle\Entity\User $user
     *
     * @return Fonction
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

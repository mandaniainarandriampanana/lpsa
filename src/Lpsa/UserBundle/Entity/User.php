<?php

namespace Lpsa\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Lpsa\UserBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 */

class User extends BaseUser{
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToMany(targetEntity="Lpsa\UserBundle\Entity\Group")
     * @ORM\JoinTable(name="user_userGroup",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected $groups;
    
    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="matricule", type="integer")
     */
    private $matricule;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Departement", inversedBy="users")
     * @ORM\JoinColumn(name="departement_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $departement;
    
    /**
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Direction", inversedBy="users")
     * @ORM\JoinColumn(name="direction_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $direction;
    
    /**
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Fonction", inversedBy="users")
     * @ORM\JoinColumn(name="fonction_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $fonction;
    
    /**
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Service", inversedBy="users")
     * @ORM\JoinColumn(name="service_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $service;

    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\Evenement", mappedBy="user")
     */
    private $evenements;
    
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\EvenementHistorique", mappedBy="user")
     */
    private $evenementHitoriques;
    
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\Evenement", mappedBy="userDeclarant")
     */
    private $declarantEvenements;
    
    /**
     * @var User
     *  
     * @ORM\ManyToMany(targetEntity="Lpsa\AppBundle\Entity\ResponsableService", mappedBy="users")
     * @ORM\JoinColumn(name="responsable_service_id", referencedColumnName="id")
     */
    private $responsableServices;

    public function __construct()
    {
        parent::__construct();
        $this->evenements = new \Doctrine\Common\Collections\ArrayCollection();
        $this->declarantEvenements = new \Doctrine\Common\Collections\ArrayCollection();
        $this->responsableServices = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return User
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
        $this->updated = new \DateTime();

        return $this;
    }

    /**
     * Set matricule
     *
     * @param integer $matricule
     *
     * @return User
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * Get matricule
     *
     * @return integer
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Set fonction
     *
     * @param \Lpsa\AppBundle\Entity\Fonction $fonction
     *
     * @return User
     */
    public function setFonction(\Lpsa\AppBundle\Entity\Fonction $fonction = null)
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * Get fonction
     *
     * @return \Lpsa\AppBundle\Entity\Fonction
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * Add evenement
     *
     * @param \Lpsa\AppBundle\Entity\Evenement $evenement
     *
     * @return User
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

    /**
     * Add declarantEvenement
     *
     * @param \Lpsa\AppBundle\Entity\Evenement $declarantEvenement
     *
     * @return User
     */
    public function addDeclarantEvenement(\Lpsa\AppBundle\Entity\Evenement $declarantEvenement)
    {
        $this->declarantEvenements[] = $declarantEvenement;

        return $this;
    }

    /**
     * Remove declarantEvenement
     *
     * @param \Lpsa\AppBundle\Entity\Evenement $declarantEvenement
     */
    public function removeDeclarantEvenement(\Lpsa\AppBundle\Entity\Evenement $declarantEvenement)
    {
        $this->declarantEvenements->removeElement($declarantEvenement);
    }

    /**
     * Get declarantEvenements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDeclarantEvenements()
    {
        return $this->declarantEvenements;
    }

    /**
     * Add responsableService
     *
     * @param \Lpsa\AppBundle\Entity\ResponsableService $responsableService
     *
     * @return User
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
     * Text to be shown on ajax 
     * 
     * @return string
     */
    public function getLabelToPrint(){
        return $this->getLastname() . " " . $this->getFirstname();
    }

    /**
     * Set departement
     *
     * @param \Lpsa\AppBundle\Entity\Departement $departement
     *
     * @return User
     */
    public function setDepartement(\Lpsa\AppBundle\Entity\Departement $departement=null)
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
     * Set direction
     *
     * @param \Lpsa\AppBundle\Entity\Direction $direction
     *
     * @return User
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
     * Set service
     *
     * @param \Lpsa\AppBundle\Entity\Service $service
     *
     * @return User
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
     * Add evenementHitorique
     *
     * @param \Lpsa\AppBundle\Entity\EvenementHistorique $evenementHitorique
     *
     * @return User
     */
    public function addEvenementHitorique(\Lpsa\AppBundle\Entity\EvenementHistorique $evenementHitorique)
    {
        $this->evenementHitoriques[] = $evenementHitorique;

        return $this;
    }

    /**
     * Remove evenementHitorique
     *
     * @param \Lpsa\AppBundle\Entity\EvenementHistorique $evenementHitorique
     */
    public function removeEvenementHitorique(\Lpsa\AppBundle\Entity\EvenementHistorique $evenementHitorique)
    {
        $this->evenementHitoriques->removeElement($evenementHitorique);
    }

    /**
     * Get evenementHitoriques
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvenementHitoriques()
    {
        return $this->evenementHitoriques;
    }
}

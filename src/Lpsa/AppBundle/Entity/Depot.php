<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Depot
 *
 * @ORM\Table(name="depot")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\DepotRepository")
 */
class Depot extends Base
{
    /**
     * @var string
     *
     * @ORM\Column(name="sigle", type="string", length=50)
     * @Assert\NotBlank()
     */
    protected $sigle ;
    /**
     * @var string
     *
     * @ORM\Column(name="responsable_email_cdd", type="string", length=255, nullable=true)
     * @Assert\Email()
     */
    protected $responsableEmailCdd;
    /**
     * @var string
     *
     * @ORM\Column(name="responsable_email_adm ", type="string", length=255, nullable=true)
     * @Assert\Email()
     */
    protected $responsableEmailAdm;
    /**
    * @ORM\ManyToOne(targetEntity="DepotCategorie", inversedBy="depot")
    * @ORM\JoinColumn(name="depot_categorie_id", referencedColumnName="id",onDelete="CASCADE")
    */
    private $depotcategories;
    
   /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\Evenement", mappedBy="depot")
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
     * Set depotcategories
     *
     * @param \Lpsa\AppBundle\Entity\DepotCategorie $depotcategories
     *
     * @return Depot
     */
    public function setDepotcategories(\Lpsa\AppBundle\Entity\DepotCategorie $depotcategories = null)
    {
        $this->depotcategories = $depotcategories;

        return $this;
    }

    /**
     * Get depotcategories
     *
     * @return \Lpsa\AppBundle\Entity\DepotCategorie
     */
    public function getDepotcategories()
    {
        return $this->depotcategories;
    }

    /**
     * Add evenement
     *
     * @param \Lpsa\AppBundle\Entity\Evenement $evenement
     *
     * @return Depot
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
     * Set sigle
     *
     * @param string $sigle
     *
     * @return Depot
     */
    public function setSigle($sigle)
    {
        $this->sigle = $sigle;

        return $this;
    }

    /**
     * Get sigle
     *
     * @return string
     */
    public function getSigle()
    {
        return $this->sigle;
    }

    /**
     * Set responsableEmailCdd
     *
     * @param string $responsableEmailCdd
     *
     * @return Depot
     */
    public function setResponsableEmailCdd($responsableEmailCdd)
    {
        $this->responsableEmailCdd = $responsableEmailCdd;

        return $this;
    }

    /**
     * Get responsableEmailCdd
     *
     * @return string
     */
    public function getResponsableEmailCdd()
    {
        return $this->responsableEmailCdd;
    }

    /**
     * Set responsableEmailAdm
     *
     * @param string $responsableEmailAdm
     *
     * @return Depot
     */
    public function setResponsableEmailAdm($responsableEmailAdm)
    {
        $this->responsableEmailAdm = $responsableEmailAdm;

        return $this;
    }

    /**
     * Get responsableEmailAdm
     *
     * @return string
     */
    public function getResponsableEmailAdm()
    {
        return $this->responsableEmailAdm;
    }
    
    /* Proxy of relationship manyToOne
     * @return int|null
     */
    public function getParent(){
        return ($this->getDepotcategories()) ? $this->getDepotcategories()->getId() : null;
    }
}

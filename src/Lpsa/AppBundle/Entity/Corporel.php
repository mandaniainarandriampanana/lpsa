<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Corporel
 *
 * @ORM\Table(name="corporel")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\CorporelRepository")
 */
class Corporel extends Base
{
   /**
     * @var Gravite
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Gravite", inversedBy="corporels")
     * @ORM\JoinColumn(name="gravite_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $gravite;
    
    /**
     * @var TypeCorporel
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\TypeCorporel", inversedBy="corporels")
     * @ORM\JoinColumn(name="type_corporel_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $typeCorporel;

    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\Evenement", mappedBy="corporel")
     */
    private $evenements;
    
    /**
     * @var int
     *
     * @ORM\Column(name="total_max", type="integer", nullable=true, options={"default":0})
     * @Assert\Type("integer")
     */
    protected $totalMax; 
    
    /**
     * Set gravite
     *
     * @param \Lpsa\AppBundle\Entity\Gravite $gravite
     *
     * @return Corporel
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
     * Set typeCorporel
     *
     * @param \Lpsa\AppBundle\Entity\TypeCorporel $typeCorporel
     *
     * @return Corporel
     */
    public function setTypeCorporel(\Lpsa\AppBundle\Entity\TypeCorporel $typeCorporel = null)
    {
        $this->typeCorporel = $typeCorporel;

        return $this;
    }

    /**
     * Get typeCorporel
     *
     * @return \Lpsa\AppBundle\Entity\TypeCorporel
     */
    public function getTypeCorporel()
    {
        return $this->typeCorporel;
    }
    
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
     * @return Corporel
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
     * Proxy of relationship manyToOne
     * @return int|null
     */
    public function getParent(){
        return ($this->getTypeCorporel()) ? $this->getTypeCorporel()->getId() : null;
    }

    /**
     * Set totalMax
     *
     * @param integer $totalMax
     *
     * @return Corporel
     */
    public function setTotalMax($totalMax)
    {
        $this->totalMax = $totalMax;

        return $this;
    }

    /**
     * Get totalMax
     *
     * @return integer
     */
    public function getTotalMax()
    {
        return $this->totalMax;
    }
}

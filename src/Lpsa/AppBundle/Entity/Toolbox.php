<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Toolbox
 *
 * @ORM\Table(name="toolbox")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\ToolboxRepository")
 */
class Toolbox
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="siege", type="integer", options={"default":0})
     */
    private $siege = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="depots", type="integer", options={"default":0})
     */
    private $depots = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="sct", type="integer", options={"default":0})
     */
    private $sct = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="mois", type="integer")
     */
    private $mois;

    /**
     * @var int
     *
     * @ORM\Column(name="annee", type="integer")
     */
    private $annee;

    /**
    * @ORM\ManyToOne(targetEntity="Depot")
    * @ORM\JoinColumn(name="depot_id", referencedColumnName="id",onDelete="CASCADE")
    */
    private $depot;

    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\ToolboxPj", mappedBy="toolbox",cascade={"persist"})
     */
    private $toolboxPjs;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set siege
     *
     * @param integer $siege
     *
     * @return Toolbox
     */
    public function setSiege($siege)
    {
        $this->siege = $siege;
    
        return $this;
    }

    /**
     * Get siege
     *
     * @return integer
     */
    public function getSiege()
    {
        return $this->siege;
    }

    /**
     * Set depots
     *
     * @param integer $depots
     *
     * @return Toolbox
     */
    public function setDepots($depots)
    {
        $this->depots = $depots;
    
        return $this;
    }

    /**
     * Get depots
     *
     * @return integer
     */
    public function getDepots()
    {
        return $this->depots;
    }

    /**
     * Set sct
     *
     * @param integer $sct
     *
     * @return Toolbox
     */
    public function setSct($sct)
    {
        $this->sct = $sct;
    
        return $this;
    }

    /**
     * Get sct
     *
     * @return integer
     */
    public function getSct()
    {
        return $this->sct;
    }

    /**
     * Set mois
     *
     * @param integer $mois
     *
     * @return Toolbox
     */
    public function setMois($mois)
    {
        $this->mois = $mois;
    
        return $this;
    }

    /**
     * Get mois
     *
     * @return integer
     */
    public function getMois()
    {
        return $this->mois;
    }

    /**
     * Set annee
     *
     * @param integer $annee
     *
     * @return Toolbox
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;
    
        return $this;
    }

    /**
     * Get annee
     *
     * @return integer
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set depot
     *
     * @param \Lpsa\AppBundle\Entity\Depot $depot
     *
     * @return Toolbox
     */
    public function setDepot(\Lpsa\AppBundle\Entity\Depot $depot = null)
    {
        $this->depot = $depot;

        return $this;
    }

    /**
     * Get depot
     *
     * @return \Lpsa\AppBundle\Entity\Depot
     */
    public function getDepot()
    {
        return $this->depot;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->toolboxPjs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add toolboxPj
     *
     * @param \Lpsa\AppBundle\Entity\ToolboxPj $toolboxPj
     *
     * @return Toolbox
     */
    public function addToolboxPj(\Lpsa\AppBundle\Entity\ToolboxPj $toolboxPj)
    {
        $this->toolboxPjs[] = $toolboxPj;

        return $this;
    }

    /**
     * Remove toolboxPj
     *
     * @param \Lpsa\AppBundle\Entity\ToolboxPj $toolboxPj
     */
    public function removeToolboxPj(\Lpsa\AppBundle\Entity\ToolboxPj $toolboxPj)
    {
        $this->toolboxPjs->removeElement($toolboxPj);
    }

    /**
     * Get toolboxPjs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getToolboxPjs()
    {
        return $this->toolboxPjs;
    }
}

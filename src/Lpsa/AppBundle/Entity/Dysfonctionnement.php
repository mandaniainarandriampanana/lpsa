<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dysfonctionnement
 *
 * @ORM\Table(name="dysfonctionnement")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\DysfonctionnementRepository")
 */
class Dysfonctionnement extends Base
{
   /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\Evenement", mappedBy="dysfonctionnement")
     */
    private $evenements;
    
    /**
     * @var Gravite
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Gravite", inversedBy="dysfonctionnements")
     * @ORM\JoinColumn(name="gravite_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $gravite;
    
    public function __construct(){
        $this->evenements = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add evenement
     *
     * @param \Lpsa\AppBundle\Entity\Evenement $evenement
     *
     * @return Dysfonctionnement
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
     * Set gravite
     *
     * @param \Lpsa\AppBundle\Entity\Gravite $gravite
     *
     * @return Dysfonctionnement
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
}

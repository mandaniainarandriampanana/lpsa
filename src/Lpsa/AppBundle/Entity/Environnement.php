<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Environnement
 *
 * @ORM\Table(name="environnement")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\EnvironnementRepository")
 */
class Environnement extends Base
{
    /**
    * @ORM\ManyToOne(targetEntity="Gravite", inversedBy="environnements")
    * @ORM\JoinColumn(name="gravite_id", referencedColumnName="id", onDelete="CASCADE")
    */
    private  $gravite;
    
    /**
    * @ORM\ManyToOne(targetEntity="TypeEnvironnement", inversedBy="environnements")
    * @ORM\JoinColumn(name="type_environnement_id", referencedColumnName="id", onDelete="CASCADE")
    */
    private  $typeEnvironnement;
    
     /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\Evenement", mappedBy="environnement")
     */
    private  $evenements;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="affiche_nbre", type="boolean", options={"default":false})
     */
    protected $afficheNbre; 
    
    /**
     * constructeur
     */
    public function __construct(){
        $this->evenements = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set gravite
     *
     * @param \Lpsa\AppBundle\Entity\Gravite $gravite
     *
     * @return Environnement
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
     * Add evenement
     *
     * @param \Lpsa\AppBundle\Entity\Evenement $evenement
     *
     * @return Environnement
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
     * Set typeEnvironnement
     *
     * @param \Lpsa\AppBundle\Entity\TypeEnvironnement $typeEnvironnement
     *
     * @return Environnement
     */
    public function setTypeEnvironnement(\Lpsa\AppBundle\Entity\TypeEnvironnement $typeEnvironnement = null)
    {
        $this->typeEnvironnement = $typeEnvironnement;

        return $this;
    }

    /**
     * Get typeEnvironnement
     *
     * @return \Lpsa\AppBundle\Entity\TypeEnvironnement
     */
    public function getTypeEnvironnement()
    {
        return $this->typeEnvironnement;
    }
    
    /* Proxy of relationship manyToOne
     * @return int|null
     */
    public function getParent(){
        return ($this->getTypeEnvironnement()) ? $this->getTypeEnvironnement()->getId() : null;
    }

    /**
     * Set afficheNbre
     *
     * @param boolean $afficheNbre
     *
     * @return Environnement
     */
    public function setAfficheNbre($afficheNbre)
    {
        $this->afficheNbre = $afficheNbre;

        return $this;
    }

    /**
     * Get afficheNbre
     *
     * @return boolean
     */
    public function getAfficheNbre()
    {
        return $this->afficheNbre;
    }
}

<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExerciceUrgence
 *
 * @ORM\Table(name="exercice_urgence")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\ExerciceUrgenceRepository")
 */
class ExerciceUrgence
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
     * @ORM\Column(name="nbrePoi", type="integer", options={"default":0})
     */
    private $nbrePoi = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="nbreMiniPoi", type="integer", options={"default":0})
     */
    private $nbreMiniPoi = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrePum", type="integer", options={"default":0})
     */
    private $nbrePum = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="nbreCombine", type="integer", options={"default":0})
     */
    private $nbreCombine = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="nbreCmc", type="integer", options={"default":0})
     */
    private $nbreCmc = 0;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nbrePoi
     *
     * @param integer $nbrePoi
     *
     * @return ExerciceUrgence
     */
    public function setNbrePoi($nbrePoi)
    {
        $this->nbrePoi = $nbrePoi;
    
        return $this;
    }

    /**
     * Get nbrePoi
     *
     * @return integer
     */
    public function getNbrePoi()
    {
        return $this->nbrePoi;
    }

    /**
     * Set nbreMiniPoi
     *
     * @param integer $nbreMiniPoi
     *
     * @return ExerciceUrgence
     */
    public function setNbreMiniPoi($nbreMiniPoi)
    {
        $this->nbreMiniPoi = $nbreMiniPoi;
    
        return $this;
    }

    /**
     * Get nbreMiniPoi
     *
     * @return integer
     */
    public function getNbreMiniPoi()
    {
        return $this->nbreMiniPoi;
    }

    /**
     * Set nbrePum
     *
     * @param integer $nbrePum
     *
     * @return ExerciceUrgence
     */
    public function setNbrePum($nbrePum)
    {
        $this->nbrePum = $nbrePum;
    
        return $this;
    }

    /**
     * Get nbrePum
     *
     * @return integer
     */
    public function getNbrePum()
    {
        return $this->nbrePum;
    }

    /**
     * Set nbreCombine
     *
     * @param integer $nbreCombine
     *
     * @return ExerciceUrgence
     */
    public function setNbreCombine($nbreCombine)
    {
        $this->nbreCombine = $nbreCombine;
    
        return $this;
    }

    /**
     * Get nbreCombine
     *
     * @return integer
     */
    public function getNbreCombine()
    {
        return $this->nbreCombine;
    }

    /**
     * Set nbreCmc
     *
     * @param integer $nbreCmc
     *
     * @return ExerciceUrgence
     */
    public function setNbreCmc($nbreCmc)
    {
        $this->nbreCmc = $nbreCmc;
    
        return $this;
    }

    /**
     * Get nbreCmc
     *
     * @return integer
     */
    public function getNbreCmc()
    {
        return $this->nbreCmc;
    }

    /**
     * Set mois
     *
     * @param integer $mois
     *
     * @return ExerciceUrgence
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
     * @return ExerciceUrgence
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
     * @return ExerciceUrgence
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
}

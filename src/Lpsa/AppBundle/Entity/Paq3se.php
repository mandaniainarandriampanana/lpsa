<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paq3se
 *
 * @ORM\Table(name="paq3se")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\Paq3seRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Paq3se
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
     * @ORM\Column(name="frequence", type="smallint",nullable=true)
     */
    private $frequence;
    
    /**
     * @var int
     *
     * @ORM\Column(name="niveauRisque", type="smallint",nullable=true)
     */
    private $niveauRisque;

    /**
     * @var string
     *
     * @ORM\Column(name="priorite", type="string", length=255,nullable=true)
     */
    private $priorite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="date", nullable=true)
     */
    private $dateFin;
    /**
     *
     * @var type integer
     * 
     * @ORM\Column(name="realisation", type="integer", nullable=true, options={"default":0})
     */
    private $realisation;

    /**
     * @var string
     *
     * @ORM\Column(name="anomalieConstate", type="text", nullable=true)
     */
    private $anomalieConstate;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="text", nullable=true)
     */
    private $action;

    /**
     * @var Evenement
     *
     * @ORM\OneToOne(targetEntity="Lpsa\AppBundle\Entity\Evenement", inversedBy="paq3se")
     * @ORM\JoinColumn(name="evenement_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $evenement;

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
     * Set frequence
     *
     * @param integer $frequence
     *
     * @return Paq3se
     */
    public function setFrequence($frequence)
    {
        $this->frequence = $frequence;
    
        return $this;
    }

    /**
     * Get frequence
     *
     * @return integer
     */
    public function getFrequence()
    {
        return $this->frequence;
    }

    /**
     * Set niveauRisque
     *
     * @param integer $niveauRisque
     *
     * @return Paq3se
     */
    public function setNiveauRisque($niveauRisque)
    {
        $this->niveauRisque = $niveauRisque;
    
        return $this;
    }

    /**
     * Get niveauRisque
     *
     * @return integer
     */
    public function getNiveauRisque()
    {
        return $this->niveauRisque;
    }

    /**
     * Set priorite
     *
     * @param string $priorite
     *
     * @return Paq3se
     */
    public function setPriorite($priorite)
    {
        $this->priorite = $priorite;
    
        return $this;
    }

    /**
     * Get priorite
     *
     * @return string
     */
    public function getPriorite()
    {
        return $this->priorite;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Paq3se
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
    
        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set realisation
     *
     * @param int $realisation
     *
     * @return Paq3se
     */
    public function setRealisation($realisation)
    {
        $this->realisation = $realisation;
    
        return $this;
    }

    /**
     * Get realisation
     *
     * @return int
     */
    public function getRealisation()
    {
        return $this->realisation;
    }

    /**
     * Set anomalieConstate
     *
     * @param string $anomalieConstate
     *
     * @return Paq3se
     */
    public function setAnomalieConstate($anomalieConstate)
    {
        $this->anomalieConstate = $anomalieConstate;
    
        return $this;
    }

    /**
     * Get anomalieConstate
     *
     * @return string
     */
    public function getAnomalieConstate()
    {
        return $this->anomalieConstate;
    }

    /**
     * Set action
     *
     * @param string $action
     *
     * @return Paq3se
     */
    public function setAction($action)
    {
        $this->action = $action;
    
        return $this;
    }

    /**
     * Get action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set isPaqssse
     *
     * @param boolean $isPaqssse
     *
     * @return Paq3se
     */
    public function setIsPaqssse($isPaqssse)
    {
        $this->isPaqssse = $isPaqssse;
    
        return $this;
    }

    /**
     * Get isPaqssse
     *
     * @return boolean
     */
    public function getIsPaqssse()
    {
        return $this->isPaqssse;
    }

    /**
     * Set evenement
     *
     * @param \Lpsa\AppBundle\Entity\Evenement $evenement
     *
     * @return Paq3se
     */
    public function setEvenement(\Lpsa\AppBundle\Entity\Evenement $evenement = null)
    {
        $this->evenement = $evenement;

        return $this;
    }

    /**
     * Get evenement
     *
     * @return \Lpsa\AppBundle\Entity\Evenement
     */
    public function getEvenement()
    {
        return $this->evenement;
    }
}

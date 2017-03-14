<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * EvenementActionProgres
 *
 * @ORM\Table(name="evenement_action_progres")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\EvenementActionProgresRepository")
 */
class EvenementActionProgres
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var Evenement
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Evenement", inversedBy="evenementActionProgres"))
     * @ORM\JoinColumn(name="evenement_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $evenement;
    
    /**
     * @var text
     *
     * @ORM\Column(name="action", type="text", nullable=true)
     */
    private $action;
    
    /**
     * @var ResponsableService
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\ResponsableService", inversedBy="evenementActionProgres")
     * @ORM\JoinColumn(name="responsable_service_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $responsableService;
    
    /**
     * @var ResponsableService
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\EvenementActionProgresStatus", inversedBy="evenementActionProgres")
     * @ORM\JoinColumn(name="action_progres_status_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $evenementActionProgresStatus;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="delai", type="datetime", nullable=true)
     */
    private $delai;
    
    /**
     * @var int
     *
     * @ORM\Column(name="avancement", type="integer", nullable=true, options={"default":0})
     * @Assert\Type(
     *    type="integer"
     * )
     */
    private $avancement;
    
    /**
     * @var text
     *
     * @ORM\Column(name="observation", type="text", nullable=true)
     */
    private $observation;

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
     * Set action
     *
     * @param string $action
     *
     * @return EvenementActionProgres
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
     * Set observation
     *
     * @param string $observation
     *
     * @return EvenementActionProgres
     */
    public function setObservation($observation)
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * Get observation
     *
     * @return string
     */
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * Set evenement
     *
     * @param \Lpsa\AppBundle\Entity\Evenement $evenement
     *
     * @return EvenementActionProgres
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

    /**
     * Set responsableService
     *
     * @param \Lpsa\AppBundle\Entity\ResponsableService $responsableService
     *
     * @return EvenementActionProgres
     */
    public function setResponsableService(\Lpsa\AppBundle\Entity\ResponsableService $responsableService = null)
    {
        $this->responsableService = $responsableService;

        return $this;
    }

    /**
     * Get responsableService
     *
     * @return \Lpsa\AppBundle\Entity\ResponsableService
     */
    public function getResponsableService()
    {
        return $this->responsableService;
    }

    /**
     * Set evenementActionProgresStatus
     *
     * @param \Lpsa\AppBundle\Entity\EvenementActionProgresStatus $evenementActionProgresStatus
     *
     * @return EvenementActionProgres
     */
    public function setEvenementActionProgresStatus(\Lpsa\AppBundle\Entity\EvenementActionProgresStatus $evenementActionProgresStatus = null)
    {
        $this->evenementActionProgresStatus = $evenementActionProgresStatus;

        return $this;
    }

    /**
     * Get evenementActionProgresStatus
     *
     * @return \Lpsa\AppBundle\Entity\EvenementActionProgresStatus
     */
    public function getEvenementActionProgresStatus()
    {
        return $this->evenementActionProgresStatus;
    }

    /**
     * Set delai
     *
     * @param \DateTime $delai
     *
     * @return EvenementActionProgres
     */
    public function setDelai($delai)
    {
        $this->delai = $delai;

        return $this;
    }

    /**
     * Get delai
     *
     * @return \DateTime
     */
    public function getDelai()
    {
        return $this->delai;
    }

    /**
     * Set avancement
     *
     * @param integer $avancement
     *
     * @return EvenementActionProgres
     */
    public function setAvancement($avancement)
    {
        $this->avancement = $avancement;

        return $this;
    }

    /**
     * Get avancement
     *
     * @return integer
     */
    public function getAvancement()
    {
        return $this->avancement;
    }
}

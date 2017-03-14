<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * EvenementEnquete
 *
 * @ORM\Table(name="evenement_enquete")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\EvenementEnqueteRepository")
 */
class EvenementEnquete
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
     * @ORM\OneToOne(targetEntity="Lpsa\AppBundle\Entity\Evenement", inversedBy="evenementEnquete")
     * @ORM\JoinColumn(name="evenement_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $evenement;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;
    
    /**
     * @var text
     *
     * @ORM\Column(name="commentaire", type="text", nullable=true)
     */
    private $commentaire;
    
    /**
     * @var text
     *
     * @ORM\Column(name="causes_immediates", type="text", nullable=true)
     */
    private $causesImmediates;
    
    /**
     * @var text
     *
     * @ORM\Column(name="causes_fondamentales", type="text", nullable=true)
     */
    private $causesFondamentales;
    
    /**
     * @ORM\OneToMany(targetEntity="Lpsa\AppBundle\Entity\EvenementEnquetePj", mappedBy="evenementEnquete",cascade={"persist"})
     */
    private $evenementEnquetePJs;
    
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return EvenementEnquete
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return EvenementEnquete
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set causesImmediates
     *
     * @param string $causesImmediates
     *
     * @return EvenementEnquete
     */
    public function setCausesImmediates($causesImmediates)
    {
        $this->causesImmediates = $causesImmediates;

        return $this;
    }

    /**
     * Get causesImmediates
     *
     * @return string
     */
    public function getCausesImmediates()
    {
        return $this->causesImmediates;
    }

    /**
     * Set causesFondamentales
     *
     * @param string $causesFondamentales
     *
     * @return EvenementEnquete
     */
    public function setCausesFondamentales($causesFondamentales)
    {
        $this->causesFondamentales = $causesFondamentales;

        return $this;
    }

    /**
     * Get causesFondamentales
     *
     * @return string
     */
    public function getCausesFondamentales()
    {
        return $this->causesFondamentales;
    }

    /**
     * Set evenement
     *
     * @param \Lpsa\AppBundle\Entity\Evenement $evenement
     *
     * @return EvenementEnquete
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
     * Constructor
     */
    public function __construct()
    {
        $this->evenementEnquetePJs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add evenementEnquetePJ
     *
     * @param \Lpsa\AppBundle\Entity\EvenementEnquetePj $evenementEnquetePJ
     *
     * @return EvenementEnquete
     */
    public function addEvenementEnquetePJ(\Lpsa\AppBundle\Entity\EvenementEnquetePj $evenementEnquetePJ)
    {
        $evenementEnquetePJ->setEvenementEnquete($this);
        $this->evenementEnquetePJs[] = $evenementEnquetePJ;

        return $this;
    }

    /**
     * Remove evenementEnquetePJ
     *
     * @param \Lpsa\AppBundle\Entity\EvenementEnquetePj $evenementEnquetePJ
     */
    public function removeEvenementEnquetePJ(\Lpsa\AppBundle\Entity\EvenementEnquetePj $evenementEnquetePJ)
    {
        $this->evenementEnquetePJs->removeElement($evenementEnquetePJ);
    }

    /**
     * Get evenementEnquetePJs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvenementEnquetePJs()
    {
        return $this->evenementEnquetePJs;
    }
}

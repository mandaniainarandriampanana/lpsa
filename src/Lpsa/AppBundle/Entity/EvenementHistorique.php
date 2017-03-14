<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EvenementHistorique
 *
 * @ORM\Table(name="evenement_historique")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\EvenementHistoriqueRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class EvenementHistorique
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\UserBundle\Entity\User", inversedBy="evenementHitoriques")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;
    
    /**
     * @var Evenement
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Evenement", inversedBy="evenementHitoriques")
     * @ORM\JoinColumn(name="evenement_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $evenement;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_create", type="datetime")
     */
    private $dateCreate;
    
    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=255)
     */
    private $commentaire;  
    
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
     * Set user
     *
     * @param \Lpsa\UserBundle\Entity\User $user
     *
     * @return EvenementHistorique
     */
    public function setUser(\Lpsa\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Lpsa\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set evenement
     *
     * @param \Lpsa\AppBundle\Entity\Evenement $evenement
     *
     * @return EvenementHistorique
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
     * Set dateCreate
     *
     * @param \DateTime $dateCreate
     *
     * @return EvenementHistorique
     */
    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    /**
     * Get dateCreate
     *
     * @return \DateTime
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }
    
    /**
     * @ORM\PrePersist
     * 
     */
    public function setCreated()
    {
        $this->setDateCreate(new \DateTime('now'));
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return EvenementHistorique
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
}

<?php

namespace Lpsa\MailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MailHistory
 *
 * @ORM\Table(name="mail_history")
 * @ORM\Entity(repositoryClass="Lpsa\MailBundle\Repository\MailHistoryRepository")
 * @ORM\HasLifecycleCallbacks
 */
class MailHistory
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
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sendingDate", type="date")
     */
    private $sendingDate;

    /**
     * @var string
     *
     * @ORM\Column(name="mailFrom", type="string", length=255)
     */
    private $mailFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="mailTo", type="string", length=255)
     */
    private $mailTo;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="sent", type="boolean")
     */
    private $sent;
    
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;
    
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Evenement")
     * @ORM\JoinColumn(name="evenement_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $evenement;
    
    /**
     * constructor.
     *
     * initialize Boolean
     * initialize ArrayCollection
     */
    public function __construct()
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
        $this->sendingDate = new \DateTime();
        $this->sent = false;
    }
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
        $this->updated = new \DateTime();
        return $this;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return MailHistory
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return MailHistory
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set sendingDate
     *
     * @param \DateTime $sendingDate
     *
     * @return MailHistory
     */
    public function setSendingDate($sendingDate)
    {
        $this->sendingDate = $sendingDate;

        return $this;
    }

    /**
     * Get sendingDate
     *
     * @return \DateTime
     */
    public function getSendingDate()
    {
        return $this->sendingDate;
    }

    /**
     * Set mailFrom
     *
     * @param string $mailFrom
     *
     * @return MailHistory
     */
    public function setMailFrom($mailFrom)
    {
        $this->mailFrom = json_encode($mailFrom);

        return $this;
    }

    /**
     * Get mailFrom
     *
     * @return string
     */
    public function getMailFrom()
    {
        return json_decode($this->mailFrom, true);
    }

    /**
     * Set mailTo
     *
     * @param string $mailTo
     *
     * @return MailHistory
     */
    public function setMailTo($mailTo)
    {
        $this->mailTo = $mailTo;

        return $this;
    }

    /**
     * Get mailTo
     *
     * @return string
     */
    public function getMailTo()
    {
        return $this->mailTo;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return MailHistory
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return MailHistory
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set sent
     *
     * @param boolean $sent
     *
     * @return MailHistory
     */
    public function setSent($sent)
    {
        $this->sent = $sent;

        return $this;
    }

    /**
     * Get sent
     *
     * @return boolean
     */
    public function getSent()
    {
        return $this->sent;
    }

    /**
     * Set user
     *
     * @param \Lpsa\UserBundle\Entity\User $user
     *
     * @return MailHistory
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
     * @return MailHistory
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

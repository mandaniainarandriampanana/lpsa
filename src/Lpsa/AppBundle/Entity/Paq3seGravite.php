<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Paq3seGravite
 *
 * @ORM\Table(name="paq3se_gravite")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\Paq3seGraviteRepository")
 */
class Paq3seGravite
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
     * @var Gravite
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Gravite")
     * @ORM\JoinColumn(name="gravite_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $gravite;


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
     * Set gravite
     *
     * @param \Lpsa\AppBundle\Entity\Gravite $gravite
     *
     * @return Paq3seGravite
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

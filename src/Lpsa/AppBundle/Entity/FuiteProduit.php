<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * FuiteProduit
 *
 * @ORM\Table(name="fuite_produit")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\FuiteProduitRepository")
 */
class FuiteProduit
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
     * @ORM\Column(name="fuite_non_mesurable", type="integer", options={"default":0})
     */
    private $fuiteNonMesurable;

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
     * Set fuiteNonMesurable
     *
     * @param integer $fuiteNonMesurable
     *
     * @return FuiteProduit
     */
    public function setFuiteNonMesurable($fuiteNonMesurable)
    {
        $this->fuiteNonMesurable = $fuiteNonMesurable;

        return $this;
    }

    /**
     * Get fuiteNonMesurable
     *
     * @return integer
     */
    public function getFuiteNonMesurable()
    {
        return $this->fuiteNonMesurable;
    }

    /**
     * Set mois
     *
     * @param integer $mois
     *
     * @return FuiteProduit
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
     * @return FuiteProduit
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
     * @return FuiteProduit
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

<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PAQSSSE
 *
 * @ORM\Table(name="PAQSSSE")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\PAQSSSERepository")
 */
class PAQSSSE
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
     * @ORM\Column(name="nbreNonConformiteCloture", type="integer", options={"default":0})
     */
    private $nbreNonConformiteCloture;

    /**
     * @var int
     *
     * @ORM\Column(name="nbreNonConformiteNonEchue", type="integer", options={"default":0})
     */
    private $nbreNonConformiteNonEchue;

    /**
     * @var int
     *
     * @ORM\Column(name="nbreOVERDUE", type="integer", options={"default":0})
     */
    private $nbreOVERDUE;

    /**
     * @var string
     *
     * @ORM\Column(name="pourcentageOVERDUE", type="decimal", precision=5, scale=2, options={"default":0})
     */
    private $pourcentageOVERDUE;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mois
     *
     * @param integer $mois
     *
     * @return Visite
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
     * @return Visite
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
     * Set nbreNonConformiteCloture
     *
     * @param integer $nbreNonConformiteCloture
     *
     * @return PAQSSSE
     */
    public function setNbreNonConformiteCloture($nbreNonConformiteCloture)
    {
        $this->nbreNonConformiteCloture = $nbreNonConformiteCloture;

        return $this;
    }

    /**
     * Get nbreNonConformiteCloture
     *
     * @return integer
     */
    public function getNbreNonConformiteCloture()
    {
        return $this->nbreNonConformiteCloture;
    }

    /**
     * Set nbreNonConformiteNonEchue
     *
     * @param integer $nbreNonConformiteNonEchue
     *
     * @return PAQSSSE
     */
    public function setNbreNonConformiteNonEchue($nbreNonConformiteNonEchue)
    {
        $this->nbreNonConformiteNonEchue = $nbreNonConformiteNonEchue;

        return $this;
    }

    /**
     * Get nbreNonConformiteNonEchue
     *
     * @return integer
     */
    public function getNbreNonConformiteNonEchue()
    {
        return $this->nbreNonConformiteNonEchue;
    }

    /**
     * Set nbreOVERDUE
     *
     * @param integer $nbreOVERDUE
     *
     * @return PAQSSSE
     */
    public function setNbreOVERDUE($nbreOVERDUE)
    {
        $this->nbreOVERDUE = $nbreOVERDUE;

        return $this;
    }

    /**
     * Get nbreOVERDUE
     *
     * @return integer
     */
    public function getNbreOVERDUE()
    {
        return $this->nbreOVERDUE;
    }

    /**
     * Set pourcentageOVERDUE
     *
     * @param string $pourcentageOVERDUE
     *
     * @return PAQSSSE
     */
    public function setPourcentageOVERDUE($pourcentageOVERDUE)
    {
        $this->pourcentageOVERDUE = $pourcentageOVERDUE;

        return $this;
    }

    /**
     * Get pourcentageOVERDUE
     *
     * @return string
     */
    public function getPourcentageOVERDUE()
    {
        return $this->pourcentageOVERDUE;
    }
}

<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ObjectifLtirTrir
 *
 * @ORM\Table(name="objectif_ltir_trir")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\ObjectifLtirTrirRepository")
 */
class ObjectifLtirTrir
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
     * @var string
     *
     * @ORM\Column(name="trir", type="decimal", precision=5, scale=2)
     */
    private $trir;

    /**
     * @var string
     *
     * @ORM\Column(name="ltir", type="decimal", precision=5, scale=2)
     */
    private $ltir;

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
     * Set trir
     *
     * @param string $trir
     *
     * @return ObjectifLtirTrir
     */
    public function setTrir($trir)
    {
        $this->trir = $trir;
    
        return $this;
    }

    /**
     * Get trir
     *
     * @return string
     */
    public function getTrir()
    {
        return $this->trir;
    }

    /**
     * Set ltir
     *
     * @param string $ltir
     *
     * @return ObjectifLtirTrir
     */
    public function setLtir($ltir)
    {
        $this->ltir = $ltir;
    
        return $this;
    }

    /**
     * Get ltir
     *
     * @return string
     */
    public function getLtir()
    {
        return $this->ltir;
    }

    /**
     * Set mois
     *
     * @param integer $mois
     *
     * @return ObjectifLtirTrir
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
     * @return ObjectifLtirTrir
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
}

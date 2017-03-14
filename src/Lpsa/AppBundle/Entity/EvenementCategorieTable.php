<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EvenementCategorieTable
 *
 * @ORM\Table(name="evenement_categorie_table")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\EvenementCategorieTableRepository")
 */
class EvenementCategorieTable
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
     * @var EvenementCategorie
     *
     * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\EvenementCategorie", inversedBy="evenementCategorieTables")
     * @ORM\JoinColumn(name="evenement_categorie_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $evenementCategorie;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nom_table", type="string", length=255)
     */
    private $nomTable;
    
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
     * Set nomTable
     *
     * @param string $nomTable
     * @return EvenementCategorieTable
     */
    public function setNomTable($nomTable)
    {
        $this->nomTable = $nomTable;

        return $this;
    }

    /**
     * Get nomTable
     *
     * @return string 
     */
    public function getNomTable()
    {
        return $this->nomTable;
    }

    /**
     * Set evenementCategorie
     *
     * @param \Lpsa\AppBundle\Entity\EvenementCategorie $evenementCategorie
     * @return EvenementCategorieTable
     */
    public function setEvenementCategorie(\Lpsa\AppBundle\Entity\EvenementCategorie $evenementCategorie = null)
    {
        $this->evenementCategorie = $evenementCategorie;

        return $this;
    }

    /**
     * Get evenementCategorie
     *
     * @return \Lpsa\AppBundle\Entity\EvenementCategorie 
     */
    public function getEvenementCategorie()
    {
        return $this->evenementCategorie;
    }
}

<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lpsa\CoreBundle\Entity\FileInterface;

/**
 * ToolboxPj
 *
 * @ORM\Table(name="toolbox_pj")
 * @ORM\Entity(repositoryClass="Lpsa\AppBundle\Repository\ToolboxPjRepository")
 */
class ToolboxPj extends FileBase implements FileInterface
{       
    /**
    * @ORM\ManyToOne(targetEntity="Lpsa\AppBundle\Entity\Toolbox", inversedBy="toolboxPjs")
    * @ORM\JoinColumn(name="toolbox_id", referencedColumnName="id", onDelete="CASCADE")
    */
    private $toolbox;

    /**
     * Set toolbox
     *
     * @param \Lpsa\AppBundle\Entity\Toolbox $toolbox
     *
     * @return ToolboxPj
     */
    public function setToolbox(\Lpsa\AppBundle\Entity\Toolbox $toolbox = null)
    {
        $this->toolbox = $toolbox;

        return $this;
    }

    /**
     * Get toolbox
     *
     * @return \Lpsa\AppBundle\Entity\Toolbox
     */
    public function getToolbox()
    {
        return $this->toolbox;
    }

    public function getRootDir(){
        return 'toolbox/'.$this->getToolbox()->getId()."/";
    }
}

<?php

namespace Lpsa\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Filesystem\Filesystem;

/**
 * FileBase.
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks()
 */
class FileBase {
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    protected $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nom_originel", type="string", length=255)
     */
    protected $originalName;

    /**
     * @var integer
     *
     * @ORM\Column(name="taille", type="integer")
     */
    protected $size;
    
    protected $file;
    
    
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
     * Set name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set originalName
     *
     * @param string $originalName
     *
     * @return $this
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;

        return $this;
    }

    /**
     * Get originalName
     *
     * @return string
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * Set size
     *
     * @param integer $size
     *
     * @return $this
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    public function setFile($file){
        $this->file = $file;
    }
    
    public function getFile(){
        return $this->file;
    }
    
    public function getFullFilePath() {
        return null === $this->getName() ? null : $this->getUploadRootDir(). $this->getName();
    }    
    
 
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function uploadFile() {
        // the file property can be empty if the field is not required
        if (null === $this->file) {
            return;
        }
        $fileName = md5(uniqid()).'.'.$this->file->guessExtension();
        if(!$this->id){
            $this->file->move($this->getTmpUploadRootDir(), $fileName);
        } else {
            $this->file->move($this->getUploadRootDir(), $fileName);
        }
        $this->setOriginalName($this->file->getClientOriginalName());
        $this->setName($fileName);
        $this->setSize($this->file->getClientSize());
    }
    
    /**
     * @ORM\PreRemove()
     */
    public function removeFile() {
        $fs = new Filesystem();
        try {
            $fs->remove($this->getFullFilePath());
        } catch (IOExceptionInterface $e) {
            echo "An error occurred while removing file at ".$e->getPath();
        }
    }
    
    /**
     * @ORM\PostPersist()
     */
    public function moveFile()
    {
        if (null === $this->file) {
            return;
        }
        $fs = new Filesystem();
        try {
            $fs->copy($this->getTmpUploadRootDir() . $this->name, $this->getFullFilePath());
            $fs->remove($this->getTmpUploadRootDir() . $this->name);
        } catch (IOExceptionInterface $e) {
            echo "An error occurred while removing file at ".$e->getPath();
        }
    }
 
    public function getUploadRootDir() {
        // the absolute directory path where uploaded documents should be saved
        return $this->getTmpUploadRootDir().$this->getRootDir();
    }
 
    protected function getTmpUploadRootDir() {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__ . '/../../../../web/uploads/';
    }
}

<?php

namespace Lpsa\AppBundle\Form\Handler\Toolbox;

use Lpsa\AppBundle\Entity\Toolbox;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;

class ToolboxFormHandler {
    
    private $message = "";
    
    /**
     * @var AbstractToolboxFormHandlerStrategy
     */
    protected $toolboxFormHandlerStrategy;
    
    /**
     * @var AbstractToolboxFormHandlerStrategy
     */
    protected $newToolboxFormHandlerStrategy;
    
    /**
     * @var AbstractToolboxFormHandlerStrategy
     */
    protected $updateToolboxFormHandlerStrategy;

    /**
     *
     * @var ObjectManager 
     */
    protected $em;

    public function __construct(ObjectManager $em) {
        $this->em = $em;
    }
    
    public function setNewToolboxFormHandlerStrategy(AbstractToolboxFormHandlerStrategy $toolboxFormHandlerStrategy) {
        $this->newToolboxFormHandlerStrategy = $toolboxFormHandlerStrategy;
    }
    
    public function setUpdateToolboxFormHandlerStrategy(AbstractToolboxFormHandlerStrategy $toolboxFormHandlerStrategy) {
        $this->updateToolboxFormHandlerStrategy = $toolboxFormHandlerStrategy;
    }
    
    /**
     * Set handler for action edit or new
     * 
     * @param Toolbox $toolbox
     * @return Toolbox
     */
    public function processForm(Toolbox $toolbox = null){
        if (is_null($toolbox)){ 
            $toolbox = new Toolbox();
            $this->toolboxFormHandlerStrategy = $this->newToolboxFormHandlerStrategy;
        } else {
            $this->toolboxFormHandlerStrategy = $this->updateToolboxFormHandlerStrategy;
        }
        return $toolbox;
    }
    
    public function handleForm(FormInterface $form, Toolbox $toolbox, Request $request)
    {
        if (
            (null === $toolbox->getId() && $request->isMethod('POST'))
            || (null !== $toolbox->getId() && $request->isMethod('PUT'))
        ) { 
            $originalToolboxPjs = new ArrayCollection();
            foreach ($toolbox->getToolboxPjs() as $pj) {
                $originalToolboxPjs->add($pj);
            }

            $form->handleRequest($request);
 
            if (!$form->isValid()) {
                return false;
            }
            
            //prevent request mapping error for attachment even if js already prevent this
            $this->cleanForAttachmentError($toolbox);
            foreach ($originalToolboxPjs as $toolboxPj) {
                if (false === $toolbox->getToolboxPjs()->contains($toolboxPj)) {
                    $toolbox->getToolboxPjs()->removeElement($toolboxPj);                    
                    $this->em->remove($toolboxPj);
                }
            }

            foreach ($toolbox->getToolboxPjs() as $attachment) {
                $attachment->setToolbox($toolbox);
            }
            
            $this->message = $this->toolboxFormHandlerStrategy->handleForm($request, $toolbox);
 
            return true;
        }
        return false;
    }
    
    /**
     * Remove if file upload not found
     * @param Toolbox $toolbox
     */
    protected function cleanForAttachmentError(Toolbox $toolbox){
        foreach ($toolbox->getToolboxPjs() as $attachment) {
            if(($attachment->getId() === null) && (! $attachment->getFile() instanceof UploadedFile)){
                $toolbox->getToolboxPjs()->removeElement($attachment);
            }
        }
    }

    public function createForm(Toolbox $toolbox)
    {
        return $this->toolboxFormHandlerStrategy->createForm($toolbox);
    }
 
    public function createView()
    {
        return $this->toolboxFormHandlerStrategy->createView();
    }
    
    public function getMessage(){
        return $this->message;
    }
}

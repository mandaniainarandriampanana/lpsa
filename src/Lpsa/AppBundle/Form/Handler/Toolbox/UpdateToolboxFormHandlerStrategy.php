<?php

namespace Lpsa\AppBundle\Form\Handler\Toolbox;

use Lpsa\AppBundle\Entity\Toolbox;
use Lpsa\AppBundle\Form\Type\Toolbox\ToolboxType;
use Symfony\Component\HttpFoundation\Request;

class UpdateToolboxFormHandlerStrategy extends AbstractToolboxFormHandlerStrategy{
    
    public function createForm(Toolbox $toolbox)
    {
        $this->form = $this->formFactory->create($this->toolboxType, $toolbox, array(
            'action' => $this->router->generate('toolbox_edit',array('id' => $toolbox->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Toolbox $toolbox)
    {

        $this->toolboxManager->save($toolbox, false, true);

        return $this->translator->trans('toolbox.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

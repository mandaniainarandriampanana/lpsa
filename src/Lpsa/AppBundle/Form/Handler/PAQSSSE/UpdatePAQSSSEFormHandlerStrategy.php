<?php

namespace Lpsa\AppBundle\Form\Handler\PAQSSSE;

use Lpsa\AppBundle\Entity\PAQSSSE;
use Symfony\Component\HttpFoundation\Request;

class UpdatePAQSSSEFormHandlerStrategy extends AbstractPAQSSSEFormHandlerStrategy{
    
    public function createForm(PAQSSSE $PAQSSSE)
    {
        $this->form = $this->formFactory->create($this->PAQSSSEType, $PAQSSSE, array(
            'action' => $this->router->generate('PAQSSSE_edit',array('id' => $PAQSSSE->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, PAQSSSE $PAQSSSE)
    {

        $this->PAQSSSEManager->save($PAQSSSE, false, true);

        return $this->translator->trans('PAQSSSE.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

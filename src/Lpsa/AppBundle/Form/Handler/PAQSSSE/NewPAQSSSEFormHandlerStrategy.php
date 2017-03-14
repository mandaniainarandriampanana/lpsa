<?php

namespace Lpsa\AppBundle\Form\Handler\PAQSSSE;

use Lpsa\AppBundle\Entity\PAQSSSE;
use Symfony\Component\HttpFoundation\Request;

class NewPAQSSSEFormHandlerStrategy extends AbstractPAQSSSEFormHandlerStrategy{
    public function createForm(PAQSSSE $PAQSSSE)
    {
        $this->form = $this->formFactory->create($this->PAQSSSEType, $PAQSSSE, array(
            'action' => $this->router->generate('PAQSSSE_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, PAQSSSE $PAQSSSE)
    {
        $this->PAQSSSEManager->save($PAQSSSE, true, true);

        return $this->translator->trans('PAQSSSE.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

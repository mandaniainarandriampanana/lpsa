<?php

namespace Lpsa\AppBundle\Form\Handler\IndicateurTransport;

use Lpsa\AppBundle\Entity\IndicateurTransport;
use Symfony\Component\HttpFoundation\Request;

class UpdateIndicateurTransportFormHandlerStrategy extends AbstractIndicateurTransportFormHandlerStrategy{
    
    public function createForm(IndicateurTransport $indicateurTransport)
    {
        $this->form = $this->formFactory->create($this->indicateurTransportType, $indicateurTransport, array(
            'action' => $this->router->generate('indicateurTransport_edit',array('id' => $indicateurTransport->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, IndicateurTransport $indicateurTransport)
    {

        $this->indicateurTransportManager->save($indicateurTransport, false, true);

        return $this->translator->trans('indicateurTransport.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

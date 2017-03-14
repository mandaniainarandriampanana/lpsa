<?php

namespace Lpsa\AppBundle\Form\Handler\IndicateurTransport;

use Lpsa\AppBundle\Entity\IndicateurTransport;
use Symfony\Component\HttpFoundation\Request;

class NewIndicateurTransportFormHandlerStrategy extends AbstractIndicateurTransportFormHandlerStrategy{
    public function createForm(IndicateurTransport $indicateurTransport)
    {
        $this->form = $this->formFactory->create($this->indicateurTransportType, $indicateurTransport, array(
            'action' => $this->router->generate('indicateurTransport_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, IndicateurTransport $indicateurTransport)
    {
        $this->indicateurTransportManager->save($indicateurTransport, true, true);

        return $this->translator->trans('indicateurTransport.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

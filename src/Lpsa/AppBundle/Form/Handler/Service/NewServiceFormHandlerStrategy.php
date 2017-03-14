<?php

namespace Lpsa\AppBundle\Form\Handler\Service;

use Lpsa\AppBundle\Entity\Service;
use Lpsa\AppBundle\Form\Type\Service\ServiceType;
use Symfony\Component\HttpFoundation\Request;

class NewServiceFormHandlerStrategy extends AbstractServiceFormHandlerStrategy{
    public function createForm(Service $service)
    {
        $this->form = $this->formFactory->create(new ServiceType(), $service, array(
            'action' => $this->router->generate('service_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Service $service)
    {
        $this->serviceManager->save($service, true, true);

        return $this->translator->trans('service.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

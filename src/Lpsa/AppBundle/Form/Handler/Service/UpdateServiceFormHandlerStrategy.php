<?php

namespace Lpsa\AppBundle\Form\Handler\Service;

use Lpsa\AppBundle\Entity\Service;
use Lpsa\AppBundle\Form\Type\Service\ServiceType;
use Symfony\Component\HttpFoundation\Request;

class UpdateServiceFormHandlerStrategy extends AbstractServiceFormHandlerStrategy{
    
    public function createForm(Service $service)
    {
        $this->form = $this->formFactory->create(new ServiceType(), $service, array(
            'action' => $this->router->generate('service_edit',array('id' => $service->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Service $service)
    {

        $this->serviceManager->save($service, false, true);

        return $this->translator->trans('service.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

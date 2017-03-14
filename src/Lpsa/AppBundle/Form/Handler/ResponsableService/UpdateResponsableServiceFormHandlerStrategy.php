<?php

namespace Lpsa\AppBundle\Form\Handler\ResponsableService;

use Lpsa\AppBundle\Entity\ResponsableService;
use Lpsa\AppBundle\Form\Type\ResponsableService\ResponsableServiceType;
use Symfony\Component\HttpFoundation\Request;

class UpdateResponsableServiceFormHandlerStrategy extends AbstractResponsableServiceFormHandlerStrategy{
    
    public function createForm(ResponsableService $responsableService)
    {
        $this->form = $this->formFactory->create(new ResponsableServiceType(), $responsableService, array(
            'action' => $this->router->generate('admin_responsableservice_edit',array('id' => $responsableService->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, ResponsableService $responsableService)
    {

        $this->responsableServiceManager->save($responsableService, false, true);

        return $this->translator->trans('responsableservice.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

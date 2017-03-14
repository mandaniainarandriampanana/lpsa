<?php

namespace Lpsa\AppBundle\Form\Handler\ObjectifKpihse;

use Lpsa\AppBundle\Entity\ObjectifKpihse;
use Symfony\Component\HttpFoundation\Request;

class UpdateObjectifKpihseFormHandlerStrategy extends AbstractObjectifKpihseFormHandlerStrategy{
    
    public function createForm(ObjectifKpihse $objectifKpihse)
    {
        $this->form = $this->formFactory->create($this->objectifKpihseType, $objectifKpihse, array(
            'action' => $this->router->generate('objectifKpihse_edit',array('id' => $objectifKpihse->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, ObjectifKpihse $objectifKpihse)
    {

        $this->objectifKpihseManager->save($objectifKpihse, false, true);

        return $this->translator->trans('objectifKpihse.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

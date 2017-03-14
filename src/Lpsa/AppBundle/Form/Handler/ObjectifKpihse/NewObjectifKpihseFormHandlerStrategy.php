<?php

namespace Lpsa\AppBundle\Form\Handler\ObjectifKpihse;

use Lpsa\AppBundle\Entity\ObjectifKpihse;
use Symfony\Component\HttpFoundation\Request;

class NewObjectifKpihseFormHandlerStrategy extends AbstractObjectifKpihseFormHandlerStrategy{
    public function createForm(ObjectifKpihse $objectifKpihse)
    {
        $this->form = $this->formFactory->create($this->objectifKpihseType, $objectifKpihse, array(
            'action' => $this->router->generate('objectifKpihse_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, ObjectifKpihse $objectifKpihse)
    {
        $this->objectifKpihseManager->save($objectifKpihse, true, true);

        return $this->translator->trans('objectifKpihse.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

<?php

namespace Lpsa\AppBundle\Form\Handler\ObjectifDepot;

use Lpsa\AppBundle\Entity\ObjectifDepot;
use Lpsa\AppBundle\Form\Type\ObjectifDepot\ObjectifDepotType;
use Symfony\Component\HttpFoundation\Request;

class NewObjectifDepotFormHandlerStrategy extends AbstractObjectifDepotFormHandlerStrategy{
    public function createForm(ObjectifDepot $objectifdepot)
    {
        $this->form = $this->formFactory->create(new ObjectifDepotType(), $objectifdepot, array(
            'action' => $this->router->generate('objectifdepot_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, ObjectifDepot $objectifdepot)
    {
        $this->objectifdepotManager->save($objectifdepot, true, true);

        return $this->translator->trans('objectifdepot.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

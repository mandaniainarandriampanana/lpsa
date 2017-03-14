<?php

namespace Lpsa\AppBundle\Form\Handler\ObjectifDepot;

use Lpsa\AppBundle\Entity\ObjectifDepot;
use Lpsa\AppBundle\Form\Type\ObjectifDepot\ObjectifDepotType;
use Symfony\Component\HttpFoundation\Request;

class UpdateObjectifDepotFormHandlerStrategy extends AbstractObjectifDepotFormHandlerStrategy{
    
    public function createForm(ObjectifDepot $objectifdepot)
    {
        $this->form = $this->formFactory->create(new ObjectifDepotType(), $objectifdepot, array(
            'action' => $this->router->generate('objectifdepot_edit',array('id' => $objectifdepot->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, ObjectifDepot $objectifdepot)
    {

        $this->objectifdepotManager->save($objectifdepot, false, true);

        return $this->translator->trans('objectifdepot.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

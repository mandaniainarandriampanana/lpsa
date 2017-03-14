<?php

namespace Lpsa\AppBundle\Form\Handler\ObjectifLtirTrir;

use Lpsa\AppBundle\Entity\ObjectifLtirTrir;
use Symfony\Component\HttpFoundation\Request;

class UpdateObjectifLtirTrirFormHandlerStrategy extends AbstractObjectifLtirTrirFormHandlerStrategy{
    
    public function createForm(ObjectifLtirTrir $objectifLtirTrir)
    {
        $this->form = $this->formFactory->create($this->objectifLtirTrirType, $objectifLtirTrir, array(
            'action' => $this->router->generate('objectifltirtrir_edit',array('id' => $objectifLtirTrir->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, ObjectifLtirTrir $objectifLtirTrir)
    {

        $this->objectifLtirTrirManager->save($objectifLtirTrir, false, true);

        return $this->translator->trans('objectifltirtrir.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

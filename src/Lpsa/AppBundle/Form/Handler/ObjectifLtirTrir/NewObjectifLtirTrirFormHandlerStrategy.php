<?php

namespace Lpsa\AppBundle\Form\Handler\ObjectifLtirTrir;

use Lpsa\AppBundle\Entity\ObjectifLtirTrir;
use Symfony\Component\HttpFoundation\Request;

class NewObjectifLtirTrirFormHandlerStrategy extends AbstractObjectifLtirTrirFormHandlerStrategy{
    public function createForm(ObjectifLtirTrir $objectifLtirTrir)
    {
        $this->form = $this->formFactory->create($this->objectifLtirTrirType, $objectifLtirTrir, array(
            'action' => $this->router->generate('objectifltirtrir_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, ObjectifLtirTrir $objectifLtirTrir)
    {
        $this->objectifLtirTrirManager->save($objectifLtirTrir, true, true);

        return $this->translator->trans('objectifltirtrir.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

<?php

namespace Lpsa\AppBundle\Form\Handler\EvenementStatut;

use Lpsa\AppBundle\Entity\EvenementStatut;
use Lpsa\AppBundle\Form\Type\EvenementStatut\EvenementStatutType;
use Symfony\Component\HttpFoundation\Request;

class UpdateEvenementStatutFormHandlerStrategy extends AbstractEvenementStatutFormHandlerStrategy{
    
    public function createForm(EvenementStatut $evenementStatut)
    {
        $this->form = $this->formFactory->create(new EvenementStatutType(), $evenementStatut, array(
            'action' => $this->router->generate('evenementstatut_edit',array('id' => $evenementStatut->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, EvenementStatut $evenementStatut)
    {

        $this->evenementStatutManager->save($evenementStatut, false, true);

        return $this->translator->trans('evenementstatut.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

<?php

namespace Lpsa\AppBundle\Form\Handler\EvenementStatut;

use Lpsa\AppBundle\Entity\EvenementStatut;
use Lpsa\AppBundle\Form\Type\EvenementStatut\EvenementStatutType;
use Symfony\Component\HttpFoundation\Request;

class NewEvenementStatutFormHandlerStrategy extends AbstractEvenementStatutFormHandlerStrategy{
    public function createForm(EvenementStatut $evenementStatut)
    {
        $this->form = $this->formFactory->create(new EvenementStatutType(), $evenementStatut, array(
            'action' => $this->router->generate('evenementstatut_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, EvenementStatut $evenementStatut)
    {
        $this->evenementStatutManager->save($evenementStatut, true, true);

        return $this->translator->trans('evenementstatut.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

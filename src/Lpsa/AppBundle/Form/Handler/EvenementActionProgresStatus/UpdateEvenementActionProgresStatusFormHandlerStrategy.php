<?php

namespace Lpsa\AppBundle\Form\Handler\EvenementActionProgresStatus;

use Lpsa\AppBundle\Entity\EvenementActionProgresStatus;
use Lpsa\AppBundle\Form\Type\EvenementActionProgresStatus\EvenementActionProgresStatusType;
use Symfony\Component\HttpFoundation\Request;

class UpdateEvenementActionProgresStatusFormHandlerStrategy extends AbstractEvenementActionProgresStatusFormHandlerStrategy{
    
    public function createForm(EvenementActionProgresStatus $evenementactionprogresstatus)
    {
        $this->form = $this->formFactory->create(new EvenementActionProgresStatusType(), $evenementactionprogresstatus, array(
            'action' => $this->router->generate('evenementactionprogresstatus_edit',array('id' => $evenementactionprogresstatus->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, EvenementActionProgresStatus $evenementactionprogresstatus)
    {

        $this->evenementactionprogresstatusManager->save($evenementactionprogresstatus, false, true);

        return $this->translator->trans('evenementactionprogresstatus.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

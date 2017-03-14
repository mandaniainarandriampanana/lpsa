<?php

namespace Lpsa\AppBundle\Form\Handler\EvenementActionProgresStatus;

use Lpsa\AppBundle\Entity\EvenementActionProgresStatus;
use Lpsa\AppBundle\Form\Type\EvenementActionProgresStatus\EvenementActionProgresStatusType;
use Symfony\Component\HttpFoundation\Request;

class NewEvenementActionProgresStatusFormHandlerStrategy extends AbstractEvenementActionProgresStatusFormHandlerStrategy{
    public function createForm(EvenementActionProgresStatus $evenementactionprogresstatus)
    {
        $this->form = $this->formFactory->create(new EvenementActionProgresStatusType(), $evenementactionprogresstatus, array(
            'action' => $this->router->generate('evenementactionprogresstatus_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, EvenementActionProgresStatus $evenementactionprogresstatus, ArrayCollection $originalHashTags = null)
    {
        $this->evenementactionprogresstatusManager->save($evenementactionprogresstatus, true, true);

        return $this->translator->trans('evenementactionprogresstatus.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

<?php

namespace Lpsa\AppBundle\Form\Handler\HeureTravail;

use Lpsa\AppBundle\Entity\HeureTravail;
use Symfony\Component\HttpFoundation\Request;

class UpdateHeureTravailFormHandlerStrategy extends AbstractHeureTravailFormHandlerStrategy{
    
    public function createForm(HeureTravail $heureTravail)
    {
        $this->form = $this->formFactory->create($this->heureTravailType, $heureTravail, array(
            'action' => $this->router->generate('heuretravail_edit',array('id' => $heureTravail->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, HeureTravail $heureTravail)
    {

        $this->heureTravailManager->save($heureTravail, false, true);

        return $this->translator->trans('heuretravail.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

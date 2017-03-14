<?php

namespace Lpsa\AppBundle\Form\Handler\HeureTravail;

use Lpsa\AppBundle\Entity\HeureTravail;
use Symfony\Component\HttpFoundation\Request;

class NewHeureTravailFormHandlerStrategy extends AbstractHeureTravailFormHandlerStrategy{
    public function createForm(HeureTravail $heureTravail)
    {
        $this->form = $this->formFactory->create($this->heureTravailType, $heureTravail, array(
            'action' => $this->router->generate('heuretravail_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, HeureTravail $heureTravail)
    {
        $this->heureTravailManager->save($heureTravail, true, true);

        return $this->translator->trans('heuretravail.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

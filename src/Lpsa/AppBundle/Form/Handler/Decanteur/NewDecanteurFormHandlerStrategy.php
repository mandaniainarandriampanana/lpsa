<?php

namespace Lpsa\AppBundle\Form\Handler\Decanteur;

use Lpsa\AppBundle\Entity\Decanteur;
use Symfony\Component\HttpFoundation\Request;

class NewDecanteurFormHandlerStrategy extends AbstractDecanteurFormHandlerStrategy{
    public function createForm(Decanteur $decanteur)
    {
        $this->form = $this->formFactory->create($this->decanteurType, $decanteur, array(
            'action' => $this->router->generate('decanteur_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Decanteur $decanteur)
    {
        $this->decanteurManager->save($decanteur, true, true);

        return $this->translator->trans('decanteur.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

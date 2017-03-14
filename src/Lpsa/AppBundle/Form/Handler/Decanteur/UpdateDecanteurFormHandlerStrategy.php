<?php

namespace Lpsa\AppBundle\Form\Handler\Decanteur;

use Lpsa\AppBundle\Entity\Decanteur;
use Symfony\Component\HttpFoundation\Request;

class UpdateDecanteurFormHandlerStrategy extends AbstractDecanteurFormHandlerStrategy{
    
    public function createForm(Decanteur $decanteur)
    {
        $this->form = $this->formFactory->create($this->decanteurType, $decanteur, array(
            'action' => $this->router->generate('decanteur_edit',array('id' => $decanteur->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Decanteur $decanteur)
    {

        $this->decanteurManager->save($decanteur, false, true);

        return $this->translator->trans('decanteur.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

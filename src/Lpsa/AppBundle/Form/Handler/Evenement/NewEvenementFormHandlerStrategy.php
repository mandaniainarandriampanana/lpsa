<?php

namespace Lpsa\AppBundle\Form\Handler\Evenement;

use Lpsa\AppBundle\Entity\Evenement;
use Symfony\Component\HttpFoundation\Request;

class NewEvenementFormHandlerStrategy extends AbstractEvenementFormHandlerStrategy{
    public function createForm(Evenement $evenement,$route = 'admin_evenement_new',$hasAccess = true)
    {
        $this->form = $this->formFactory->create($this->evenementType, $evenement, array(
            'action' => $this->router->generate($route),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Evenement $evenement)
    {
        //set current user logged
        $evenement->setUser($this->getUser());
        $this->evenementManager->save($evenement, true, true);

        return $this->translator->trans('evenement.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

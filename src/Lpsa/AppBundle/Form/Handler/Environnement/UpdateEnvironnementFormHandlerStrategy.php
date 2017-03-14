<?php

namespace Lpsa\AppBundle\Form\Handler\Environnement;

use Lpsa\AppBundle\Entity\Environnement;
use Lpsa\AppBundle\Form\Type\Environnement\EnvironnementType;
use Symfony\Component\HttpFoundation\Request;

class UpdateEnvironnementFormHandlerStrategy extends AbstractEnvironnementFormHandlerStrategy{
    
    public function createForm(Environnement $environnement)
    {
        $this->form = $this->formFactory->create(new EnvironnementType(), $environnement, array(
            'action' => $this->router->generate('environnement_edit',array('id' => $environnement->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Environnement $environnement)
    {

        $this->environnementManager->save($environnement, false, true);

        return $this->translator->trans('environnement.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

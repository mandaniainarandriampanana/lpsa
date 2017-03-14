<?php

namespace Lpsa\AppBundle\Form\Handler\Environnement;

use Lpsa\AppBundle\Entity\Environnement;
use Lpsa\AppBundle\Form\Type\Environnement\EnvironnementType;
use Symfony\Component\HttpFoundation\Request;

class NewEnvironnementFormHandlerStrategy extends AbstractEnvironnementFormHandlerStrategy{
    public function createForm(Environnement $environnement)
    {
        $this->form = $this->formFactory->create(new EnvironnementType(), $environnement, array(
            'action' => $this->router->generate('environnement_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Environnement $environnement)
    {
        $this->environnementManager->save($environnement, true, true);

        return $this->translator->trans('environnement.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

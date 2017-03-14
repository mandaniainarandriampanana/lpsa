<?php

namespace Lpsa\AppBundle\Form\Handler\FuiteProduit;

use Lpsa\AppBundle\Entity\FuiteProduit;
use Lpsa\AppBundle\Form\Type\FuiteProduit\FuiteProduitType;
use Symfony\Component\HttpFoundation\Request;

class UpdateFuiteProduitFormHandlerStrategy extends AbstractFuiteProduitFormHandlerStrategy{
    
    public function createForm(FuiteProduit $fuiteProduit)
    {
        $this->form = $this->formFactory->create($this->fuiteProduitType, $fuiteProduit, array(
            'action' => $this->router->generate('admin_fuiteProduit_edit',array('id' => $fuiteProduit->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, FuiteProduit $fuiteProduit)
    {

        $this->fuiteProduitManager->save($fuiteProduit, false, true);

        return $this->translator->trans('fuiteProduit.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

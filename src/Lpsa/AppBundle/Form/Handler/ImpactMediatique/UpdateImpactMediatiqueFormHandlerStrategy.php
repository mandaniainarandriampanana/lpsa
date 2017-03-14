<?php

namespace Lpsa\AppBundle\Form\Handler\ImpactMediatique;

use Lpsa\AppBundle\Entity\ImpactMediatique;
use Lpsa\AppBundle\Form\Type\ImpactMediatique\ImpactMediatiqueType;
use Symfony\Component\HttpFoundation\Request;

class UpdateImpactMediatiqueFormHandlerStrategy extends AbstractImpactMediatiqueFormHandlerStrategy{
    
    public function createForm(ImpactMediatique $impactmediatique)
    {
        $this->form = $this->formFactory->create(new ImpactMediatiqueType(), $impactmediatique, array(
            'action' => $this->router->generate('impactmediatique_edit',array('id' => $impactmediatique->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, ImpactMediatique $impactmediatique)
    {

        $this->impactmediatiqueManager->save($impactmediatique, false, true);

        return $this->translator->trans('impactmediatique.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

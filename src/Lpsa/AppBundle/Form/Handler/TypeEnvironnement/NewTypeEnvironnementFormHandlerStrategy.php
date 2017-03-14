<?php

namespace Lpsa\AppBundle\Form\Handler\TypeEnvironnement;

use Lpsa\AppBundle\Entity\TypeEnvironnement;
use Lpsa\AppBundle\Form\Type\TypeEnvironnement\TypeEnvironnementType;
use Symfony\Component\HttpFoundation\Request;

class NewTypeEnvironnementFormHandlerStrategy extends AbstractTypeEnvironnementFormHandlerStrategy{
    public function createForm(TypeEnvironnement $typeenvironnement)
    {
        $this->form = $this->formFactory->create(new TypeEnvironnementType(), $typeenvironnement, array(
            'action' => $this->router->generate('typeenvironnement_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, TypeEnvironnement $typeenvironnement, ArrayCollection $originalHashTags = null)
    {
        $this->typeenvironnementManager->save($typeenvironnement, true, true);

        return $this->translator->trans('typeenvironnement.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

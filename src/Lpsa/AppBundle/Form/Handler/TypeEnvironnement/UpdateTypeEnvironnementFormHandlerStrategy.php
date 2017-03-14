<?php

namespace Lpsa\AppBundle\Form\Handler\TypeEnvironnement;

use Lpsa\AppBundle\Entity\TypeEnvironnement;
use Lpsa\AppBundle\Form\Type\TypeEnvironnement\TypeEnvironnementType;
use Symfony\Component\HttpFoundation\Request;

class UpdateTypeEnvironnementFormHandlerStrategy extends AbstractTypeEnvironnementFormHandlerStrategy{
    
    public function createForm(TypeEnvironnement $typeenvironnement)
    {
        $this->form = $this->formFactory->create(new TypeEnvironnementType(), $typeenvironnement, array(
            'action' => $this->router->generate('typeenvironnement_edit',array('id' => $typeenvironnement->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, TypeEnvironnement $typeenvironnement)
    {

        $this->typeenvironnementManager->save($typeenvironnement, false, true);

        return $this->translator->trans('typeenvironnement.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

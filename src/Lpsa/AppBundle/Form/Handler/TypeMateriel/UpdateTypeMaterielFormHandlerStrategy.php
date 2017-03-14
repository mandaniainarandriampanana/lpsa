<?php

namespace Lpsa\AppBundle\Form\Handler\TypeMateriel;

use Lpsa\AppBundle\Entity\TypeMateriel;
use Lpsa\AppBundle\Form\Type\TypeMateriel\TypeMaterielType;
use Symfony\Component\HttpFoundation\Request;

class UpdateTypeMaterielFormHandlerStrategy extends AbstractTypeMaterielFormHandlerStrategy{
    
    public function createForm(TypeMateriel $typemateriel)
    {
        $this->form = $this->formFactory->create(new TypeMaterielType(), $typemateriel, array(
            'action' => $this->router->generate('typemateriel_edit',array('id' => $typemateriel->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, TypeMateriel $typemateriel)
    {

        $this->typematerielManager->save($typemateriel, false, true);

        return $this->translator->trans('typemateriel.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

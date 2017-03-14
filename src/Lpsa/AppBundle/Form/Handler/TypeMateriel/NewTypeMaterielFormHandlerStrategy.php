<?php

namespace Lpsa\AppBundle\Form\Handler\TypeMateriel;

use Lpsa\AppBundle\Entity\TypeMateriel;
use Lpsa\AppBundle\Form\Type\TypeMateriel\TypeMaterielType;
use Symfony\Component\HttpFoundation\Request;

class NewTypeMaterielFormHandlerStrategy extends AbstractTypeMaterielFormHandlerStrategy{
    public function createForm(TypeMateriel $typemateriel)
    {
        $this->form = $this->formFactory->create(new TypeMaterielType(), $typemateriel, array(
            'action' => $this->router->generate('typemateriel_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, TypeMateriel $typemateriel, ArrayCollection $originalHashTags = null)
    {
        $this->typematerielManager->save($typemateriel, true, true);

        return $this->translator->trans('typemateriel.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

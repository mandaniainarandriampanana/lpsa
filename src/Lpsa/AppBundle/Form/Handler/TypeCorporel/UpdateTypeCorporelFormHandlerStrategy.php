<?php

namespace Lpsa\AppBundle\Form\Handler\TypeCorporel;

use Lpsa\AppBundle\Entity\TypeCorporel;
use Lpsa\AppBundle\Form\Type\TypeCorporel\TypeCorporelType;
use Symfony\Component\HttpFoundation\Request;

class UpdateTypeCorporelFormHandlerStrategy extends AbstractTypeCorporelFormHandlerStrategy{
    
    public function createForm(TypeCorporel $typecorporel)
    {
        $this->form = $this->formFactory->create(new TypeCorporelType(), $typecorporel, array(
            'action' => $this->router->generate('typecorporel_edit',array('id' => $typecorporel->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, TypeCorporel $typecorporel)
    {

        $this->typecorporelManager->save($typecorporel, false, true);

        return $this->translator->trans('typecorporel.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

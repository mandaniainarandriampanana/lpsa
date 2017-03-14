<?php

namespace Lpsa\AppBundle\Form\Handler\TypeCorporel;

use Lpsa\AppBundle\Entity\TypeCorporel;
use Lpsa\AppBundle\Form\Type\TypeCorporel\TypeCorporelType;
use Symfony\Component\HttpFoundation\Request;

class NewTypeCorporelFormHandlerStrategy extends AbstractTypeCorporelFormHandlerStrategy{
    public function createForm(TypeCorporel $typecorporel)
    {
        $this->form = $this->formFactory->create(new TypeCorporelType(), $typecorporel, array(
            'action' => $this->router->generate('typecorporel_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, TypeCorporel $typecorporel, ArrayCollection $originalHashTags = null)
    {
        $this->typecorporelManager->save($typecorporel, true, true);

        return $this->translator->trans('typecorporel.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

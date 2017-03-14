<?php

namespace Lpsa\AppBundle\Form\Handler\Dysfonctionnement;

use Lpsa\AppBundle\Entity\Dysfonctionnement;
use Lpsa\AppBundle\Form\Type\Dysfonctionnement\DysfonctionnementType;
use Symfony\Component\HttpFoundation\Request;

class NewDysfonctionnementFormHandlerStrategy extends AbstractDysfonctionnementFormHandlerStrategy{
    public function createForm(Dysfonctionnement $dysfonctionnement)
    {
        $this->form = $this->formFactory->create(new DysfonctionnementType(), $dysfonctionnement, array(
            'action' => $this->router->generate('admin_dysfonctionnement_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Dysfonctionnement $dysfonctionnement)
    {
        $this->dysfonctionnementManager->save($dysfonctionnement, true, true);

        return $this->translator->trans('dysfonctionnement.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

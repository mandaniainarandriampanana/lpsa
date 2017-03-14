<?php

namespace Lpsa\AppBundle\Form\Handler\Fonction;

use Lpsa\AppBundle\Entity\Fonction;
use Lpsa\AppBundle\Form\Type\Fonction\FonctionType;
use Symfony\Component\HttpFoundation\Request;

class UpdateFonctionFormHandlerStrategy extends AbstractFonctionFormHandlerStrategy{
    
    public function createForm(Fonction $fonction)
    {
        $this->form = $this->formFactory->create(new FonctionType(), $fonction, array(
            'action' => $this->router->generate('admin_fonction_edit',array('id' => $fonction->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Fonction $fonction)
    {

        $this->fonctionManager->save($fonction, false, true);

        return $this->translator->trans('fonction.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

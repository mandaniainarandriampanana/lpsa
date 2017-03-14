<?php

namespace Lpsa\AppBundle\Form\Handler\Fonction;

use Lpsa\AppBundle\Entity\Fonction;
use Lpsa\AppBundle\Form\Type\Fonction\FonctionType;
use Symfony\Component\HttpFoundation\Request;

class NewFonctionFormHandlerStrategy extends AbstractFonctionFormHandlerStrategy{
    public function createForm(Fonction $fonction)
    {
        $this->form = $this->formFactory->create(new FonctionType(), $fonction, array(
            'action' => $this->router->generate('admin_fonction_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Fonction $fonction)
    {
        $this->fonctionManager->save($fonction, true, true);

        return $this->translator->trans('fonction.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

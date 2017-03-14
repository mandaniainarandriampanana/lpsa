<?php

namespace Lpsa\AppBundle\Form\Handler\EvenementCategorie;

use Lpsa\AppBundle\Entity\EvenementCategorie;
use Lpsa\AppBundle\Form\Type\EvenementCategorie\EvenementCategorieType;
use Symfony\Component\HttpFoundation\Request;

class UpdateEvenementCategorieFormHandlerStrategy extends AbstractEvenementCategorieFormHandlerStrategy{
    
    public function createForm(EvenementCategorie $evenementcategorie)
    {
        $this->form = $this->formFactory->create(new EvenementCategorieType(), $evenementcategorie, array(
            'action' => $this->router->generate('evenementcategorie_edit',array('id' => $evenementcategorie->getId())),
            'method' => 'PUT'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, EvenementCategorie $evenementcategorie)
    {

        $this->evenementcategorieManager->save($evenementcategorie, false, true);

        return $this->translator->trans('evenementcategorie.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

<?php

namespace Lpsa\AppBundle\Form\Handler\EvenementCategorie;

use Lpsa\AppBundle\Entity\EvenementCategorie;
use Lpsa\AppBundle\Form\Type\EvenementCategorie\EvenementCategorieType;
use Symfony\Component\HttpFoundation\Request;

class NewEvenementCategorieFormHandlerStrategy extends AbstractEvenementCategorieFormHandlerStrategy{
    public function createForm(EvenementCategorie $evenementcategorie)
    {
        $this->form = $this->formFactory->create(new EvenementCategorieType(), $evenementcategorie, array(
            'action' => $this->router->generate('evenementcategorie_new'),
            'method' => 'POST'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, EvenementCategorie $evenementcategorie, ArrayCollection $originalHashTags = null)
    {
        $this->evenementcategorieManager->save($evenementcategorie, true, true);

        return $this->translator->trans('evenementcategorie.flashes.new.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

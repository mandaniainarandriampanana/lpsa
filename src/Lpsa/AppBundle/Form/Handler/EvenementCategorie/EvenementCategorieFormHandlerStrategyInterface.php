<?php

namespace Lpsa\AppBundle\Form\Handler\EvenementCategorie;

use Lpsa\AppBundle\Entity\EvenementCategorie;
use Symfony\Component\HttpFoundation\Request;

interface EvenementCategorieFormHandlerStrategyInterface {
    public function handleForm(Request $request, EvenementCategorie $evenementcategorie);
    public function createForm(EvenementCategorie $evenementcategorie);
    public function createView();
}

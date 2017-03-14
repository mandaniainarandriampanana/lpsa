<?php

namespace Lpsa\AppBundle\Form\Handler\Fonction;

use Lpsa\AppBundle\Entity\Fonction;
use Symfony\Component\HttpFoundation\Request;

interface FonctionFormHandlerStrategyInterface {
    public function handleForm(Request $request, Fonction $fonction);
    public function createForm(Fonction $fonction);
    public function createView();
}

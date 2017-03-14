<?php

namespace Lpsa\AppBundle\Form\Handler\EvenementStatut;

use Lpsa\AppBundle\Entity\EvenementStatut;
use Symfony\Component\HttpFoundation\Request;

interface EvenementStatutFormHandlerStrategyInterface {
    public function handleForm(Request $request, EvenementStatut $evenementStatut);
    public function createForm(EvenementStatut $evenementStatut);
    public function createView();
}

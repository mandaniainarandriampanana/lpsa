<?php

namespace Lpsa\AppBundle\Form\Handler\Evenement;

use Lpsa\AppBundle\Entity\Evenement;
use Symfony\Component\HttpFoundation\Request;

interface EvenementFormHandlerStrategyInterface {
    public function handleForm(Request $request, Evenement $evenement);
    public function createForm(Evenement $evenement);
    public function createView();
}

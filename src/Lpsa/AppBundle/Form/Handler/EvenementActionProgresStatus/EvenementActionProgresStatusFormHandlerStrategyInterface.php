<?php

namespace Lpsa\AppBundle\Form\Handler\EvenementActionProgresStatus;

use Lpsa\AppBundle\Entity\EvenementActionProgresStatus;
use Symfony\Component\HttpFoundation\Request;

interface EvenementActionProgresStatusFormHandlerStrategyInterface {
    public function handleForm(Request $request, EvenementActionProgresStatus $evenementactionprogresstatus);
    public function createForm(EvenementActionProgresStatus $evenementactionprogresstatus);
    public function createView();
}

<?php

namespace Lpsa\AppBundle\Form\Handler\Decanteur;

use Lpsa\AppBundle\Entity\Decanteur;
use Symfony\Component\HttpFoundation\Request;

interface DecanteurFormHandlerStrategyInterface {
    public function handleForm(Request $request, Decanteur $decanteur);
    public function createForm(Decanteur $decanteur);
    public function createView();
}

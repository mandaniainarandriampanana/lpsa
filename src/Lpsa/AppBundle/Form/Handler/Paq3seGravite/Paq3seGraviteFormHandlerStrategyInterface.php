<?php

namespace Lpsa\AppBundle\Form\Handler\Paq3seGravite;

use Lpsa\AppBundle\Entity\Paq3seGravite;
use Symfony\Component\HttpFoundation\Request;

interface Paq3seGraviteFormHandlerStrategyInterface {
    public function handleForm(Request $request, Paq3seGravite $paq3seGravite);
    public function createForm(Paq3seGravite $paq3seGravite);
    public function createView();
}

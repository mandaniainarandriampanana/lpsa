<?php

namespace Lpsa\AppBundle\Form\Handler\FuiteProduit;

use Lpsa\AppBundle\Entity\FuiteProduit;
use Symfony\Component\HttpFoundation\Request;

interface FuiteProduitFormHandlerStrategyInterface {
    public function handleForm(Request $request, FuiteProduit $fuiteProduit);
    public function createForm(FuiteProduit $fuiteProduit);
    public function createView();
}

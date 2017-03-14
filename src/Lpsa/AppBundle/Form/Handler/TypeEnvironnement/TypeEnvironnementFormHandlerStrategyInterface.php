<?php

namespace Lpsa\AppBundle\Form\Handler\TypeEnvironnement;

use Lpsa\AppBundle\Entity\TypeEnvironnement;
use Symfony\Component\HttpFoundation\Request;

interface TypeEnvironnementFormHandlerStrategyInterface {
    public function handleForm(Request $request, TypeEnvironnement $typeenvironnement);
    public function createForm(TypeEnvironnement $typeenvironnement);
    public function createView();
}

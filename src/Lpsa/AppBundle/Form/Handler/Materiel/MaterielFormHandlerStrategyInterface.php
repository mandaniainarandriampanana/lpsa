<?php

namespace Lpsa\AppBundle\Form\Handler\Materiel;

use Lpsa\AppBundle\Entity\Materiel;
use Symfony\Component\HttpFoundation\Request;

interface MaterielFormHandlerStrategyInterface {
    public function handleForm(Request $request, Materiel $materiel);
    public function createForm(Materiel $materiel);
    public function createView();
}

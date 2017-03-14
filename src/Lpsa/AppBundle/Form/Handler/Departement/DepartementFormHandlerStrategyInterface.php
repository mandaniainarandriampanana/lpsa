<?php

namespace Lpsa\AppBundle\Form\Handler\Departement;

use Lpsa\AppBundle\Entity\Departement;
use Symfony\Component\HttpFoundation\Request;

interface DepartementFormHandlerStrategyInterface {
    public function handleForm(Request $request, Departement $departement);
    public function createForm(Departement $departement);
    public function createView();
}

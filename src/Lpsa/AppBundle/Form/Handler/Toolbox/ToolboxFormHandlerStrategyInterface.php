<?php

namespace Lpsa\AppBundle\Form\Handler\Toolbox;

use Lpsa\AppBundle\Entity\Toolbox;
use Symfony\Component\HttpFoundation\Request;

interface ToolboxFormHandlerStrategyInterface {
    public function handleForm(Request $request, Toolbox $toolbox);
    public function createForm(Toolbox $toolbox);
    public function createView();
}

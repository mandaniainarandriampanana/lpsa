<?php

namespace Lpsa\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Configuration controller.
 *
 */
class ConfigurationController extends Controller
{
    /**
     * Lists all menu Configuration.
     *
     */
    public function indexAction()
    {

        return $this->render('LpsaAppBundle:Configuration:index.html.twig', array());
    }

}

<?php

namespace Lpsa\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Lpsa\AppBundle\Entity\HeureTravail;
use Lpsa\AppBundle\Entity\ObjectifLtirTrir;


/**
 * Cache controller.
 *
 */
class CacheController extends Controller
{
    /**
     * export Cache.
     *
     */
    public function clearAction(Request $request)
    {
        if($request->isMethod('POST')){
            $this->addFlash('success', 'Suppression cache prod, attendez quelques instants...');
            $dir = $this->get('kernel')->getRootDir() . '/cache/prod';
            register_shutdown_function(function() use ($dir) {
                `rm -rf $dir/*`;
            });
        }
        return $this->render('LpsaAppBundle:Cache:clear.html.twig', array());
    }
}

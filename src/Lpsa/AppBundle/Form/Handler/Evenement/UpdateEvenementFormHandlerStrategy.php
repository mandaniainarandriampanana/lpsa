<?php

namespace Lpsa\AppBundle\Form\Handler\Evenement;

use Lpsa\AppBundle\Entity\Evenement;
use Lpsa\AppBundle\Entity\EvenementHistorique;
use Symfony\Component\HttpFoundation\Request;

class UpdateEvenementFormHandlerStrategy extends AbstractEvenementFormHandlerStrategy{
    
    const COMMENT_LOG = 'Evènement mise à jour par: %s';
    
    public function createForm(Evenement $evenement,$route = 'admin_evenement_edit',$hasAccess = true)
    {
        $this->form = $this->formFactory->create($this->evenementType, $evenement, array(
            'action' => ($hasAccess) ? $this->router->generate($route,array('id' => $evenement->getId())) : '',
            'method' => ($hasAccess) ? 'PUT' : 'GET'
        ));
 
        return $this->form;
    }
    
    public function handleForm(Request $request, Evenement $evenement)
    {
        //set log
        $user = $this->getUser();
        $log = new EvenementHistorique();
        $log->setEvenement($evenement);
        $log->setUser($user);
        $log->setCommentaire(sprintf(self::COMMENT_LOG, $user->getUsername()));
        $this->em->persist($log);
        $this->evenementManager->save($evenement, false, true);

        return $this->translator->trans('evenement.flashes.edit.success', array(),'LpsaAppBundle', $request->getLocale());
    }
}

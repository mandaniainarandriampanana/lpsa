<?php

namespace Lpsa\AppBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Lpsa\AppBundle\Entity\Evenement;
use Lpsa\UserBundle\Entity\User;

class EventVoter extends Voter{
    
    const ADD = 'add';
    const EDIT = 'edit';
    const DELETE = 'delete';
    const DOWNLOAD = 'download';
    private $decisionManager;
    private $roleService;

    public function __construct(AccessDecisionManagerInterface $decisionManager,RoleService $roleService)
    {
        $this->decisionManager = $decisionManager;
        $this->roleService = $roleService;
    }
    
    protected function supports($attribute, $subject) {
        if (!in_array($attribute, array(self::ADD, self::EDIT,self::DELETE,self::DOWNLOAD))) {
            return false;
        }
        
        // only vote on Event objects inside this voter
        if (!$subject instanceof Evenement) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }
        // ROLE_SUPER_ADMIN can do anything! 
        if ($this->decisionManager->decide($token, array('ROLE_SUPER_ADMIN'))) {
            return true;
        }
        
        switch ($attribute) {
            case self::ADD:
                return $this->canAdd($subject, $user);
            case self::EDIT:
                return $this->canEdit($subject, $user);
            case self::DELETE:
                return $this->canDelete($subject, $user);
            case self::DOWNLOAD:
                return $this->canDownload($subject, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }
    
    private function canAdd(Evenement $event, User $user)
    {
        return true;
    }

    private function canDownload(Evenement $event, User $user)
    {
        if($this->isAdminSite($event,$user)){
            return true;
        } else {
            if($event->getUser()->getId() === $user->getId()){
                return true;
            }
            return $this->hasAccessGroup($event, $user);
        }
        return false;
    }

    private function canEdit(Evenement $event, User $user)
    {
        if($this->isAdminSite($event,$user)){
            return true;
        } else {
            if($event->getUser()->getId() === $user->getId()){
                return true;
            }
            return $this->hasAccessGroup($event, $user);
        }
        return false;
    }
    
    private function canDelete(Evenement $event, User $user)
    {
        //only superadmin
        /*
        if($this->isAdminSite($event,$user)){
            return true;
        } else {
            if($event->getUser()->getId() === $user->getId()){
                return true;
            }
            return $this->hasAccessGroup($event, $user);
        }
        */
        return false;
    }
    
    private function hasAccessGroup(Evenement $event, User $user){
        $groups = $user->getGroups();
        foreach($groups as $group){
            $depot = $group->getDepot();
            if($depot){
                if($event->getDepot()->getId() === $depot->getId()){
                    return true;
                }
            }
        }
        return false;
    }
    
    private function isInActionProgress(Evenement $event, User $user){
        $actionProgress = $event->getEvenementActionProgres();
        foreach($actionProgress as $action){
            $serviceManager = $action->getResponsableService();
            if($serviceManager){
                $users = $serviceManager->getUsers();
                foreach($users as $usr){
                    if($usr->getId() === $user->getId()){
                        return true;
                    }
                }
            }
        }
        return false;
    }

    private function isAdminSite(Evenement $event, User $user){
        //exception multiple roles 
        $roles = $user->getRoles();
        $paq3se = $event->getPaq3se(); 
        if(in_array('ROLE_PAQSSSE',$roles)){
            if(($paq3se && $paq3se->getIsPaqssse()) || in_array('ROLE_ADMIN',$roles)){
                return true;
            } else {
                return false;
            }
        }
        if(in_array('ROLE_ADMIN',$roles)){//groupe remonté
            if($paq3se && $paq3se->getIsPaqssse()){//PAQSSSE event
                return false;
            } else {
                return true;
            }
        }
        return false;
    }
}
